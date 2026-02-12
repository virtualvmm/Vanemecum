<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de Patógenos') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6 lg:p-8">

                {{-- Mensaje de Éxito --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Header y Botón de Creación --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <h3 class="text-2xl font-bold text-gray-700">{{ __('Lista de Patógenos') }}</h3>
                    @admin
                        <a href="{{ route('patogenos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 shadow-md flex-shrink-0">
                            {{ __('Crear Nuevo Patógeno') }}
                        </a>
                    @endadmin
                </div>

                {{-- Búsqueda --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('patogenos.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-2">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Buscar por nombre o descripción..." 
                            value="{{ request('query') }}" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:max-w-xs md:w-64 flex-1"
                        />
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded shadow-md transition duration-150">
                                {{ __('Buscar') }}
                            </button>
                            @if(request('query'))
                                <a href="{{ route('patogenos.index') }}" class="text-red-500 hover:text-red-700 p-2" title="Limpiar búsqueda">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                {{-- Contenedor principal para la tabla y el modal de Alpine.js --}}
                <div x-data="{ openDeleteModal: false, deleteUrl: '' }">
                    
                    {{-- Tabla de Patógenos --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Bucle sobre los patógenos --}}
                                @forelse ($patogenos as $patogeno)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        {{-- Celda de Imagen --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($patogeno->image_url)
                                                <img src="{{ $patogeno->image_url }}" alt="{{ $patogeno->nombre }}" class="h-10 w-10 object-cover rounded-full shadow">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-xs text-gray-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-1.586-1.586a2 2 0 00-2.828 0L10 18m0 0l-4-4"></path></svg>
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $patogeno->nombre }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $patogeno->tipo->nombre ?? 'N/A' }}
                                        </td>

                                        {{-- Celda de Descripción --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $patogeno->descripcion }}">
                                            {{ Str::limit($patogeno->descripcion, 70) }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $patogeno->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $patogeno->is_active ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end space-x-3">
                                            @admin
                                                {{-- Botón Editar --}}
                                                <a href="{{ route('patogenos.edit', $patogeno) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                                                    {{ __('Editar') }}
                                                </a>

                                                {{-- Botón Eliminar (ahora abre el modal) --}}
                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal = true; deleteUrl = '{{ route('patogenos.destroy', $patogeno) }}'"
                                                    class="text-red-600 hover:text-red-900 transition duration-150"
                                                >
                                                    {{ __('Eliminar') }}
                                                </button>
                                            @endadmin
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            {{ __('No se encontraron patógenos.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $patogenos->links() }}
                    </div>
                
                    {{-- MODAL DE CONFIRMACIÓN DE BORRADO (Alpine.js y Tailwind CSS) --}}
                    <div 
                        x-show="openDeleteModal" 
                        class="fixed inset-0 z-50 overflow-y-auto" 
                        aria-labelledby="modal-title" 
                        role="dialog" 
                        aria-modal="true"
                        style="display: none;"
                    >
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            {{-- Overlay --}}
                            <div x-show="openDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openDeleteModal = false" aria-hidden="true"></div>

                            {{-- Contenido del Modal --}}
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="openDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                            >
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <!-- Icono de Advertencia -->
                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Confirmar Eliminación
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    ¿Estás seguro de que quieres **eliminar este patógeno**? Esta acción es irreversible y los datos se perderán permanentemente.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    {{-- Formulario real de Eliminación dentro del modal --}}
                                    <form x-bind:action="deleteUrl" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                                            Sí, Eliminar
                                        </button>
                                    </form>
                                    
                                    <button @click="openDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- FIN DEL MODAL --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>