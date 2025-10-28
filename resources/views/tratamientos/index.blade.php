<x-app-layout>
    <!-- Contenedor principal y título -->
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Administración de Tratamientos</h1>
                <!-- Botón de Crear -->
                <a href="{{ route('tratamientos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Nuevo Tratamiento
                </a>
            </div>

            <!-- Mensajes de Estado (Éxito) -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulario de Búsqueda -->
            <form action="{{ route('tratamientos.index') }}" method="GET" class="mb-6">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}"
                           class="w-full sm:w-1/3 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                        Buscar
                    </button>
                    <!-- Limpiar búsqueda -->
                    @if (request('search'))
                        <a href="{{ route('tratamientos.index') }}" class="text-gray-500 hover:text-gray-700 py-2 px-4">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabla de Listado de Tratamientos -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción Breve
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tratamientos as $tratamiento)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tratamiento->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $tratamiento->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <!-- Muestra el nombre del tipo, o 'Sin Tipo' si es nulo -->
                                    {{ $tratamiento->tipo->nombre ?? 'Sin Tipo' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <!-- Muestra una descripción corta -->
                                    {{ Str::limit($tratamiento->descripcion, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('tratamientos.edit', $tratamiento->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                    
                                    <!-- Botón Eliminar (Formulario) -->
                                    <form action="{{ route('tratamientos.destroy', $tratamiento->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este tratamiento? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-lg text-gray-500">
                                    No se encontraron tratamientos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $tratamientos->links() }}
            </div>

        </div>
    </div>
</x-app-layout>