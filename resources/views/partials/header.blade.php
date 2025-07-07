<header class="flex items-center justify-between border-b border-[#f0f2f5] px-10 py-3">
    <div class="flex items-center gap-4 text-[#111418]">
        {{-- Logo da Escrevia --}}
        <div class="w-60 h-30">
            <a href="{{ route('dashboard') }}"> {{-- Linka para o dashboard ao clicar no logo --}}
                <img src="{{ asset('images/escrevia.png') }}" alt="Logo Escrevia" class="object-contain w-full h-full">
            </a>
        </div>
    </div>

    <div class="flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            {{-- Links de Navegação --}}
            <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200" href="{{ route('dashboard') }}">Início</a>
            {{-- A rota que você passou era 'history', que já mapei para 'redacoes.index' por padrão --}}
            <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200" href="{{ route('history') }}">Minhas Redações</a>
            {{-- A rota que você passou era 'submit-essay' --}}
            <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200" href="{{ route('submit-essay') }}">Enviar Redação</a>
            {{-- A rota que você passou era 'settings' --}}
            <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200" href="{{ route('settings') }}">Configurações</a>
            {{-- A rota para feedback de redação específica não costuma ser um link direto no header,
                 mas sim um link dinâmico na lista de redações (ex: /redacoes/{id}/feedback).
                 Se for uma página de feedback geral, então sim. Por enquanto, não adicionei. --}}

            {{-- Exemplo de link condicional para admin/professor, se necessário --}}
            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200" href="#profile{{--{{ route('admin.dashboard') }}--}}">Admin/Prof.</a> {{-- Exemplo de rota, ajuste --}}
            @endif
        </div>

        {{-- Ícone de Notificações (opcional, pode ser funcional mais tarde) --}}
        <button class="flex items-center justify-center rounded-lg h-10 bg-[#f0f2f5] text-[#111418] gap-2 text-sm font-bold px-2.5 hover:bg-escreviaBorder transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z"/>
            </svg>
            {{-- Exemplo de contador de notificações --}}
            {{-- <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">3</span> --}}
        </button>

        {{-- Dropdown do Usuário (Nome + Avatar + Logout) --}}
        <div class="relative">
            <button id="user-menu-button" class="flex items-center gap-2 text-sm font-medium focus:outline-none">
                {{-- Avatar do Usuário --}}
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10"
                     style='background-image: url("{{ Auth::user()->avatar_url ?? "https://ui-avatars.com/api/?name=".urlencode(Auth::user()->name)."&color=FFFFFF&background=E94E77" }}");'>
                </div>
                {{-- Nome do Usuário Logado --}}
                <span class="text-escreviaSecondary hidden md:inline">{{ Auth::user()->name }}</span>
            </button>

            {{-- Dropdown Menu (escondido por padrão) --}}
            <div id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                <a href="#profile-edit{{-- {{ route('profile.edit') }}--}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meu Perfil</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ajuda</a>
                <div class="border-t border-gray-100"></div>
                {{-- Botão de Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-500 hover:text-white">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
