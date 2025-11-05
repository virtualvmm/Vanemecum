@extends('layouts.admin')

@section('title', 'Gestión de Tipos de Patógeno')

@section('content')

<div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            🧬 Listado de Tipos de Patógeno
        </h2>
        <a href="{{ route('admin.tipo_patogenos.create') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
            + Nuevo Tipo
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- Formulario de Búsqueda --}}
    <form method="GET" action="{{ route('admin.tipo_patogenos.index') }}" class="mb-4">
        <div class="flex">
            <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Buscar por nombre o descripción..."
                   class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
            <button type="submit" class="px-4 py-2 bg-gray-200 border border-gray-300 rounded-r-md hover:bg-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:hover:bg-gray-500">
                Buscar
            </button>
        </div>
    </form>


    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nombre
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
                @forelse ($tipos as $tipo)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $tipo->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 font-medium">
                            {{ $tipo->nombre }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300 max-w-xs truncate">
                            {{ Str::limit($tipo->descripcion, 70) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.tipo_patogenos.edit', $tipo) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">
                                Editar
                            </a>
                            {{-- Llamada al modal de Alpine.js --}}
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', {id: {{ $tipo->id }}, name: '{{ $tipo->nombre }}'})" 
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No se han encontrado Tipos de Patógeno.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $tipos->links() }} {{-- Implementación de Paginación --}}
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
                ¿Está seguro de que desea eliminar el Tipo de Patógeno **<span x-text="itemName" class="font-bold"></span>**? Esta acción es irreversible y podría afectar a los patógenos que dependen de él.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                    Cancelar
                </button>
                {{-- La acción del formulario usa la ruta URL --}}
                <form :action="'{{ url('admin/tipo-patogenos') }}/' + itemId" method="POST" class="inline">
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
@endsection