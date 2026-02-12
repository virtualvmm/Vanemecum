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
    <body class="font-sans text-gray-800 antialiased bg-medico">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
            {{-- Logo centrado y destacado --}}
            <a href="{{ url('/') }}" class="flex items-center justify-center mb-8 focus:outline-none">
                <x-application-logo class="h-20 sm:h-24 w-auto object-contain drop-shadow-sm" />
            </a>

            {{-- Tarjeta del formulario: limpia y clínica --}}
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-gray-300/30 border border-gray-100 overflow-hidden">
                <div class="px-8 py-8 sm:px-10 sm:py-10">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-6 text-sm text-gray-500">
                Consulta de patógenos y tratamientos
            </p>
        </div>
    </body>
</html>
