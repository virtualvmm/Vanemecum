<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Alertas de patógenos') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Listado de patógenos que actualmente están marcados con alerta por aumento de casos.') }}
                    </p>

                    <form method="GET" action="{{ route('admin.alertas.index') }}" class="w-full sm:w-auto">
                        <div class="flex flex-col sm:flex-row gap-2 items-stretch sm:items-center">
                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('Buscar por nombre de patógeno...') }}"
                                title="{{ __('Buscar por nombre de patógeno...') }}"
                                class="w-full min-w-0 sm:w-80 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-md">
                                {{ __('Buscar') }}
                            </button>
                            @if (request('search'))
                                <a href="{{ route('admin.alertas.index') }}" class="text-gray-500 dark:text-gray-300 text-sm hover:underline px-2 py-2">
                                    {{ __('Limpiar') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Nombre') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Tipo') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Mensaje de alerta') }}
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Acciones') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($patogenos as $p)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $p->nombre }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ optional($p->tipo)->nombre ?? 'N/D' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-red-700 dark:text-red-300 max-w-md">
                                        {{ $p->alerta_texto ?: __('Alerta activa sin mensaje específico.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right whitespace-nowrap">
                                        <a href="{{ route('patogenos.edit', $p) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                            {{ __('Editar patógeno') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('No hay patógenos en alerta actualmente.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $patogenos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

