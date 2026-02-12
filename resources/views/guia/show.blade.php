<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Patógeno') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-8">

                {{-- Botón de Regreso al Listado --}}
                <a href="{{ route('guia.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-6 inline-flex items-center transition duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('Volver al listado') }}
                </a>

                <!-- Encabezado del Patógeno -->
                <div class="mt-4 border-b pb-4">
                    <!-- Tipo de Patógeno (Clasificación): Viene de la relación 'tipo' -->
                    @php
                        // Colores según tipo (nombres deben coincidir con tipo_patogenos: Virus, Bacterias, Hongos, Parásitos)
                        $tipoNombre = optional($patogeno->tipo)->nombre ?? 'Desconocido';
                        $colorClass = match ($tipoNombre) {
                            'Virus' => 'bg-red-100 text-red-800',
                            'Bacterias' => 'bg-blue-100 text-blue-800',
                            'Hongos' => 'bg-green-100 text-green-800',
                            'Parásitos' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp

                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $colorClass }} mb-2">
                        {{ $tipoNombre }}
                    </span>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 flex items-center flex-wrap gap-2">
                        {{-- CRÍTICO: Usamos la columna 'nombre' que sí existe en la tabla --}}
                        {{ $patogeno->nombre }}
                        @if ($patogeno->alerta_activa)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-red-600 text-white shadow-sm">
                                {{ __('ALERTA POR AUMENTO DE CASOS') }}
                            </span>
                        @endif
                    </h1>
                    <p class="text-base sm:text-xl text-gray-600 italic mt-1 break-words">
                        ({{ Str::limit($patogeno->descripcion ?? '', 120) ?: 'Sin descripción' }})
                    </p>
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