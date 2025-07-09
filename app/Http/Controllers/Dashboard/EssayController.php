<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Essay;

// Importe o modelo Essay
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Para acessar o usuário logado
use Illuminate\View\View;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Parsedown;

class EssayController extends Controller
{
    /**
     * Exibe uma lista das redações do usuário logado.
     *
     * @return View
     */
    public function index(): View
    {
        // Pega o ID do usuário logado
        $userId = Auth::id();

        // Busca todas as redações que pertencem ao usuário logado
        // Ordena pelas mais recentes primeiro
        $essays = Essay::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Retorna a view 'history' (ou 'essays.index', dependendo de como você nomeou)
        // e passa a coleção de redações para ela
        return view('history', compact('essays'));
    }


    /**
     * Exibe a página de feedback para uma redação específica.
     *
     * @param \App\Models\Essay $essay
     * @return \Illuminate\View\View
     */
    public function showFeedback(Essay $essay)
    {
        // 1. Verificar se a redação pertence ao usuário logado (segurança)
        if ($essay->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a esta redação.');
        }

        // 2. Carregar os relacionamentos necessários
        // Usamos with() para eager load e evitar o problema N+1 queries
        $essay->load(['competencyFeedbacks', 'interventions']);

        // 3. Passar a redação e seus feedbacks para a view
        return view('essay-feedback', compact('essay'));
    }

    /**
     * Store or update an essay, either as a draft or for analysis.
     * Agora unifica a lógica de criação e atualização para o formulário.
     */
    public function store(Request $request)
    {
        $action = $request->input('action'); // 'draft' or 'submit'

        // Regras de validação
        $rules = [
            'essay_id' => 'nullable|exists:essays,id', // Opcional, para identificar rascunhos existentes
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'content' => 'required|string',
        ];

        // Se for submissão final, o conteúdo precisa ser mais substancial
        if ($action === 'submit') {
            $rules['content'] .= '|min:100'; // Exemplo: mínimo de 100 caracteres para análise
        }

        $validated = $request->validate($rules);

        $user = Auth::user();

        // Encontrar a redação existente ou criar uma nova
        if (isset($validated['essay_id']) && $validated['essay_id']) {
            // Tentamos encontrar a redação que pertence ao usuário logado
            $essay = $user->essays()->where('id', $validated['essay_id'])->first();

            if (!$essay) {
                // Se a redação não for encontrada ou não pertencer ao usuário, aborta.
                // Isso é uma medida de segurança.
                abort(403, 'Redação não encontrada ou você não tem permissão para editá-la.');
            }
        } else {
            // Se não houver essay_id, é uma nova redação
            $essay = new Essay();
            $essay->user_id = $user->id;
        }

        // Atualiza os dados da redação com os valores validados
        $essay->title = $validated['title'];
        $essay->theme = $validated['theme'];
        $essay->content = $validated['content'];

        if ($action === 'draft') {
            $essay->status = 'draft';
            $essay->save();
            // Após salvar/atualizar o rascunho, redirecionamos para a rota de edição
            // para que o auto-save continue funcionando.
            return redirect()->route('essay.edit', $essay->id)->with('success', 'Rascunho salvo com sucesso!');
        } else { // action is 'submit'
            $essay->status = 'pending_analysis'; // Define status para indicar processamento
            $essay->save(); // Salva a atualização antes de enviar para a IA

            if ($this->analyzeEssayWithIA($essay)) {
                // analyzeEssayWithIA já atualiza o status para 'corrected' se for bem-sucedido
                return redirect()->route('essay.showFeedback', $essay->id)->with('success', 'Redação enviada para análise e corrigida com sucesso!');
            } else {
                // Se a análise falhar, atualiza o status de volta
                $essay->status = 'analysis_failed';
                $essay->save();
                return redirect()->back()->with('error', 'Houve um erro ao analisar sua redação. Por favor, tente novamente mais tarde.');
            }
        }
    }

    public function create()
    {
        return view('submit-essay');
    }

