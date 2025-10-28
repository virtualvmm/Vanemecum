<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Patógeno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                {{-- Botón de Regreso --}}
                <a href="{{ route('patogenos.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-6 inline-flex items-center transition duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('Volver a la Administración') }}
                </a>

                {{-- Formulario de Creación --}}
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

                            {{-- Campo Tipo (Relación 1:N) --}}
                            <div class="mb-4">
                                <x-input-label for="tipo_id" :value="__('Tipo de Patógeno')" />
                                {{-- NOTA: La variable $tipos debe ser pasada desde el controlador --}}
                                <select id="tipo_id" name="tipo_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="">{{ __('Seleccione un tipo') }}</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('tipo_id')" />
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
                        </div>

                        {{-- Columna Derecha: Imagen y Descripción --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Detalles y Archivos') }}</h3>

                            {{-- Campo Imagen --}}
                            <div class="mb-4">
                                <x-input-label for="image_url" :value="__('Imagen (JPG/PNG)')" />
                                <input id="image_url" name="image_url" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                            </div>

                            {{-- Campo Descripción --}}
                            <div class="mb-4">
                                <x-input-label for="descripcion" :value="__('Descripción Detallada')" />
                                <textarea id="descripcion" name="descripcion" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('descripcion') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>

                            {{-- Campo Is Active --}}
                            <div class="flex items-center">
                                <input id="is_active" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <x-input-label for="is_active" :value="__('Activo (Visible en la Guía)')" class="ml-2" />
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
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
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <x-primary-button>
                            {{ __('Guardar Patógeno') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>