<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- Fondo con tono médico: azul-gris suave (estilo clínico/sanitario) --}}
        <div class="min-h-screen bg-medico dark:bg-gray-900 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content: padding responsive para móvil, tablet y desktop -->
            <main class="w-full flex-grow overflow-x-hidden px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                {{ $slot }}
            </main>

            <!-- Pie de página en todas las páginas -->
            <footer class="py-3 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50">
                <p>&copy; {{ date('Y') }} Vanemecum. {{ __('Todos los derechos reservados.') }}</p>
            </footer>
        </div>
    </body>
</html>
