<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Escrevia - Dashboard')</title>

    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />
    <!-- Tailwind CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('head')
</head>
<body style='font-family: Inter, "Noto Sans", sans-serif;'>
<div class="relative flex min-h-screen flex-col bg-white overflow-x-hidden">
    <div class="layout-container flex flex-col grow">
        @include('partials.escrevia-header')

        <main class="px-10 py-5 flex flex-1 justify-center">
            <div class="layout-content-container flex flex-col max-w-[960px] w-full">
                @yield('content')
            </div>
        </main>
        <footer class="flex justify-center">
            @include('partials.footer')
        </footer>
    </div>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="{{ mix('js/escrevia_dashboard.js') }}" defer></script>
@stack('scripts')
</body>
</html>
