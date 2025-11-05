<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vanemecum: Crear Patógeno</title>
    
    <!-- Incluir scripts/estilos de tu aplicación, incluyendo Tailwind CSS -->@vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Configuración para usar Inter Font (Si no está ya en app.css) --><style>
        /*
        * Fuente y scrollbar estilo oscuro
        * Esto ayuda a mantener el look and feel "Netflix" (inmersivo, sin scrollbars blancos molestos)
        */
        body {
            font-family: 'Inter', sans-serif;
            scrollbar-color: #374151 #1f2937; /* thumb color track color */
            scrollbar-width: thin;
        }
        body::-webkit-scrollbar {
            width: 8px;
        }
        body::-webkit-scrollbar-track {
            background: #1f2937; /* gray-900 oscuro */
        }
        body::-webkit-scrollbar-thumb {
            background-color: #374151; /* gray-700 */
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-gray-900 antialiased">

    <!-- Header / Barra de Navegación (Estilo Sanitario - Teal/Cian) --><header class="bg-gray-900 border-b border-teal-700/50 p-4 sticky top-0 z-10 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-white">
            
            <!-- Logo y Nombre de la Aplicación: Vanemecum --><a href="{{ route('dashboard') }}" class="flex items-center text-2xl font-bold text-teal-400 hover:text-teal-300 transition duration-150">
                <!-- **LOGO INTEGRADO AQUÍ** --><img src="{{ asset('C:\xampp\htdocs\VanemecumLaravel\public\images/logo.png') }}" alt="Vanemecum Logo" class="h-9 mr-3 object-contain"> 
                <!-- El texto "Vanemecum" está ahora dentro de la imagen del logo --></a>

            <!-- Navegación "Netflix" - Clave: Minimalista y foco en la acción --><nav>
                <a href="{{ route('patogenos.index') }}" class="text-gray-300 hover:text-teal-400 mr-4 transition duration-150 font-medium">Patógenos</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-400 hover:text-red-400 transition duration-150">Salir</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </nav>
        </div>
    </header>

    <div class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Título Principal --><h1 class="text-4xl font-extrabold text-white mb-8 text-center tracking-tight">
                Registro - Nuevo Agente Patógeno
            </h1>

            <!-- Tarjeta del Formulario (Estilo Oscuro Limpio y Borde Ligero) --><div class="bg-gray-800 p-10 shadow-2xl rounded-xl border border-teal-700/30 backdrop-blur-sm">
                <p class="text-gray-400 mb-8 text-center text-lg">
                    Añade información vital al sistema **Vanemecum** para consulta y gestión.
                </p>

                <!-- Formulario que apunta a PatogenoController@store --><form method="POST" action="{{ route('patogenos.store') }}">
                    @csrf

                    <!-- Grid de 2 columnas para campos cortos --><div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        <!-- 1. Nombre --><div>
                            <label for="nombre" class="block text-sm font-medium text-teal-400 mb-2">Nombre del Patógeno</label>
                            <input id="nombre" name="nombre" type="text" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 placeholder-gray-500 transition duration-150" placeholder="Ej: Neisseria gonorrhoeae" value="{{ old('nombre') }}" required autofocus />
                            @error('nombre') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 2. Tipo (Select) --><div>
                            <label for="tipo" class="block text-sm font-medium text-teal-400 mb-2">Tipo de Agente</label>
                            <select id="tipo" name="tipo" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 appearance-none transition duration-150" required>
                                <option value="" class="text-gray-500">Seleccione el tipo...</option>
                                @foreach (['Virus', 'Bacteria', 'Hongo', 'Parásito', 'Prion'] as $opcion)
                                    <option value="{{ $opcion }}" {{ old('tipo') == $opcion ? 'selected' : '' }}>{{ $opcion }}</option>
                                @endforeach
                            </select>
                            @error('tipo') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 3. Familia --><div>
                            <label for="familia" class="block text-sm font-medium text-teal-400 mb-2">Familia</label>
                            <input id="familia" name="familia" type="text" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 placeholder-gray-500 transition duration-150" placeholder="Ej: Neisseriaceae" value="{{ old('familia') }}" />
                            @error('familia') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 4. Gravedad --><div>
                            <label for="gravedad" class="block text-sm font-medium text-teal-400 mb-2">Nivel de Gravedad (1-5)</label>
                            <input id="gravedad" name="gravedad" type="number" min="1" max="5" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 transition duration-150" placeholder="3" value="{{ old('gravedad') }}" required />
                            @error('gravedad') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                    
                    <!-- 5. Síntomas Asociados --><div class="mb-8">
                        <label for="sintomas" class="block text-sm font-medium text-teal-400 mb-2">Síntomas Clave</label>
                        <textarea id="sintomas" name="sintomas" rows="3" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 placeholder-gray-500 transition duration-150" placeholder="Ej: Fiebre alta, erupción cutánea, dolor articular.">{{ old('sintomas') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Escriba los síntomas separados por comas. Esto será fundamental para el sistema de búsqueda (tipo Netflix).</p>
                        @error('sintomas') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 6. Notas Adicionales --><div class="mb-10">
                        <label for="notas" class="block text-sm font-medium text-teal-400 mb-2">Notas y Observaciones Clínicas</label>
                        <textarea id="notas" name="notas" rows="4" class="w-full bg-gray-700 border-gray-600 text-white rounded-lg shadow-inner focus:ring-teal-500 focus:border-teal-500 p-3 placeholder-gray-500 transition duration-150" placeholder="Añadir datos relevantes sobre la epidemiología o resistencia a tratamientos.">{{ old('notas') }}</textarea>
                        @error('notas') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Botones de Acción --><div class="flex items-center justify-end border-t border-gray-700 pt-6">
                        
                        <!-- Botón de Cancelar/Volver (Estilo Secundario) --><a href="{{ route('patogenos.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-700 border border-gray-600 rounded-lg font-semibold text-sm text-gray-300 uppercase tracking-wider hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 focus:ring-offset-gray-900 transition ease-in-out duration-150 mr-4">
                            Volver a Lista
                        </a>
                        
                        <!-- Botón de Guardar (Estilo Primario - Teal Sanitario) --><button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 focus:ring-offset-gray-900 active:bg-teal-700 transition ease-in-out duration-150 shadow-lg shadow-teal-500/30">
                            Guardar Patógeno en Vanemecum
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>