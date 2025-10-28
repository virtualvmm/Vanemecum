<!-- resources/views/patogenos/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Patógeno: {{ $patogeno->nombre }}</h1>
            <a href="{{ route('patogenos.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
            </a>
        </div>

        <!-- Manejo de Errores -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <strong class="font-bold">¡Error de validación!</strong>
                <span class="block sm:inline">Por favor, corrija los siguientes errores:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-xl p-6 lg:p-8">
            <!-- El método es POST, pero usamos @method('PUT') para la actualización -->
            <form action="{{ route('patogenos.update', $patogeno->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Sección de Información Básica -->
                <h2 class="text-2xl font-semibold border-b pb-2 mb-6 text-gray-700">Información General</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre (científico/principal)</label>
                        <input type="text" name="nombre" id="nombre" 
                               value="{{ old('nombre', $patogeno->nombre) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('nombre') border-red-500 @enderror" 
                               required>
                        @error('nombre')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Patógeno (Relación 1:N) -->
                    <div>
                        <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Patógeno</label>
                        <select name="tipo_id" id="tipo_id" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('tipo_id') border-red-500 @enderror">
                            <option value="">Seleccione Tipo</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" 
                                        {{ old('tipo_id', $patogeno->tipo_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fuente (Relación 1:N - Si es nullable) -->
                    <div>
                        <label for="fuente_id" class="block text-sm font-medium text-gray-700 mb-1">Fuente Principal (Ej: OMS, CDC)</label>
                        <select name="fuente_id" id="fuente_id" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('fuente_id') border-red-500 @enderror">
                            <option value="">Sin Fuente</option>
                            @foreach ($fuentes as $fuente)
                                <option value="{{ $fuente->id }}" 
                                        {{ old('fuente_id', $patogeno->fuente_id) == $fuente->id ? 'selected' : '' }}>
                                    {{ $fuente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('fuente_id')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado (is_active) -->
                    <div class="flex items-center pt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                                {{ old('is_active', $patogeno->is_active) ? 'checked' : '' }}
                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">Patógeno Activo (Visible en Guía)</label>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción Detallada</label>
                    <textarea name="descripcion" id="descripcion" rows="4" 
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $patogeno->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gestión de Imagen -->
                <div class="mt-6 border-t pt-6">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-700">Imagen Actual</h2>
                    <div class="flex items-center space-x-6">
                        @if ($patogeno->image_url)
                            <div class="flex-shrink-0">
                                <img src="{{ $patogeno->image_url }}" alt="Imagen actual" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-md">
                            </div>
                        @else
                            <span class="text-gray-500">No hay imagen subida.</span>
                        @endif
                        
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Cambiar Imagen (URL)</label>
                            <input type="url" name="image_url" id="image_url" 
                                   value="{{ old('image_url', $patogeno->image_url) }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 md:w-96 @error('image_url') border-red-500 @enderror">
                            @error('image_url')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección de Relaciones Muchos-a-Muchos -->
                <div class="mt-8 border-t pt-6">
                    <h2 class="text-2xl font-semibold border-b pb-2 mb-4 text-gray-700">Relaciones (Síntomas y Tratamientos)</h2>

                    <!-- Tratamientos -->
                    <div class="mb-6">
                        <label for="tratamientos" class="block text-sm font-medium text-gray-700 mb-1">Tratamientos Asociados (Selección Múltiple)</label>
                        <select name="tratamientos[]" id="tratamientos" multiple size="8" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('tratamientos') border-red-500 @enderror">
                            @php
                                // Obtener los IDs de los tratamientos actuales para precargar
                                $patogenoTratamientoIds = $patogeno->tratamientos->pluck('id')->toArray();
                                $selectedTratamientos = old('tratamientos') ?: $patogenoTratamientoIds;
                            @endphp
                            
                            @foreach ($tratamientos as $tratamiento)
                                <option value="{{ $tratamiento->id }}" 
                                        {{ in_array($tratamiento->id, $selectedTratamientos) ? 'selected' : '' }}>
                                    {{ $tratamiento->nombre }} ({{ $tratamiento->tipo->nombre ?? 'Sin Tipo' }})
                                </option>
                            @endforeach
                        </select>
                        @error('tratamientos')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Mantenga presionada la tecla Ctrl/Cmd para seleccionar múltiples opciones.</p>
                    </div>

                    <!-- Síntomas -->
                    <div class="mb-6">
                        <label for="sintomas" class="block text-sm font-medium text-gray-700 mb-1">Síntomas que Causa (Selección Múltiple)</label>
                        <select name="sintomas[]" id="sintomas" multiple size="8" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 @error('sintomas') border-red-500 @enderror">
                            @php
                                // Obtener los IDs de los síntomas actuales para precargar
                                $patogenoSintomaIds = $patogeno->sintomas->pluck('id')->toArray();
                                $selectedSintomas = old('sintomas') ?: $patogenoSintomaIds;
                            @endphp
                            
                            @foreach ($sintomas as $sintoma)
                                <option value="{{ $sintoma->id }}" 
                                        {{ in_array($sintoma->id, $selectedSintomas) ? 'selected' : '' }}>
                                    {{ $sintoma->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('sintomas')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Mantenga presionada la tecla Ctrl/Cmd para seleccionar múltiples opciones.</p>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-xl transition duration-300 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Actualizar Patógeno
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection