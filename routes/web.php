<?php

use App\Http\Controllers\MilenaChatbotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\EssayController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/redacoes/{essay}/feedback', [EssayController::class, 'showFeedback'])->name('essay.feedback');

    Route::get('/redacoes/historico', [EssayController::class, 'index'])->name('history');

    Route::get('/redacoes/enviar-redacao', function () {
        return view('submit-essay');
    })->name('submit-essay');

    Route::post('/essay/auto-save', [EssayController::class, 'autoSaveDraft'])->name('essay.auto-save');

    // As rotas para o formulário principal (store e edit)
    Route::post('/essay', [EssayController::class, 'store'])->name('essay.store');

    Route::get('/essay/create', [EssayController::class, 'create'])->name('essay.create');

    Route::get('/essay/{essay}/edit', [EssayController::class, 'edit'])->name('essay.edit');


    Route::get('/configuracoes', function () {
        return view('settings');
    })->name('settings');

    // Rota para a página de chat da Milena (se for uma página dedicada)
    Route::get('/chat-milena', function () {
        return Inertia::render('Chat'); // Assumindo que você criou 'resources/js/Pages/Chat.vue'
    })->name('chat.milena');

    // Rotas da API da Milena (podem ser /api/milena/ ou apenas /milena/ se for tudo session-based)
    // Se for um projeto Inertia/Blade, use o middleware 'web' ou apenas 'auth'
    Route::get('/milena/start-chat', [MilenaChatbotController::class, 'startChat'])->name('milena.start');
    Route::post('/milena/message', [MilenaChatbotController::class, 'sendMessage'])->name('milena.send');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Painel do administrador';
    });
});

require __DIR__ . '/auth.php';
