<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanemecum – {{ __('Consulta de patógenos y tratamientos') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .bg-medico { background-color: #e8eef4; }
        .border-medico { border-color: #c5d4e4; }
        .text-medico { color: #2c5282; }
    </style>
</head>
<body class="antialiased bg-medico min-h-screen flex flex-col">

    <main class="flex-grow flex flex-col items-center justify-center px-4 py-12 sm:py-16">
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-medico overflow-hidden">
            {{-- Franja superior: logo muy grande (rectángulo horizontal) --}}
            <div class="bg-white border-b-2 border-indigo-100 px-4 sm:px-6 pt-4 pb-4 sm:pt-6 sm:pb-6 text-center">
                <a href="{{ url('/') }}" class="inline-block focus:outline-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Vanemecum" class="h-60 sm:h-72 w-auto mx-auto object-contain" />
                </a>
            </div>

            <div class="px-8 py-8 text-center">
                <p class="text-gray-600 leading-relaxed">
                    {{ __('Información sobre patógenos, síntomas y tratamientos recomendados para profesionales y estudiantes del ámbito sanitario.') }}
                </p>

                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-sm">
                            {{ __('Entrar') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-base font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition">
                                {{ __('Crear cuenta') }}
                            </a>
                        @endif
                    @endguest
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-sm">
                            {{ __('Ir al inicio') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <footer class="py-4 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} Vanemecum. {{ __('Todos los derechos reservados.') }}</p>
    </footer>

</body>
</html>