    /**
     * Envia a redação para análise de IA e atualiza o modelo Essay.
     * @param Essay $essay
     * @return bool Retorna true se a análise for bem-sucedida, false caso contrário.
     */
    /**
     * Envia a redação para análise de IA e atualiza o modelo Essay.
     * @param Essay $essay
     * @return bool Retorna true se a análise for bem-sucedida, false caso contrário.
     */
    protected function analyzeEssayWithIA(Essay $essay): bool
    {
        $apiKey = env('IA_API_KEY');
        if (!$apiKey) {
            Log::error('IA_API_KEY não configurada no ambiente. Não é possível analisar a redação.');
            return false;
        }

        // Mapeamento dos nomes curtos para os nomes completos das competências
        $competencyNamesMap = [
            'C1' => 'Domínio da norma culta',
            'C2' => 'Compreensão do tema',
            'C3' => 'Argumentação',
            'C4' => 'Coesão',
            'C5' => 'Proposta de intervenção',
        ];

        try {
            // O prompt atualizado com as tags
            $prompt = "Você é um professor especialista em correção de redações do ENEM, com amplo conhecimento nas competências avaliadas pelo INEP. Sua tarefa é analisar a redação abaixo, atribuir notas de 0 a 200 para cada uma das 5 competências e fornecer um feedback detalhado, apontando pontos fortes, áreas de melhoria e sugestões claras para evolução.

            **O tema da redação é: " . $essay->theme . "**

            As competências a serem avaliadas são:
            C1: Domínio da norma culta
            C2: Compreensão do tema
            C3: Argumentação
            C4: Coesão
            C5: Proposta de intervenção

            **Instruções de Formatação da Resposta:**
            Siga exatamente este formato para a sua resposta. Use as tags delimitadoras para cada seção.

            <NOTAS_COMPETENCIAS>
            C1: [nota_numerica] - [Justificativa breve da C1]
            C2: [nota_numerica] - [Justificativa breve da C2]
            C3: [nota_numerica] - [Justificativa breve da C3]
            C4: [nota_numerica] - [Justificativa breve da C4]
            C5: [nota_numerica] - [Justificativa breve da C5]
            </NOTAS_COMPETENCIAS>

            <PONTUACAO_TOTAL>
            Pontuação Total: [soma_das_notas]
            </PONTUACAO_TOTAL>

            <FEEDBACK_DETALHADO>
            **Pontos Fortes:**
            - [Ponto forte 1]
            - [Ponto forte 2]
            ...

            **Áreas de Melhoria e Erros Recorrentes:**
            - [Erro 1 e área de melhoria]
            - [Erro 2 e área de melhoria]
            ...

            **Sugestões Práticas para Evolução:**
            - [Sugestão 1]
            - [Sugestão 2]
            ...
            </FEEDBACK_DETALHADO>

            **Redação para análise:**
            \"" . $essay->content . "\"";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])
                ->withOptions(['verify' => 'C:\wamp64\bin\php\php8.3.14\extras\ssl\cacert.pem'])
                ->timeout(90)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 1500,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $iaResponse = $response->json();
                $analysisText = $iaResponse['choices'][0]['message']['content'] ?? '';

                if (empty($analysisText)) {
                    Log::warning('Resposta vazia da API da OpenAI para a redação ID: ' . $essay->id);
                    return false;
                }

                // Crie uma instância do Parsedown
                $parsedown = new Parsedown();

                // --- Parsing da Resposta da IA ---

                // 1. Extrair Pontuação Total
                $overallScore = null;
                if (preg_match('/<PONTUACAO_TOTAL>\s*Pontuação Total:\s*(\d+)\s*<\/PONTUACAO_TOTAL>/s', $analysisText, $matches)) {
                    $overallScore = (int)$matches[1];
                } else {
                    Log::warning('Não foi possível extrair a Pontuação Total da resposta da IA para a redação ID: ' . $essay->id);
                }

                // 2. Extrair Notas das Competências e Justificativas
                $notesSection = null;
                if (preg_match('/<NOTAS_COMPETENCIAS>(.*?)<\/NOTAS_COMPETENCIAS>/s', $analysisText, $matches)) {
                    $notesSection = trim($matches[1]);
                } else {
                    Log::warning('Não foi possível extrair a seção NOTAS_COMPETENCIAS da resposta da IA para a redação ID: ' . $essay->id);
                }

