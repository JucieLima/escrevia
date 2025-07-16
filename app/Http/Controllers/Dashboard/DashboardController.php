<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Retorna a página Dashboard.vue via Inertia
        return Inertia::render('Dashboard', [
            // Você pode passar props específicas para o componente Dashboard aqui, se precisar
            // 'someData' => 'Hello from controller',
        ]);
    }
}
