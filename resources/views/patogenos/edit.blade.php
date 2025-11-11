<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Patógeno') }}: <span class="text-indigo-600">{{ $patogeno->nombre }}</span>
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

                {{-- Formulario de Edición (PATCH) --}}
                <form action="{{ route('patogenos.update', $patogeno) }}" method="POST" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PATCH') {{-- O PUT, pero PATCH es el estándar para actualizaciones parciales --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Columna Izquierda: Datos Principales --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Información Básica') }}</h3>

                            {{-- Campo Nombre --}}
                            <div class="mb-4">
                                <x-input-label for="nombre" :value="__('Nombre Científico / Identificador')" />
                                <x-text-input 
                                    id="nombre" 
                                    name="nombre" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('nombre', $patogeno->nombre)" {{-- Rellenado de datos --}}
                                    required autofocus autocomplete="nombre" 
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            {{-- CAMPO TIPO (Relación 1:N) --}}
                            <div class="mb-4">
                                <x-input-label for="tipo_patogeno_id" :value="__('Tipo de Patógeno')" />
                                {{-- NOTA: Asumiendo que $tipos viene del controlador --}}
                                <select id="tipo_patogeno_id" name="tipo_patogeno_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="">{{ __('Seleccione un tipo') }}</option>
                                    @foreach($tipos as $tipo)
                                        <option 
                                            value="{{ $tipo->id }}" 
                                            {{ old('tipo_patogeno_id', $patogeno->tipo_patogeno_id) == $tipo->id ? 'selected' : '' }} {{-- Rellenado de datos --}}
                                        >
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('tipo_patogeno_id')" />
                            </div>

                            {{-- Campo Fuente (Relación 1:N Opcional) --}}
                            <div class="mb-4">
                                <x-input-label for="fuente_id" :value="__('Fuente Principal de Referencia')" />
                                {{-- NOTA: Asumiendo que $fuentes viene del controlador --}}
                                <select id="fuente_id" name="fuente_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">{{ __('Seleccione una fuente (Opcional)') }}</option>
                                    @foreach($fuentes as $fuente)
                                        <option 
                                            value="{{ $fuente->id }}" 
                                            {{ old('fuente_id', $patogeno->fuente_id) == $fuente->id ? 'selected' : '' }} {{-- Rellenado de datos --}}
                                        >
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

                            {{-- Campo Imagen con PREVISUALIZACIÓN Alpine.js (Mejorado para edición) --}}
                            {{-- Inicializamos Alpine con la URL existente si está disponible --}}
                            <div class="mb-4" x-data="{ 
                                imageUrl: '{{ $patogeno->image_url ?? '' }}',
                                fileChange(event) { 
                                    const file = event.target.files[0]; 
                                    if (file) { 
                                        const reader = new FileReader(); 
                                        reader.onload = (e) => { this.imageUrl = e.target.result; }; 
                                        reader.readAsDataURL(file); 
                                    } else { 
                                        // Si el usuario cancela la selección, volvemos a la imagen original o la borramos
                                        this.imageUrl = '{{ $patogeno->image_url ?? '' }}';
                                    } 
                                } 
                            }">
                                <x-input-label for="image_url" :value="__('Imagen Actualizar (JPG/PNG)')" />
                                
                                {{-- Contenedor de Previsualización --}}
                                <div x-show="imageUrl" class="mt-2 mb-4 p-2 border border-gray-200 rounded-lg bg-gray-50 flex items-center justify-center h-40 w-full overflow-hidden">
                                    <img x-bind:src="imageUrl" alt="Vista previa de la imagen" class="max-h-full max-w-full object-contain rounded">
                                </div>
                                
                                {{-- Input de Archivo --}}
                                <input 
                                    id="image_url" 
                                    name="image_url" 
                                    type="file" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    @change="fileChange($event)"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                                @if($patogeno->image_url)
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Dejar vacío para mantener la imagen actual.') }}</p>
                                @endif
                            </div>

                            {{-- Imágenes adicionales existentes: seleccionar principal y borrar --}}
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <x-input-label :value="__('Imágenes adicionales')" class="mb-2 font-bold" />
                                @php
                                    $images = $patogeno->images()->get();
                                    $primaryId = optional($patogeno->primaryImage)->id;
                                @endphp
                                @if($images->count())
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        @foreach($images as $img)
                                            <div class="border rounded p-2 bg-white">
                                                <img src="{{ $img->path }}" alt="Imagen" class="h-28 w-full object-cover rounded">
                                                <div class="mt-2 flex items-center justify-between text-sm">
                                                    <label class="flex items-center space-x-2">
                                                        <input type="radio" name="primary_image_id" value="{{ $img->id }}" {{ $primaryId == $img->id ? 'checked' : '' }}>
                                                        <span>Principal</span>
                                                    </label>
                                                    <label class="flex items-center space-x-2 text-red-600">
                                                        <input type="checkbox" name="delete_image_ids[]" value="{{ $img->id }}">
                                                        <span>Borrar</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">{{ __('Aún no hay imágenes adicionales.') }}</p>
                                @endif

                                <div class="mt-4">
                                    <x-input-label for="images" :value="__('Añadir nuevas imágenes (múltiples)')" />
                                    <input id="images" name="images[]" type="file" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/jpeg,image/png,image/gif,image/svg+xml" />
                                    <div id="multi-image-preview" class="mt-3 grid grid-cols-3 gap-3"></div>
                                </div>
                            </div>

                            {{-- Campo Descripción --}}
                            <div class="mb-4">
                                <x-input-label for="descripcion" :value="__('Descripción Detallada')" />
                                <textarea id="descripcion" name="descripcion" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('descripcion', $patogeno->descripcion) }}</textarea> {{-- Rellenado de datos --}}
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>

                            {{-- Campo Is Active --}}
                            <div class="flex items-center">
                                {{-- Rellenado de datos (usamos la columna de DB si no hay old) --}}
                                <input 
                                    id="is_active" 
                                    name="is_active" 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                    value="1" 
                                    {{ old('is_active', $patogeno->is_active) ? 'checked' : '' }}
                                >
                                <x-input-label for="is_active" :value="__('Activo (Visible en la Guía)')" class="ml-2" />
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                            </div>
                        </div>
                    </div>

                    {{---
                    ### Sección de Relaciones Muchos-a-Muchos
                    ---}}
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">{{ __('Relaciones: Síntomas y Tratamientos') }}</h3>

                        {{-- Preparamos los arrays de IDs asociados al patógeno para la lógica de selección --}}
                        @php
                            $associatedSintomaIds = $patogeno->sintomas->pluck('id')->toArray();
                            $associatedTratamientoIds = $patogeno->tratamientos->pluck('id')->toArray();
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Seleccionar Síntomas --}}
                            <div>
                                <x-input-label for="sintomas" :value="__('Síntomas Asociados')" />
                                {{-- NOTA: Asumiendo que $sintomas viene del controlador --}}
                                <select id="sintomas" name="sintomas[]" multiple class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full h-48">
                                    @foreach($sintomas as $sintoma)
                                        <option 
                                            value="{{ $sintoma->id }}" 
                                            {{-- Lógica clave: Selecciona si está en old() O si está asociado actualmente --}}
                                            {{ in_array($sintoma->id, old('sintomas', $associatedSintomaIds)) ? 'selected' : '' }}
                                        >
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
                                {{-- NOTA: Asumiendo que $tratamientos viene del controlador --}}
                                <select id="tratamientos" name="tratamientos[]" multiple class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full h-48">
                                    @foreach($tratamientos as $tratamiento)
                                        <option 
                                            value="{{ $tratamiento->id }}" 
                                            {{-- Lógica clave: Selecciona si está en old() O si está asociado actualmente --}}
                                            {{ in_array($tratamiento->id, old('tratamientos', $associatedTratamientoIds)) ? 'selected' : '' }}
                                        >
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
                            {{ __('Actualizar Patógeno') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<script>
    document.getElementById('images')?.addEventListener('change', function(event) {
        const container = document.getElementById('multi-image-preview');
        if (!container) return;
        container.innerHTML = '';
        const files = event.target.files;
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-24 w-full object-cover rounded border';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
</x-app-layout>