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
            ->paginate(2);

        // Retorna a view 'history' (ou 'essays.index', dependendo de como você nomeou)
        // e passa a coleção de redações para ela
        return view('history', compact('essays'));
    }
}
