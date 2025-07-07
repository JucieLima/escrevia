<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
            <div class="mb-4 text-center"> {{-- Centraliza o logo --}}
                <a href="/">
                    {{-- Substitua o componente application-logo pelo seu logo --}}
                    <img src="{{ asset('images/escrevia.png') }}" alt="Logo Escrevia" class="mx-auto" style="width: 180px;">
                </a>
            </div>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full
                                          border-escreviaBorder focus:border-escreviaPrimary focus:ring focus:ring-escreviaPrimary/50"
                         type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" :value="__('Senha')" /> {{-- Alterado de 'Password' para 'Senha' --}}

                <x-input id="password" class="block mt-1 w-full
                                          border-escreviaBorder focus:border-escreviaPrimary focus:ring focus:ring-escreviaPrimary/50"
                         type="password"
                         name="password"
                         required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    {{-- Customização do checkbox --}}
                    <input id="remember_me" type="checkbox" class="rounded
                                border-escreviaBorder text-escreviaPrimary shadow-sm
                                focus:border-escreviaPrimary focus:ring focus:ring-escreviaPrimary/50" name="remember">
                    <span class="ml-2 text-sm text-escreviaSecondary">{{ __('Lembrar-me') }}</span> {{-- Texto alterado --}}
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm
                                text-escreviaSecondary hover:text-escreviaPrimary" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
                @endif

                <x-button class="ml-3
                                bg-escreviaPrimary hover:bg-escreviaAccent text-white">
                    {{ __('Entrar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
