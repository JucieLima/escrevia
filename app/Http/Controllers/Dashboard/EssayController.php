<?php

namespace App\Http\Controllers\Dashboard;
// Verifique seu namespace, pode ser apenas App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Essay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Não usado no código fornecido, pode remover se não for usar
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Parsedown;

class EssayController extends Controller
{
    /**
     * Exibe uma lista das redações do usuário logado.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $userId = Auth::id();

        $essays = Essay::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            // Para garantir que o Inertia possa serializar a coleção
            // ou você pode transformar no frontend
            ->through(fn($essay) => [
                'id' => $essay->id,
                'title' => $essay->title,
                'theme' => $essay->theme,
                'status' => $essay->status,
                'overall_score' => $essay->overall_score,
                'created_at' => $essay->created_at->format('d/m/Y H:i'),
                // Adicione outros campos que você precisa exibir no `History.vue`
            ]);

        return Inertia::render('History', [
            'essays' => $essays,
            'flash' => session()->only(['success', 'error']), // Passa flash messages
        ]);
    }

    /**
     * Exibe o formulário de criação ou edição de redação.
     * Unifica os antigos métodos `create` e `edit`.
     *
     * @param \App\Models\Essay|null $essay
     * @return \Inertia\Response
     */
    public function createEdit(Essay $essay = null): \Inertia\Response
    {
        // Se uma redação foi passada (para edição), verifique se pertence ao usuário logado
        if ($essay && $essay->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a esta redação.');
        }

        return Inertia::render('SubmitEssay', [
            // Passa o objeto essay (ou null se for uma nova redação) para a página Vue
            'essay' => $essay ? $essay->toArray() : null,
            // Passa erros de validação (se houver redirecionamento com erros)
            'errors' => session('errors') ? session('errors')->getBag('default')->toArray() : [],
            // Passa mensagens flash
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
                'essay_id' => session('essay_id'), // Para auto-save retornar ID de nova redação
            ],
        ]);
    }

    /**
     * Store or update an essay, either as a draft or for analysis.
     * Unifica a lógica de criação e atualização para o formulário.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $action = $request->input('action'); // 'draft' or 'submit'

        $rules = [
            'essay_id' => 'nullable|exists:essays,id,user_id,' . Auth::id(), // Garante que o ID existe E pertence ao user logado
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'content' => 'required|string',
        ];

        if ($action === 'submit') {
            $rules['content'] .= '|min:100'; // Mínimo de 100 caracteres para análise
        }

        $validated = $request->validate($rules);

        $user = Auth::user();
        $essay = null;

        // Encontrar a redação existente ou criar uma nova
        if (isset($validated['essay_id']) && $validated['essay_id']) {
            $essay = $user->essays()->where('id', $validated['essay_id'])->first();
            if (!$essay) {
                abort(403, 'Redação não encontrada ou você não tem permissão para editá-la.');
            }
        } else {
            $essay = new Essay();
            $essay->user_id = $user->id;
        }

        $essay->title = $validated['title'];
        $essay->theme = $validated['theme'];
        $essay->content = $validated['content'];

        if ($action === 'draft') {
            $essay->status = 'draft';
            $essay->save();

            // Retorna Inertia::render para permanecer na mesma página, atualizando as props
            return Inertia::render('SubmitEssay', [
                'essay' => $essay->toArray(),
                'flash' => [
                    'success' => 'Rascunho salvo com sucesso!',
                    'essay_id' => $essay->id, // Essencial para o auto-save de novas redações
                ],
                'errors' => [], // Limpa erros de validação anteriores
            ]);
        } else { // action is 'submit'
            $essay->status = 'pending_correction'; // Mudei para 'pending_correction' para consistência
            $essay->save(); // Salva antes de enviar para a IA

            if ($this->analyzeEssayWithIA($essay)) {
                // CORREÇÃO AQUI: Usar session()->flash() e Inertia::location()
                session()->flash('success', 'Redação enviada para análise e corrigida com sucesso!');
                return Inertia::location(route('essay.feedback', $essay->id));
            } else {
                $essay->status = 'analysis_failed';
                $essay->save();
                session()->flash('error', 'Houve um erro ao analisar sua redação. Por favor, tente novamente mais tarde.');
                return Inertia::location(route('submit-essay', $essay->id));
            }
        }
    }

    /**
     * Handles AJAX auto-saving of essay drafts.
     * Renomeado de autoSaveDraft para autoSave para consistência com o que o Vue espera.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function autoSave(Request $request) // Renomeado
    {
        $validated = $request->validate([
            'essay_id' => 'nullable|exists:essays,id,user_id,' . Auth::id(), // Garante que o ID existe E pertence ao user logado
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $essay = null;

        if (isset($validated['essay_id']) && $validated['essay_id']) {
            $essay = $user->essays()->where('id', $validated['essay_id'])->first();
            if (!$essay) {
                return response()->json(['success' => false, 'message' => 'Rascunho não encontrado ou você não tem permissão para editá-lo.'], 403);
            }
        } else {
            $essay = new Essay();
            $essay->user_id = $user->id;
        }

        $essay->title = $validated['title'];
        $essay->theme = $validated['theme'];
        $essay->content = $validated['content'];
        $essay->status = 'draft';
        $essay->save();

        return Inertia::render('SubmitEssay', [
            'essay' => $essay->toArray(), // Passa a redação atualizada
            'flash' => [
                'success' => 'Rascunho salvo!',
                'essay_id' => $essay->id, // Essencial para o frontend pegar o ID de um novo rascunho
            ],
            // É importante passar os erros vazios para limpar qualquer erro anterior
            'errors' => session('errors') ? session('errors')->getBag('default')->toArray() : [],
        ]);
    }

    /**
     * Exibe a página de feedback para uma redação específica.
     *
     * @param \App\Models\Essay $essay
     * @return \Inertia\Response
     */
    public function showFeedback(Essay $essay): \Inertia\Response
    {
        if ($essay->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a esta redação.');
        }

        $essay->load(['competencyFeedbacks', 'interventions']);

        // Converte o feedback para HTML usando Parsedown, se não estiver já no banco
        // Assumo que $essay->ia_feedback já é HTML se foi gerado e salvo por analyzeEssayWithIA
        $parsedown = new Parsedown();
        if ($essay->ia_feedback && !Str::startsWith(trim($essay->ia_feedback), '<')) { // Verifica se parece HTML
            $essay->ia_feedback = $parsedown->text($essay->ia_feedback);
        }

        foreach ($essay->competencyFeedbacks as $feedback) {
            if ($feedback->feedback_text && !Str::startsWith(trim($feedback->feedback_text), '<')) {
                $feedback->feedback_text = $parsedown->text($feedback->feedback_text);
            }
        }

        return Inertia::render('EssayFeedback', [ // Assumindo que você criará EssayFeedback.vue
            'essay' => $essay->toArray(),
            'flash' => session()->only(['success', 'error']),
        ]);
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

        $competencyNamesMap = [
            'C1' => 'Domínio da norma culta',
            'C2' => 'Compreensão do tema',
            'C3' => 'Argumentação',
            'C4' => 'Coesão',
            'C5' => 'Proposta de intervenção',
        ];

        try {
            $prompt = "Você é um professor especialista em correção de redações do ENEM, com amplo conhecimento nas
            competências avaliadas pelo INEP. Sua tarefa é analisar a redação abaixo seguindo rigorosamente as
            diretrizes oficiais, com tolerância apenas para desvios que não comprometam a compreensão textual, conforme
            os manuais de correção. Quando não houver  erros graves ou quando forem aceitáveis pelos critérios,
            ofereça dicas de aprimoramento em vez de descontar pontos. Além disso, você deve fornecer um feedback
            detalhado, apontando pontos fortes, áreas de melhoria e sugestões claras para evolução.

            **O tema da redação é: " . $essay->theme . "**

            **Instruções específicas:**

            As competências a serem avaliadas são:
            C1: Domínio da norma culta
            C2: Compreensão do tema
            C3: Argumentação
            C4: Coesão
            C5: Proposta de intervenção

            1. **Siga a tabela de níveis (0-200) por competência** do INEP, considerando:

            2. **Priorize feedback construtivo**:

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
                ->withOptions(['verify' => 'C:\\wamp64\\bin\\php\\php8.3.14\\extras\\ssl\\cacert.pem']) // Cuidado com caminhos fixos!
                ->timeout(90)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 1500,
                    'temperature' => 0.0,
                ]);

            if ($response->successful()) {
                $iaResponse = $response->json();
                $analysisText = $iaResponse['choices'][0]['message']['content'] ?? '';

                if (empty($analysisText)) {
                    Log::warning('Resposta vazia da API da OpenAI para a redação ID: ' . $essay->id);
                    return false;
                }

                $parsedown = new Parsedown();

                $overallScore = null;
                if (preg_match('/<PONTUACAO_TOTAL>\s*Pontuação Total:\s*(\d+)\s*<\/PONTUACAO_TOTAL>/s', $analysisText, $matches)) {
                    $overallScore = (int)$matches[1];
                } else {
                    Log::warning('Não foi possível extrair a Pontuação Total da resposta da IA para a redação ID: ' . $essay->id);
                }

                $notesSection = null;
                if (preg_match('/<NOTAS_COMPETENCIAS>(.*?)<\/NOTAS_COMPETENCIAS>/s', $analysisText, $matches)) {
                    $notesSection = trim($matches[1]);
                } else {
                    Log::warning('Não foi possível extrair a seção NOTAS_COMPETENCIAS da resposta da IA para a redação ID: ' . $essay->id);
                }

                if ($notesSection) {
                    $essay->competencyFeedbacks()->delete();

                    preg_match_all('/(C\d+):\s*(\d+)\s*-\s*(.*)/m', $notesSection, $matches, PREG_SET_ORDER);
                    foreach ($matches as $match) {
                        $competencyShortName = trim($match[1]);
                        $score = (int)$match[2];
                        $feedbackText = trim($match[3]);

                        $feedbackTextHtml = $parsedown->text($feedbackText);

                        $competencyFullName = $competencyNamesMap[$competencyShortName] ?? $competencyShortName;

                        $essay->competencyFeedbacks()->create([
                            'competency_name' => $competencyFullName,
                            'score' => $score,
                            'feedback_text' => $feedbackTextHtml,
                        ]);
                    }
                }

                $detailedFeedback = null;
                if (preg_match('/<FEEDBACK_DETALHADO>(.*?)<\/FEEDBACK_DETALHADO>/s', $analysisText, $matches)) {
                    $detailedFeedback = trim($matches[1]);
                    $detailedFeedbackHtml = $parsedown->text($detailedFeedback);
                } else {
                    Log::warning('Não foi possível extrair a seção FEEDBACK_DETALHADO da resposta da IA para a redação ID: ' . $essay->id);
                }

                $essay->overall_score = $overallScore;
                $essay->ia_feedback = $detailedFeedbackHtml ?? null;
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
}
