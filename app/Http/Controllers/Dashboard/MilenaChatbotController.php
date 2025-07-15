<?php

namespace App\Http\Controllers;

use App\Services\MilenaChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Para acessar o usuário logado

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
        $user = Auth::user(); // Pega o usuário logado
        $response = $this->milenaService->startUserSession($user); // Chama o serviço da Milena
        return response()->json($response); // Retorna a resposta para o frontend
    }

    // Método para processar mensagens enviadas pelo usuário para a Milena
    public function sendMessage(Request $request)
    {
        // Validação básica dos dados recebidos
        $request->validate([
            'message' => 'required|string',
            'session_id' => 'nullable|string', // É importante que o frontend envie o session_id
        ]);

        $user = Auth::user();
        $message = $request->input('message');
        $sessionId = $request->input('session_id');

        $response = $this->milenaService->handleUserResponse($user, $message, $sessionId); // Envia a mensagem do usuário para o serviço da Milena
        return response()->json($response); // Retorna a resposta da Milena para o frontend
    }
}
