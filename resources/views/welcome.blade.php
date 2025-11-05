<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Sistema de Gestión de Patógenos') }}</title>
    <!-- Incluir Tailwind CSS --><script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fuente Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7fafc; /* Color de fondo claro */
        }
        .hero-bg {
            /* Un fondo sutil para dar ambiente de investigación */
            background-image: linear-gradient(180deg, rgba(238, 242, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://placehold.co/1200x800/eef2ff/4f46e5?text=Fondo+de+Investigacion');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Navegación Superior --><header class="p-6 bg-white shadow-md">
            <nav class="flex justify-between items-center max-w-7xl mx-auto">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 flex items-center">
                    <!-- CLASES AJUSTADAS: h-16 para un tamaño más grande --><img src="{{ asset('images/logo.png') }}" alt="Vanemecum Logo" class="h-16 w-auto mr-3 object-contain" />
                    Vanemecum </a>
                
                <div class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-700 hover:text-indigo-600 transition duration-150">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-700 hover:text-indigo-600 transition duration-150 py-2 px-3">
                            {{ __('Entrar (Login)') }}
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                                {{ __('Darse de Alta') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <!-- Sección Principal (Hero) --><main class="flex-grow hero-bg flex items-center justify-center p-6">
            <div class="max-w-4xl text-center bg-white/90 backdrop-blur-sm p-10 rounded-xl shadow-2xl border border-indigo-100">
                
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-4 leading-tight">
                    {{ __('Sistema de Gestión de Patógenos y Tratamientos') }}
                </h1>
                
                <p class="mt-6 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('Esta plataforma centraliza la información vital sobre agentes patógenos, sus síntomas asociados y los tratamientos recomendados. Está diseñada para administradores de bases de datos biológicas y personal de consulta.') }}
                </p>
                
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <h2 class="text-2xl font-semibold text-indigo-700 mb-4">{{ __('Acceso y Roles') }}</h2>
                    <p class="text-md text-gray-600">
                        {{ __('Ofrecemos dos niveles de acceso según sus necesidades:') }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-8 mt-4">
                        <div class="p-4 rounded-xl bg-indigo-50 border border-indigo-200 w-full sm:w-56 shadow-md transition duration-300 hover:shadow-lg">
                            <p class="font-bold text-lg text-indigo-800">{{ __('ADMINISTRADOR') }}</p>
                            <p class="text-sm text-indigo-600">{{ __('Gestión y edición completa (CRUD).') }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-100 border border-gray-300 w-full sm:w-56 shadow-md transition duration-300 hover:shadow-lg">
                            <p class="font-bold text-lg text-gray-700">{{ __('USUARIO') }}</p>
                            <p class="text-sm text-gray-500">{{ __('Solo acceso de lectura y consulta de datos.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.02]">
                            {{ __('Entrar en el Sistema') }}
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-indigo-600 text-base font-medium rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                {{ __('Crear una Cuenta') }}
                            </a>
                        @endif
                    @endguest
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.02]">
                            {{ __('Ir al Dashboard') }}
                        </a>
                    @endauth
                </div>

            </div>
        </main>

        <!-- Pie de Página --><footer class="p-4 bg-gray-800 text-center text-gray-400 text-sm">
            <div class="max-w-7xl mx-auto">
                <p>&copy; {{ date('Y') }} BioAdmin. {{ __('Todos los derechos reservados.') }}</p>
                <p class="mt-1">{{ __('Desarrollado con Laravel y Tailwind CSS.') }}</p>
            </div>
        </footer>

    </div>

</body>
</html>