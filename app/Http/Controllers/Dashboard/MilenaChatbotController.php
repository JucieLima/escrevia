<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\MilenaChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MilenaChatbotController extends Controller
{
    protected $milenaService;

    public function __construct(MilenaChatbotService $milenaService)
    {
        $this->milenaService = $milenaService;
    }

    /*
     * Método para iniciar a conversa da Milena (chamado, por exemplo, após o login ou ao carregar a página do chat)
     */
    public function startChat(Request $request)
    {
        return Inertia::render('Chat');
    }

    // Método para processar mensagens enviadas pelo usuário para a Milena
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            // Se você passar histórico de mensagens, adicione validação aqui:
            'history' => 'nullable|array',
            'history.*.role' => 'required|in:user,assistant',
            'history.*.content' => 'required|string',
        ]);

        $userMessage = $validated['message'];
        $aiResponse = '';

        // Chave de API da OpenAI (certifique-se de que está no seu .env)
        $apiKey = env('OPENAI_API_KEY'); // Use OPENAI_API_KEY para ser específico
        if (!$apiKey) {
            Log::error('OPENAI_API_KEY não configurada no ambiente. Não é possível gerar resposta do chatbot.');
            return response()->json([
                'user_message' => $userMessage,
                'ai_response' => 'Desculpe, a Milena está offline no momento. Por favor, tente novamente mais tarde. (Erro: API Key ausente)'
            ], 500);
        }

        try {
            // System prompt para instruir a IA sobre a SDT e o papel da Milena
            $systemPrompt = "Você é a Milena, uma assistente de estudo de redação amigável, atenciosa e motivadora, baseada nos princípios da Teoria da Autodeterminação (SDT).
            Seu objetivo é ajudar os usuários a melhorar suas redações, fornecendo suporte e orientação que promova a motivação intrínseca.
            Sempre busque:
            1.  **Apoiar a Autonomia:** Ofereça escolhas e opções ao usuário, valide seus sentimentos e perspectivas, e evite qualquer linguagem controladora ou imperativa. Use frases como: 'Você decide...', 'O que você prefere explorar?', 'Entendo como você se sente...'
            2.  **Apoiar a Competência:** Forneça feedback construtivo e específico, celebre pequenos progressos, foque no processo de aprendizagem e sugira próximos passos alcançáveis. Use frases como: 'Você demonstrou um bom domínio em...', 'Um ótimo próximo passo seria...', 'Você está progredindo muito!'
            3.  **Apoiar o Relacionamento:** Demonstre empatia, cuidado e interesse genuíno pelo bem-estar do usuário. Crie um ambiente seguro e de apoio. Use frases como: 'Estou aqui para te ajudar no que precisar.', 'Como posso te apoiar nisso?', 'Vamos descobrir isso juntos.'
            Mantenha suas respostas concisas, encorajadoras e com um tom positivo e conversacional. Adapte-se ao contexto da conversa e à necessidade do usuário. Se o usuário perguntar sobre uma redação, direcione-o para a página de feedback ou ofereça para guiá-lo no entendimento de seu feedback.";


            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                // Aqui você adicionaria o histórico de mensagens, se estivesse gerenciando estado de chat.
                // Exemplo com histórico (assumindo que $validated['history'] exista e contenha mensagens):
                array_map(fn($msg) => ['role' => $msg['role'], 'content' => $msg['content']], $validated['history']),
                ['role' => 'user', 'content' => $userMessage]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])
                // Se você usou o certificado customizado para a OpenAI antes, mantenha aqui também.
                // Cuidado com caminhos fixos! Idealmente, configure isso globalmente ou no Http client.
                ->withOptions(['verify' => 'C:\\wamp64\\bin\\php\\php8.3.14\\extras\\ssl\\cacert.pem'])
                ->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo', // Ou gpt-4, se preferir e tiver acesso
                    'messages' => $messages,
                    'max_tokens' => 500, // Ajuste conforme a necessidade de respostas do chat
                    'temperature' => 0.7, // Um pouco mais de criatividade para um chat
                ]);

            if ($response->successful()) {
                $responseData = $response->json();
                // A resposta da OpenAI vem em choices[0].message.content
                $aiResponse = $responseData['choices'][0]['message']['content'] ?? 'Desculpe, não consegui gerar uma resposta agora.';
            } else {
                Log::error("Erro na API da OpenAI para Milena: " . $response->body());
                $aiResponse = 'Desculpe, a Milena está com problemas técnicos. Por favor, tente novamente mais tarde.';
            }

        } catch (\Exception $e) {
            Log::error("Exceção ao chamar API da OpenAI para Milena: " . $e->getMessage());
            $aiResponse = 'Desculpe, houve um erro inesperado ao processar sua solicitação.';
        }

        return response()->json([
            'user_message' => $userMessage,
            'ai_response' => $aiResponse,
        ]);
    }
}
