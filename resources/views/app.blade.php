<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Escrevia') }}</title>

    <link rel="icon" type="image/x-icon" href="data:image/x-xicon;base64,"></link>

    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"></link>

    {{-- REMOVA ESTAS LINHAS DO MIX --}}
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}

    {{-- ADICIONE AS DIRETIVAS DO VITE AQUI --}}
    {{-- Certifique-se de que os caminhos correspondem aos seus "input" no vite.config.mjs --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @routes
    @inertiaHead
    @stack('head')
</head>
<body style='font-family: Inter, "Noto Sans", sans-serif;'>
<div id="app" data-page="{{ json_encode($page) }}"></div>

{{-- REMOVA ESTAS LINHAS DO MIX --}}
{{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
{{-- <script src="{{ mix('js/escrevia_dashboard.js') }}" defer></script> --}}

{{-- Importante: Se 'escrevia_dashboard.js' for um script auxiliar que não faz parte do seu app.js principal --}}
{{-- e não deve ser gerenciado pelo Vite/Inertia/Vue, você precisará adaptá-lo. --}}
{{-- A forma mais comum é importar/incluir todo JS via app.js para ser empacotado pelo Vite. --}}
{{-- Se ele for independente e você ainda precisar dele, pode adicioná-lo ao 'input' do vite.config.mjs --}}
{{-- ou incluí-lo como um script CDN se for o caso. Por enquanto, vou supor que ele deve ser empacotado. --}}
{{-- Se for um arquivo de script auxiliar de terceiros, coloque-o no "public" e referencie diretamente: --}}
{{-- <script src="{{ asset('js/escrevia_dashboard.js') }}" defer></script> --}}

@stack('scripts')
</body>
</html>
