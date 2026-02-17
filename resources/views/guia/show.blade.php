<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Patógeno') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-8">

                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <a href="{{ route('guia.index') }}" class="text-indigo-600 hover:text-indigo-800 inline-flex items-center transition duration-150">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ __('Volver al listado') }}
                    </a>
                    @auth
                        @if ($esFavorito ?? false)
                            <form action="{{ route('favoritos.destroy', $patogeno) }}" method="POST" class="inline ml-auto sm:ml-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50 transition">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    {{ __('Quitar de Mis patógenos') }}
                                </button>
                            </form>
                        @else
                            <form action="{{ route('favoritos.store', $patogeno) }}" method="POST" class="inline ml-auto sm:ml-0">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-900/50 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    {{ __('Guardar en Mis patógenos') }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                {{-- Cabecera: imagen a toda la anchura con el nombre encima y fondo clarito --}}
                <div class="relative -mx-4 -mt-2 sm:-mx-8 sm:-mt-2 rounded-t-xl sm:rounded-t-lg overflow-hidden h-52 sm:h-64">
                    @if ($patogeno->image_url)
                        <img src="{{ asset($patogeno->image_url) }}" alt="{{ $patogeno->nombre }}" class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 w-full h-full {{ optional($patogeno->tipo)->placeholderBgClass() ?? 'bg-gray-500' }} flex items-center justify-center">
                            <span class="text-white/40 text-4xl font-bold">{{ Str::limit($patogeno->nombre, 25) }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-x-0 bottom-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-4 sm:px-6 py-4 pt-8">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ optional($patogeno->tipo)->badgeClass() ?? 'bg-gray-100 text-gray-800' }} mb-2">
                            {{ optional($patogeno->tipo)->nombre ?? __('Desconocido') }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-gray-100 flex items-center flex-wrap gap-2">
                            {{ $patogeno->nombre }}
                            @if ($patogeno->alerta_activa)
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-red-600 text-white shadow-sm">
                                    {{ __('ALERTA POR AUMENTO DE CASOS') }}
                                </span>
                            @endif
                        </h1>
                        <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 italic mt-1 break-words">
                            ({{ Str::limit($patogeno->descripcion ?? '', 100) ?: 'Sin descripción' }})
                        </p>
                    </div>
                </div>

                <!-- Contenido Detallado: Organizado por Secciones -->
                <div class="mt-6 space-y-8">

                    <!-- SECCIÓN 1: Descripción e información básica -->
                    <div class="border-l-4 border-indigo-500 pl-4">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">{{ __('Información General') }}</h2>
                        @if ($patogeno->alerta_activa)
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-4">
                                <h3 class="text-lg font-semibold text-red-700 mb-1">
                                    {{ __('Alerta epidemiológica por aumento de casos') }}
                                </h3>
                                <p class="text-sm text-red-700">
                                    {{ $patogeno->alerta_texto ?: __('Este patógeno se encuentra actualmente en alerta por aumento de incidencia. Extreme las precauciones y siga las recomendaciones vigentes.') }}
                                </p>
                            </div>
                        @endif
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6 text-gray-700">
                            <p>{{ $patogeno->descripcion ?? 'Sin descripción.' }}</p>
                        </div>
                        @if (isset($patogeno->fecha_deteccion_inicial) || isset($patogeno->habitat))
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                            @if (!empty($patogeno->fecha_deteccion_inicial))
                            <div class="col-span-1">
                                <dt class="font-medium text-gray-500">{{ __('Fecha de Detección Inicial') }}</dt>
                                <dd class="text-lg">{{ \Carbon\Carbon::parse($patogeno->fecha_deteccion_inicial)->format('d/m/Y') }}</dd>
                            </div>
                            @endif
                            @if (!empty($patogeno->habitat))
                            <div class="col-span-1">
                                <dt class="font-medium text-gray-500">{{ __('Hábitat principal') }}</dt>
                                <dd class="text-lg">{{ $patogeno->habitat }}</dd>
                            </div>
                            @endif
                        </dl>
                        @endif
                    </div>

                    <!-- SECCIÓN 2: Síntomas Asociados -->
                    <div class="border-l-4 border-green-500 pl-4 pt-4">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">{{ __('Síntomas Comunes') }}</h2>
                        {{-- CRÍTICO: Recorremos la relación 'sintomas' --}}
                        @if ($patogeno->sintomas->count() > 0)
                            <ul class="list-disc ml-6 space-y-2 text-gray-700">
                                @foreach($patogeno->sintomas as $sintoma)
                                    <li>{{ $sintoma->descripcion }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No hay síntomas registrados para este patógeno.</p>
                        @endif
                    </div>

                    <!-- SECCIÓN 3: Tratamiento y Farmacología -->
                    <div class="border-l-4 border-red-500 pl-4 pt-4">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">{{ __('Tratamiento y Farmacología') }}</h2>
                        <h3 class="font-medium text-gray-600 mb-2">{{ __('Tratamientos Asociados') }}</h3>
                        
                        {{-- CRÍTICO: Recorremos la relación 'tratamientos' --}}
                        @if ($patogeno->tratamientos->count() > 0)
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($patogeno->tratamientos as $tratamiento)
                                    <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">{{ $tratamiento->nombre }}</span>
                                @endforeach
                            </div>
                        @else
                             <p class="text-gray-500">No hay tratamientos registrados para este patógeno.</p>
                        @endif
                    </div>
                    
                    <!-- SECCIÓN 4: Fuente de Información -->
                    <div class="border-l-4 border-yellow-500 pl-4 pt-4">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Fuente de Información') }}</h2>
                        {{-- Relación belongsTo: puede ser null o un solo registro --}}
                        @if ($patogeno->fuente)
                            <dl class="space-y-3 text-gray-700">
                                <div>
                                    <dt class="font-medium text-gray-500">{{ $patogeno->fuente->nombre }}</dt>
                                    @if ($patogeno->fuente->url)
                                        <dd class="text-lg"><a href="{{ $patogeno->fuente->url }}" target="_blank" class="text-indigo-500 hover:text-indigo-700 break-words">{{ $patogeno->fuente->url }}</a></dd>
                                    @endif
                                    @if ($patogeno->fuente->descripcion)
                                        <dd class="text-sm text-gray-600">{{ $patogeno->fuente->descripcion }}</dd>
                                    @endif
                                </div>
                            </dl>
                        @else
                            <p class="text-gray-500">No hay fuentes de referencia registradas.</p>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>