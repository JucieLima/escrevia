<header class="flex items-center justify-between border-b border-[#f0f2f5] px-10 py-3">
    <div class="flex items-center gap-4 text-[#111418]">
        <div class="w-60 h-30">
            <img src="{{ asset('images/escrevia.png') }}" alt="Logo" class="object-contain w-full h-full">
        </div>
    </div>
    <div class="flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            <a class="text-sm font-medium" href="{{ route('home') }}">Início</a>
            <a class="text-sm font-medium" href="{{ route('history') }}">Minhas Redações</a>
            <a class="text-sm font-medium" href="{{ route('submit-essay') }}">Enviar Redação</a>
            <a class="text-sm font-medium" href="{{ route('settings') }}">Configurações</a>
        </div>
        <button class="flex items-center justify-center rounded-lg h-10 bg-[#f0f2f5] text-[#111418] gap-2 text-sm font-bold px-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z"/>
            </svg>
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
        <div class="bg-center bg-no-repeat bg-cover rounded-full size-10"
             style='background-image: url("https://lh3.googleusercontent.com/a/ACg8ocKBTne3QKowPSYQjw-FJwZd2YeZc5gkfTLDJ8hdsZjZQh7VBaDJQg=s360-c-no");'>
        </div>
    </div>
</header>

