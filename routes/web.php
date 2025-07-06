<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/historico', function () {
        return view('history');
    })->name('history');

    Route::get('/enviar-redacao', function () {
        return view('submit-essay');
    })->name('submit-essay');

    Route::get('/configuracoes', function () {
        return view('settings');
    })->name('settings');

    Route::get('/feedback', function () {
        return view('essay-feedback');
    })->name('feedback');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Painel do administrador';
    });
});

require __DIR__.'/auth.php';
