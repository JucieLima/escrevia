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

        // 4. Redirecionar com mensagem de sucesso
        return redirect()->route('history')->with('success', 'Redação enviada com sucesso!');
    }

    public function create()
    {
        return view('submit-essay');
    }

    public function analyzeEssay(Essay $essay)
    {
        $apiKey = env('IA_API_KEY');
        if (!$apiKey) {
            // Tratar erro: chave de API não configurada
            return back()->with('error', 'Chave de API da IA não configurada.');
        }

        try {
            // Preparar o prompt para a IA
            // Este é o "pedido" que você faz à IA.
            $prompt = "Analise a seguinte redação e forneça feedback construtivo, uma pontuação geral (0-1000) e sugestões de melhoria em termos de estrutura, coesão, coerência, gramática e vocabulário. Redação: \n\n\"" . $essay->content . "\"";

            // Enviar requisição para a API da IA (exemplo com OpenAI)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Ou 'gpt-4', 'gemini-pro', etc.
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 500, // Limite de tokens na resposta da IA
                'temperature' => 0.7, // Criatividade da resposta (0.0 a 1.0)
            ]);

            // Verificar se a requisição foi bem-sucedida
            if ($response->successful()) {
                $iaResponse = $response->json();
                $analysisText = $iaResponse['choices'][0]['message']['content'] ?? 'Análise indisponível.';

                // Aqui você processaria a resposta da IA e salvaria no banco de dados.
                // Por exemplo, você pode querer salvar a análise completa, a pontuação, etc.
                $essay->ia_feedback = $analysisText;
                // Ex: Extrair pontuação usando regex ou outra lógica
                // $essay->overall_score = $this->extractScore($analysisText);
                $essay->status = 'evaluated';
                $essay->save();

                return redirect()->route('feedback', $essay->id)->with('success', 'Redação analisada pela IA!');

            } else {
                // Erro na resposta da API
                $errorMessage = $response->json()['error']['message'] ?? 'Erro desconhecido na API da IA.';
                \Log::error("IA API Error: " . $errorMessage . " - " . $response->body());
                return back()->with('error', 'Erro ao analisar a redação: ' . $errorMessage);
            }

        } catch (\Exception $e) {
            // Capturar e logar exceções de rede ou outras
            \Log::error("Error communicating with IA API: " . $e->getMessage());
            return back()->with('error', 'Erro de comunicação com o serviço de IA. Tente novamente mais tarde.');
        }
    }
}
