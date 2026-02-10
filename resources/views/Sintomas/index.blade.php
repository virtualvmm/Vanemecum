<x-app-layout>

<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            📚 Listado de Síntomas
        </h2>
        @admin
            <a href="{{ route('admin.sintomas.create') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Nuevo Síntoma
            </a>
        @endadmin
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.sintomas.index') }}" class="mb-6 flex flex-wrap items-center gap-2">
        <input type="search" name="query" value="{{ request('query') }}"
               placeholder="Buscar por nombre o descripción del síntoma..."
               class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 w-full sm:w-auto min-w-[200px]">
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-md transition duration-150">
            Buscar
        </button>
        @if (request('query'))
            <a href="{{ route('admin.sintomas.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm">
                Limpiar
            </a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Gravedad
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Descripción
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($sintomas as $sintoma)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $sintoma->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $color = [1 => 'bg-green-100 text-green-800', 2 => 'bg-blue-100 text-blue-800', 3 => 'bg-yellow-100 text-yellow-800', 4 => 'bg-orange-100 text-orange-800', 5 => 'bg-red-100 text-red-800'][$sintoma->gravedad] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                Nivel {{ $sintoma->gravedad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300 max-w-xs truncate">
                            {{ Str::limit($sintoma->descripcion, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @admin
                                <a href="{{ route('admin.sintomas.edit', $sintoma) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">
                                    Editar
                                </a>
                                {{-- Llamada al modal de Alpine.js --}}
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', {id: {{ $sintoma->id }}, name: '{{ $sintoma->nombre }}'})" 
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Eliminar
                                </button>
                            @endadmin
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No se han encontrado síntomas. Por favor, añada uno nuevo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $sintomas->links() }} {{-- Implementación de Paginación --}}
    </div>
    </div>
    </div>
</div>

{{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN CON ALPINE.JS --}}
<div x-data="{ open: false, itemId: null, itemName: '' }"
    @open-modal.window="open = true; itemId = $event.detail.id; itemName = $event.detail.name;"
    x-show="open" 
    class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50" 
    style="display: none;">
    <div class="flex items-center justify-center min-h-screen">
        <div x-show="open" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            @click.outside="open = false"
            class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full p-6">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Confirmar Eliminación</h3>
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-300">
                ¿Está seguro de que desea eliminar el síntoma **<span x-text="itemName" class="font-bold"></span>**? Esta acción es irreversible y desvinculará este síntoma de todos los patógenos relacionados.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                    Cancelar
                </button>
                <form :action="'{{ url('admin/sintomas') }}/' + itemId" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition duration-150">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</x-app-layout>