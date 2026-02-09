<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="mb-6">
                <a href="{{ route('tratamientos.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver al Listado
                </a>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $tratamiento->nombre }}</h1>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tipo de Tratamiento</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $tratamiento->tipo->nombre ?? 'Sin tipo asignado' }}</p>
                </div>

                @if($tratamiento->descripcion)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Descripción</h3>
                    <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $tratamiento->descripcion }}</p>
                </div>
                @endif

                @if($tratamiento->duracion_dias)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Duración Estimada</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $tratamiento->duracion_dias }} días</p>
                </div>
                @endif

                @admin
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('tratamientos.edit', $tratamiento) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                        Editar Tratamiento
                    </a>
                </div>
                @endadmin
            </div>
        </div>
    </div>
</x-app-layout>

