<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Escrevia - Correção de Redação ENEM com IA')</title>
    <meta name="description"
          content="@yield('description', 'Prepare-se para o ENEM com a nossa plataforma de correção de redações baseada em inteligência artificial. Receba feedback instantâneo, objetivo e detalhado para melhorar suas notas. Ideal para estudantes, professores e plataformas de ensino.')">
    <meta name="keywords"
          content="@yield('keywords', 'correção de redação ENEM, inteligência artificial, feedback de redação, redação online, preparatório ENEM, notas redação, como melhorar redação, IA para redação, professor de redação, plataforma de ensino')">
    <meta name="author" content="Escrevia Team">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="@yield('og_title', 'Escrevia - Correção de Redação ENEM com IA')">
    <meta property="og:description"
          content="@yield('og_description', 'Prepare-se para o ENEM com a nossa plataforma de correção de redações baseada em inteligência artificial. Receba feedback instantâneo, objetivo e detalhado para melhorar suas notas.')">
    <meta property="og:image" content="{{ asset('images/escrevia_social_share.png') }}"> {{-- Crie uma imagem para isso --}}

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'Escrevia - Correção de Redação ENEM com IA')">
    <meta property="twitter:description"
          content="@yield('twitter_description', 'Prepare-se para o ENEM com a nossa plataforma de correção de redações baseada em inteligência artificial. Receba feedback instantâneo, objetivo e detalhado para melhorar suas notas.')">
    <meta property="twitter:image" content="{{ asset('images/escrevia_social_share.png') }}">

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ mix('/css/escrevia_theme.css') }}">
    @stack('styles')
</head>
<body>
<header>
    <nav class="nav">
        <a href="{{url('/')}}" class="logo">
            <img src="{{asset('images/escrevia.png')}}" alt="Logo Escrevia" width="160">
        </a>
        <div class="nav-links">
            <a href="#home">Início</a>
            <a href="#solucao">Solução</a>
            <a href="#publico-alvo">Para Quem?</a>
            <a href="#funcionalidades">Recursos</a>
            <a href="#depoimentos">Depoimentos</a>
            <a href="#faq">FAQ</a>
        </div>
        <a href="{{ route('login') }}" class="btn-login">Entrar</a>
    </nav>
</header>

<main>
    @yield('content') {{-- Aqui é onde o conteúdo das suas seções será injetado --}}
</main>

<footer>
    <p>&copy; {{ date('Y') }} <span style="font-family: 'Montserrat SemiBold';color: var(--accent-color);">Escrev</span><span style="font-family: 'Montserrat SemiBold';color: var(--primary-color);">ia</span>. Todos os direitos reservados.</p>
    <div class="footer-links">
        <a href="#">Política de Privacidade</a>
        <a href="#">Termos de Uso</a>
        <a href="#">Contato</a>
    </div>
</footer>

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            const answer = item.querySelector('.faq-answer');
            const arrow = item.querySelector('.faq-question span:last-child');
            if (answer.style.display === 'block') {
                answer.style.display = 'none';
                arrow.innerHTML = '&#9660;'; // Seta para baixo
            } else {
                answer.style.display = 'block';
                arrow.innerHTML = '&#9650;'; // Seta para cima
            }
        });
    });
</script>
@stack('scripts') {{-- Para adicionar JS específico de uma seção --}}
</body>
</html>
