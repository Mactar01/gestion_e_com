<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" id="themeBody">
        <div class="min-h-screen" id="mainBg">
            @include('layouts.navigation')

            <div class="container-fluid d-flex justify-content-end align-items-center pt-2 pb-1">
                <button id="toggleThemeBtn" class="btn btn-outline-secondary btn-sm">
                    <span id="themeIcon" class="me-1">🌙</span>
                    <span id="themeText">Mode sombre</span>
                </button>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
        <script>
            // Fonction de bascule du thème
            function setTheme(dark) {
                const body = document.getElementById('themeBody');
                const mainBg = document.getElementById('mainBg');
                const icon = document.getElementById('themeIcon');
                const text = document.getElementById('themeText');
                if (dark) {
                    body.classList.add('bg-dark', 'text-white');
                    body.classList.remove('bg-white', 'text-dark');
                    mainBg.classList.add('bg-dark', 'text-white');
                    mainBg.classList.remove('bg-white', 'text-dark');
                    icon.textContent = '🌙';
                    text.textContent = 'Mode sombre';
                } else {
                    body.classList.add('bg-white', 'text-dark');
                    body.classList.remove('bg-dark', 'text-white');
                    mainBg.classList.add('bg-white', 'text-dark');
                    mainBg.classList.remove('bg-dark', 'text-white');
                    icon.textContent = '☀️';
                    text.textContent = 'Mode clair';
                }
            }
            // Initialisation
            let darkMode = localStorage.getItem('darkMode');
            if (darkMode === null) darkMode = '1'; // sombre par défaut
            setTheme(darkMode === '1');
            document.getElementById('toggleThemeBtn').onclick = function() {
                darkMode = (darkMode === '1') ? '0' : '1';
                localStorage.setItem('darkMode', darkMode);
                setTheme(darkMode === '1');
            };
        </script>
    </body>
</html>
