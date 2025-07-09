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

    public function store(Request $request)
    {
        // 1. Validação dos dados de entrada
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255', // Título: opcional, string, max 255 caracteres
            'content' => 'required|string|min:50|max:10000', // Conteúdo: obrigatório, string, min 50, max 10.000 caracteres
            // Ajuste o 'max' para content conforme sua necessidade real para 30 linhas + folga.
            // 10.000 caracteres é uma boa folga para muitas redações.
        ]);

        $title = $validatedData['title'];
        $content = $validatedData['content'];

        // 2. Lógica para gerar o título se não fornecido
        if (empty($title)) {
            preg_match('/^(.+?[.!?])(?:\s|$)/s', $content, $matches);
            if (isset($matches[1])) {
                $title = Str::limit(trim($matches[1]), 100, '...');
            } else {
                $title = Str::limit(trim($content), 100, '...');
            }
            $title = Str::limit($title, 255); // Garante que não exceda o limite da coluna
        }

        // 3. Salvar a redação no banco de dados
        $essay = Essay::create([
            'user_id' => auth()->id(),
            'title' => $title,
            'content' => $content,
            'status' => 'pending_evaluation',
        ],
            // Mensagens personalizadas (se precisar de algo muito específico para a regra)
            [
                'content.required' => 'Por favor, digite sua redação.',
            ],
            // Nomes de atributos personalizados (aqui é onde você muda o nome do campo)
            [
                'title' => 'título',
                'content' => 'redação',
            ]
        );

        // Chama a função para analisar a redação imediatamente após o salvamento
        $analysisResult = $this->analyzeEssayWithIA($essay);

        if (!$analysisResult) {
            // Se houver um erro na análise da IA, podemos adicionar uma mensagem ou logar
            // Por enquanto, vamos apenas redirecionar com uma mensagem de erro genérica
            return redirect()->route('history')->with('error', 'Redação enviada, mas houve um problema ao processá-la pela IA. Tente novamente mais tarde ou contate o suporte.');
        }

        // 4. Redirecionar com mensagem de sucesso
        return redirect()->route('history')->with('success', 'Redação enviada e encaminhada para análise!');
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

            C1: Domínio da escrita formal da Língua Portuguesa.
            C2: Compreensão da proposta de redação
            C3: Organização das ideias e defesa do ponto de vista
            C4: Conhecimento dos mecanismos linguísticos para a construção da argumentação
            C5: Apresentação de proposta de intervenção

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
            ])->timeout(90)->post('https://api.openai.com/v1/chat/completions', [
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

                // --- Parsing da Resposta da IA ---

                // 1. Extrair Pontuação Total
                $overallScore = null;
                if (preg_match('/<PONTUACAO_TOTAL>\s*Pontuação Total:\s*(\d+)\s*<\/PONTUACAO_TOTAL>/s', $analysisText, $matches)) {
                    $overallScore = (int) $matches[1];
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
                        $score = (int) $match[2];
                        $feedbackText = trim($match[3]);

                        // Mapeia o nome curto para o nome completo
                        $competencyFullName = $competencyNamesMap[$competencyShortName] ?? $competencyShortName;

                        // Cria um novo registro CompetencyFeedback
                        $essay->competencyFeedbacks()->create([
                            'competency_name' => $competencyFullName, // Usando o nome completo
                            'score' => $score,
                            'feedback_text' => $feedbackText,
                        ]);
                    }
                }

                // 3. Extrair Feedback Detalhado
                $detailedFeedback = null;
                if (preg_match('/<FEEDBACK_DETALHADO>(.*?)<\/FEEDBACK_DETALHADO>/s', $analysisText, $matches)) {
                    $detailedFeedback = trim($matches[1]);
                } else {
                    Log::warning('Não foi possível extrair a seção FEEDBACK_DETALHADO da resposta da IA para a redação ID: ' . $essay->id);
                }

                // --- Fim do Parsing ---

                // Atualizar os campos da redação principal
                $essay->overall_score = $overallScore;
                $essay->ia_feedback = $detailedFeedback; // Armazena o feedback detalhado completo
                $essay->analyzed_at = now();
                $essay->status = 'corrected'; // <--- ALTERADO PARA 'corrected'
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
}
