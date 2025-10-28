<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guía de Patógenos (Vanemecum)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Formulario de Búsqueda -->
                <form method="GET" action="{{ route('guia.index') }}" class="mb-6 flex space-x-3">
                    <input
                        type="search"
                        name="query"
                        placeholder="Buscar por nombre científico o común..."
                        value="{{ $query ?? '' }}"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    >
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                        {{ __('Buscar') }}
                    </button>
                    @if ($query)
                        <a href="{{ route('guia.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-150 flex items-center">
                            {{ __('Limpiar') }}
                        </a>
                    @endif
                </form>

                <!-- Grid de Patógenos -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($patogenos as $patogeno)
                        {{-- El enlace apunta a la vista de detalle 'guia.show' --}}
                        <a href="{{ route('guia.show', $patogeno->id) }}" class="block">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-lg transition duration-300 transform hover:scale-[1.02]">
                                <!-- Clasificación y Título -->
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                                    @if ($patogeno->clasificacion === 'Bacterias') bg-blue-100 text-blue-800
                                    @elseif ($patogeno->clasificacion === 'Virus') bg-red-100 text-red-800
                                    @elseif ($patogeno->clasificacion === 'Hongos') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif
                                    mb-3">
                                    {{ $patogeno->clasificacion }}
                                </span>

                                <h3 class="text-xl font-bold text-gray-900 mt-2">
                                    {{ $patogeno->nombre_cientifico }}
                                </h3>
                                <p class="text-gray-600 italic">
                                    {{ $patogeno->nombre_comun }}
                                </p>

                                <!-- Información Clave -->
                                <div class="mt-4 space-y-2 text-sm">
                                    <p class="flex items-center text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243m10.606-2.828l-4.243 4.243m0 0L6.757 13.829a1.998 1.998 0 010-2.828l4.243-4.243m0 0L17.657 10.971a1.998 1.998 0 010 2.828z"></path></svg>
                                        <span class="font-semibold">{{ __('Hábitat') }}:</span> {{ \Illuminate\Support\Str::limit($patogeno->habitat, 50) }}
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="font-semibold">{{ __('Transmisión') }}:</span> {{ \Illuminate\Support\Str::limit($patogeno->transmision, 50) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="md:col-span-3 text-center py-10">
                            <p class="text-xl text-gray-500">
                                {{ __('No se encontraron patógenos que coincidan con la búsqueda.') }}
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $patogenos->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>