<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Patógeno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

                {{-- Botón de Regreso al Listado --}}
                <a href="{{ route('guia.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-6 inline-flex items-center transition duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('Volver al listado') }}
                </a>

                <!-- Encabezado del Patógeno -->
                <div class="mt-4 border-b pb-4">
                    <!-- Tipo de Patógeno (Clasificación): Viene de la relación 'tipo' -->
                    @php
                        // Determinación del color basado en el nombre del tipo, no en una columna 'clasificacion'
                        $tipoNombre = optional($patogeno->tipo)->nombre ?? 'Desconocido';
                        $colorClass = match ($tipoNombre) {
                            'Bacteria' => 'bg-blue-100 text-blue-800',
                            'Virus' => 'bg-red-100 text-red-800',
                            'Hongo' => 'bg-green-100 text-green-800',
                            default => 'bg-yellow-100 text-yellow-800',
                        };
                    @endphp

                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $colorClass }} mb-2">
                        {{ $tipoNombre }}
                    </span>

                    <h1 class="text-3xl font-extrabold text-gray-900">
                        {{-- CRÍTICO: Usamos la columna 'nombre' que sí existe en la tabla --}}
                        {{ $patogeno->nombre }}
                    </h1>
                    <p class="text-xl text-gray-600 italic mt-1">
                        ({{ $patogeno->descripcion_corta ?? 'Sin descripción corta' }})
                    </p>
                </div>

                <!-- Contenido Detallado: Organizado por Secciones -->
                <div class="mt-6 space-y-8">

                    <!-- SECCIÓN 1: Descripción Completa y Datos Básicos -->
                    <div class="border-l-4 border-indigo-500 pl-4">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Información General') }}</h2>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6 text-gray-700">
                            <p>{{ $patogeno->descripcion_completa }}</p>
                        </div>
                        
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                            <div class="col-span-1">
                                <dt class="font-medium text-gray-500">{{ __('Fecha de Detección Inicial') }}</dt>
                                <dd class="text-lg">{{ \Carbon\Carbon::parse($patogeno->fecha_deteccion_inicial)->format('d/m/Y') }}</dd>
                            </div>
                             <div class="col-span-1">
                                <dt class="font-medium text-gray-500">{{ __('Habitat Principal') }}</dt>
                                <dd class="text-lg">{{ $patogeno->habitat }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- SECCIÓN 2: Síntomas Asociados -->
                    <div class="border-l-4 border-green-500 pl-4 pt-4">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Síntomas Comunes') }}</h2>
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
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Tratamiento y Farmacología') }}</h2>
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