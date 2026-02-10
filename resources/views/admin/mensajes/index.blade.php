<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mensajes de contacto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-500 text-green-700 dark:text-green-300 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.mensajes.index') }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium {{ ! request('no_leidos') ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Todos
                    </a>
                    <a href="{{ route('admin.mensajes.index', ['no_leidos' => 1]) }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium {{ request('no_leidos') ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        No leídos
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Motivo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mensaje</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($mensajes as $m)
                                <tr class="{{ $m->leido ? '' : 'bg-indigo-50/50 dark:bg-indigo-900/10' }}">
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $m->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $m->user_name }}</span>
                                        <br><span class="text-gray-500 dark:text-gray-400 text-xs">{{ $m->user_email }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $m->tipo_label }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                        {{ Str::limit($m->mensaje, 60) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                        <a href="{{ route('admin.mensajes.show', $m) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mr-2">Ver</a>
                                        <form action="{{ route('admin.mensajes.toggle-leido', $m) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-600 dark:text-gray-400 hover:underline">
                                                {{ $m->leido ? 'Marcar no leído' : 'Marcar leído' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No hay mensajes de contacto.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $mensajes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
