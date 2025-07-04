<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stitch Design')</title>

    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    @stack('head')
</head>
<body style='font-family: Inter, "Noto Sans", sans-serif;'>
<div class="relative flex min-h-screen flex-col bg-white overflow-x-hidden">
    <div class="layout-container flex flex-col grow">
        @include('partials.header')

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
@stack('scripts')
</body>
</html>
