<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'appName' => config('app.name'), // Ou qualquer outro nome que você queira
            'auth.user' => function () {
                if (auth()->check()) {
                    return [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        // Adicione outros dados do usuário que você precisar no frontend
                    ];
                }
                return null;
            },
            'flash' => function () {
                return [
                    'message' => session('message'),
                    'error' => session('error'),
                    // Adicione outras mensagens flash
                ];
            },
        ]);
    }
}