                if ($notesSection) {
                    // Limpa feedbacks de competências anteriores se houver (útil em retries)
                    $essay->competencyFeedbacks()->delete();

                    preg_match_all('/(C\d+):\s*(\d+)\s*-\s*(.*)/m', $notesSection, $matches, PREG_SET_ORDER);
                    foreach ($matches as $match) {
                        $competencyShortName = trim($match[1]); // Ex: "C1"
                        $score = (int)$match[2];
                        $feedbackText = trim($match[3]);

                        // Converte o feedback individual da competência de Markdown para HTML
                        $feedbackTextHtml = $parsedown->text($feedbackText);

                        // Mapeia o nome curto para o nome completo
                        $competencyFullName = $competencyNamesMap[$competencyShortName] ?? $competencyShortName;

                        // Cria um novo registro CompetencyFeedback
                        $essay->competencyFeedbacks()->create([
                            'competency_name' => $competencyFullName, // Usando o nome completo
                            'score' => $score,
                            'feedback_text' => $feedbackTextHtml, // Salva o HTML
                        ]);
                    }
                }

                // 3. Extrair Feedback Detalhado
                $detailedFeedback = null;
                if (preg_match('/<FEEDBACK_DETALHADO>(.*?)<\/FEEDBACK_DETALHADO>/s', $analysisText, $matches)) {
                    $detailedFeedback = trim($matches[1]);
                    // Converte o feedback detalhado de Markdown para HTML
                    $detailedFeedbackHtml = $parsedown->text($detailedFeedback);
                } else {
                    Log::warning('Não foi possível extrair a seção FEEDBACK_DETALHADO da resposta da IA para a redação ID: ' . $essay->id);
                }

                // --- Fim do Parsing ---

                // Atualizar os campos da redação principal
                $essay->overall_score = $overallScore;
                $essay->ia_feedback = $detailedFeedbackHtml ?? null; // Armazena o feedback detalhado completo, já em HTML
                $essay->analyzed_at = now();
                $essay->status = 'corrected';
                $essay->save();

                return true;

            } else {
                $errorDetails = $response->json()['error']['message'] ?? 'Erro desconhecido na API da OpenAI.';
                Log::error('Erro na API da OpenAI (status: ' . $response->status() . '): ' . $errorDetails . ' | Resposta completa: ' . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Exceção ao comunicar com a API da OpenAI: ' . $e->getMessage() . ' | Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            return false;
        }
    }

    /**
     * Display the specified essay for editing (drafts).
     * Você precisará criar esta view resources/views/edit-essay.blade.php
     * ou adaptar submit-essay.blade.php para ser um template para ambos.
     */
    public function edit(Essay $essay)
    {
        // Certifique-se que o usuário tem permissão para editar esta redação
        if ($essay->user_id !== Auth::id()) {
            abort(403);
        }

        return view('submit-essay', compact('essay')); // Ou 'submit-essay' se for um template único
    }

    /**
     * Handles AJAX auto-saving of essay drafts.
     */
    public function autoSaveDraft(Request $request)
    {
        $validated = $request->validate([
            'essay_id' => 'nullable|exists:essays,id', // Pode ser nulo para novos rascunhos
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $user = Auth::user();

        // Encontrar a redação existente ou criar uma nova
        if (isset($validated['essay_id']) && $validated['essay_id']) {
            $essay = $user->essays()->where('id', $validated['essay_id'])->first();
            if (!$essay) {
                // Segurança: se o ID foi enviado mas não pertence ao usuário
                return response()->json(['success' => false, 'message' => 'Rascunho não encontrado ou você não tem permissão para editá-lo.'], 403);
            }
        } else {
            // É um novo rascunho, crie uma nova instância
            $essay = new Essay();
            $essay->user_id = $user->id;
        }

        $essay->title = $validated['title'];
        $essay->theme = $validated['theme'];
        $essay->content = $validated['content'];
        $essay->status = 'draft'; // Sempre 'draft' para auto-save
        $essay->save();

        // Retorna o ID da redação (novo ou existente) para o frontend
        return response()->json(['success' => true, 'message' => 'Rascunho salvo!', 'essay_id' => $essay->id]);
    }
}
