<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MilenaChatbotController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\EssayController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rota inicial da aplicação (página de boas-vindas)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas que exigem autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Redação
    // Página de Histórico (Minhas Redações)
    Route::get('/redacoes', [EssayController::class, 'index'])->name('history');

    // Formulário de Envio/Edição de Redação
    // A rota '/redacoes/enviar-redacao' sem {essay?} serve para criar uma nova.
    // Com {essay?}, serve para editar uma existente.
    Route::get('/redacoes/enviar-redacao/{essay?}', [EssayController::class, 'createEdit'])->name('submit-essay');

    // --- ROTA 'ESSAY.EDIT' REINTRODUZIDA AQUI ---
    // Esta rota serve para o caso onde você quer um nome de rota específico para a edição,
    // e aponta para o mesmo método createEdit que lida com a exibição do formulário.
    Route::get('/essay/{essay}/edit', [EssayController::class, 'createEdit'])->name('essay.edit');
    // ------------------------------------------

    // Rotas para o auto-salvamento de rascunhos (chamadas via AJAX/Inertia form.post)
    Route::post('/essay/store-draft', [EssayController::class, 'autoSave'])->name('essay.store-draft');
    Route::post('/essay/update-draft', [EssayController::class, 'autoSave'])->name('essay.update-draft');

    // Rota para armazenar uma nova redação (submissão final - POST)
    Route::post('/essay', [EssayController::class, 'store'])->name('essay.store');

    // Rota para atualizar uma redação existente (submissão final - PUT)
    Route::put('/essay/{essay}', [EssayController::class, 'store'])->name('essay.update');

    // Página de Feedback da Redação
    Route::get('/redacoes/{essay}/feedback', [EssayController::class, 'showFeedback'])->name('essay.feedback');

    // Configurações (exemplo, se for uma view Blade ou Inertia)
    Route::get('/configuracoes', function () {
        return view('settings'); // Ou Inertia::render('Settings');
    })->name('settings');

    // Milena Chatbot
    Route::get('/chat-milena', function () {
        return Inertia::render('Chat'); // Assumindo que você criou 'resources/js/Pages/Chat.vue'
    })->name('chat.milena');

    Route::get('/milena/start-chat', [MilenaChatbotController::class, 'startChat'])->name('milena.start');
    Route::post('/milena/message', [MilenaChatbotController::class, 'sendMessage'])->name('milena.send');

    // Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas exclusivas para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Painel do administrador';
    });
});

// Inclui as rotas de autenticação padrão do Laravel (login, register, reset password, etc.)
require __DIR__ . '/auth.php';
