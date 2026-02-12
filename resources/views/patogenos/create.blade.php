<x-app-layout>
<div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6 lg:p-8">

            {{-- Botón de Regreso --}}
            <a href="{{ route('patogenos.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-6 inline-flex items-center transition duration-150">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('Volver a la Administración') }}
            </a>

            {{-- Formulario de Creación con manejo de archivos --}}
            <form action="{{ route('patogenos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 mt-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Columna Izquierda: Datos Principales --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Información Básica') }}</h3>

                        {{-- Campo Nombre --}}
                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Nombre Científico / Identificador')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus autocomplete="nombre" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        {{-- CAMPO TIPO (Relación 1:M) --}}
                        <div class="mb-4">
                            <x-input-label for="tipo_patogeno_id" :value="__('Tipo de Patógeno')" />
                            {{-- NOTA: La variable $tipos debe ser pasada desde el controlador --}}
                            <select id="tipo_patogeno_id" name="tipo_patogeno_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="">{{ __('Seleccione un tipo') }}</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_patogeno_id') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipo_patogeno_id')" />
                        </div>

                        {{-- Campo Fuente (Relación 1:N) --}}
                        <div class="mb-4">
                            <x-input-label for="fuente_id" :value="__('Fuente Principal de Referencia')" />
                            {{-- NOTA: La variable $fuentes debe ser pasada desde el controlador --}}
                            <select id="fuente_id" name="fuente_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">{{ __('Seleccione una fuente (Opcional)') }}</option>
                                @foreach($fuentes as $fuente)
                                    <option value="{{ $fuente->id }}" {{ old('fuente_id') == $fuente->id ? 'selected' : '' }}>
                                        {{ $fuente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('fuente_id')" />
                        </div>
                        
                        {{-- Campo Descripción --}}
                        <div class="mb-4">
                            <x-input-label for="descripcion" :value="__('Descripción Detallada')" />
                            <textarea id="descripcion" name="descripcion" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('descripcion') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>
                    </div>

                    {{-- Columna Derecha: Imagen y Estado --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Archivos y Estado') }}</h3>

                        {{-- Campo Imagen con Previsualización (MEJORADO) --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <x-input-label for="image_url" :value="__('Subir Imagen (JPG/PNG)')" class="mb-2 font-bold" />
                            {{-- Añadido 'accept' para mejor experiencia en móviles --}}
                            <input id="image_url" name="image_url" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/jpeg,image/png" />
                            <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                            <p class="text-xs text-gray-500 mt-2">{{ __('Máx. 2MB. Se requiere una imagen para el catálogo.') }}</p>

                            {{-- Contenedor de Previsualización (AÑADIDO) --}}
                            <div id="image-preview-container" class="mt-4 hidden">
                                <p class="text-sm font-medium mb-1">{{ __('Previsualización:') }}</p>
                                <img id="image-preview" class="max-h-32 w-auto rounded-lg shadow-md object-cover border border-gray-300" src="" alt="Previsualización de la imagen">
                            </div>
                        </div>

                        {{-- Campo Is Active (MEJORADO con input hidden) --}}
                        {{-- Input oculto para asegurar que el valor '0' se envíe si el checkbox no está marcado --}}
                        <input type="hidden" name="is_active" value="0">
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                            <div class="flex items-center h-5">
                                {{-- Por defecto, lo dejamos marcado si no hay old() o si old() es '1' --}}
                                <input id="is_active" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('is_active') == 1 || old('is_active') === null ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <x-input-label for="is_active" :value="__('Activo (Visible en la Guía)')" class="font-bold" />
                                <p class="text-gray-500 text-xs">{{ __('El patógeno será público por defecto.') }}</p>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        </div>

                        {{-- Módulo de Alerta Epidemiológica --}}
                        <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-start">
                                {{-- Input oculto para enviar 0 si no está marcada --}}
                                <input type="hidden" name="alerta_activa" value="0">
                                <div class="flex items-center h-5">
                                    <input id="alerta_activa" name="alerta_activa" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" value="1" {{ old('alerta_activa') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm w-full">
                                    <x-input-label for="alerta_activa" :value="__('Alerta epidemiológica por aumento de casos')" class="font-bold text-red-700" />
                                    <p class="text-red-600 text-xs mb-2">
                                        {{ __('Marque esta casilla si este patógeno está actualmente en alerta por aumento de incidencia.') }}
                                    </p>
                                    <x-input-label for="alerta_texto" :value="__('Mensaje breve de alerta (opcional)')" class="text-xs text-red-700" />
                                    <textarea id="alerta_texto" name="alerta_texto" rows="3" class="mt-1 block w-full border-red-200 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-sm" placeholder="Ej.: Aumento significativo de casos en la última semana.">{{ old('alerta_texto') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('alerta_texto')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección de Relaciones Muchos-a-Muchos --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Relaciones: Síntomas y Tratamientos') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Seleccionar Síntomas --}}
                        <div>
                            <x-input-label for="sintomas" :value="__('Síntomas Asociados')" />
                            {{-- NOTA: La variable $sintomas debe ser pasada desde el controlador --}}
                            <select id="sintomas" name="sintomas[]" multiple class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full h-48">
                                @foreach($sintomas as $sintoma)
                                    <option value="{{ $sintoma->id }}" {{ in_array($sintoma->id, old('sintomas', [])) ? 'selected' : '' }}>
                                        {{ $sintoma->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('sintomas')" />
                            <p class="text-xs text-gray-500 mt-1">{{ __('Mantén pulsado Ctrl/Cmd para seleccionar múltiples.') }}</p>
                        </div>

                        {{-- Seleccionar Tratamientos --}}
                        <div>
                            <x-input-label for="tratamientos" :value="__('Tratamientos Aplicables')" />
                            {{-- NOTA: La variable $tratamientos debe ser pasada desde el controlador --}}
                            <select id="tratamientos" name="tratamientos[]" multiple class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full h-48">
                                @foreach($tratamientos as $tratamiento)
                                    <option value="{{ $tratamiento->id }}" {{ in_array($tratamiento->id, old('tratamientos', [])) ? 'selected' : '' }}>
                                        {{ $tratamiento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tratamientos')" />
                            <p class="text-xs text-gray-500 mt-1">{{ __('Mantén pulsado Ctrl/Cmd para seleccionar múltiples.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Botón de Guardar --}}
                <div class="flex justify-end pt-6 border-t border-gray-200 mt-6">
                    <x-primary-button>
                        {{ __('Guardar Patógeno') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Script para Previsualización de Imagen (AÑADIDO) --}}
            <script>
                document.getElementById('image_url').addEventListener('change', function(event) {
                    const preview = document.getElementById('image-preview');
                    const previewContainer = document.getElementById('image-preview-container');
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            previewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Si se deselecciona o cancela, ocultar la previsualización
                        preview.src = '';
                        previewContainer.classList.add('hidden');
                    }
                });
            </script>

        </div>
    </div>
</div>
</x-app-layout>