<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles (Vite / Bootstrap) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <link rel="shortcut icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

    {{-- Barra de Navegação --}}
    @include('layouts.navigation')

    {{-- Cabeçalho da Página (Slot $header do Breeze) --}}
    @isset($header)
        <header class="bg-white shadow-sm py-3 mb-4">
            <div class="container">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- Conteúdo Principal --}}
    <main class="container my-4 flex-grow-1">
        @if (isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    {{-- Rodapé --}}
    <footer class="mt-auto py-3 bg-white text-center border-top">
        <div class="container">
            @yield('footer', '© ' . date('Y') . ' ' . config('app.name', 'Laravel') . '. Todos os direitos reservados.')
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

{{-- 
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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
 --}}
