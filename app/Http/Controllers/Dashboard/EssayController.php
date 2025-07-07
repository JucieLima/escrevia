<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Essay; // Importe o modelo Essay
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para acessar o usuário logado
use Illuminate\View\View;

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
     * @param  \App\Models\Essay  $essay
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
}
