<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

            <!-- Determinamos si estamos creando o editando -->
            @php
                $isEditing = isset($tratamiento->id);
                $title = $isEditing ? 'Editar Tratamiento' : 'Crear Nuevo Tratamiento';
                $action = $isEditing ? route('tratamientos.update', $tratamiento->id) : route('tratamientos.store');
            @endphp

            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h1>

            <!-- Enlace de regreso -->
            <div class="mb-4">
                <a href="{{ route('tratamientos.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver al Listado
                </a>
            </div>

            <!-- Manejo de Errores de Validación -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <strong class="font-bold">¡Oops!</strong>
                    <span class="block sm:inline">Hay algunos problemas con los datos proporcionados.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario Principal -->
            <form action="{{ $action }}" method="POST">
                @csrf

                @if ($isEditing)
                    @method('PUT') {{-- Método para actualización --}}
                @endif

                <!-- Campo Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Tratamiento:</label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre', $tratamiento->nombre ?? '') }}" 
                           required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Campo Tipo (Dropdown) -->
                <div class="mb-4">
                    <label for="tipo_id" class="block text-sm font-medium text-gray-700">Tipo de Tratamiento:</label>
                    <select name="tipo_id" id="tipo_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccione un Tipo (Opcional)</option>
                        <!-- Iteración de Tipos (Asume que $tipos está disponible) -->
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}" 
                                    {{ old('tipo_id', $tratamiento->tipo_id ?? '') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    
                    <p class="text-xs text-gray-500 mt-1">
                        Nota: Si el Tipo no aparece aquí, debe crearlo en su sección de administración auxiliar.
                    </p>
                </div>

                <!-- Campo Descripción -->
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $tratamiento->descripcion ?? '') }}</textarea>
                    @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Botón de Envío -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                        {{ $isEditing ? 'Actualizar Tratamiento' : 'Guardar Tratamiento' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>