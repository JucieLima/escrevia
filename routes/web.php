<?php

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

Route::get('/enviar-redacao', function () {
    return view('submit-essay');
})->name('submit-essay');
Route::get('/configuracoes', function () {
    return view('settings');
})->name('settings');
Route::get('/feedback', function () {
    return view('essay-feedback');
})->name('feedback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/historico', [EssayController::class, 'index'])->name('history');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Painel do administrador';
    });
});

require __DIR__.'/auth.php';
