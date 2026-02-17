<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis patógenos') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-500 text-green-700 dark:text-green-300 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Aquí aparecen los patógenos que has guardado como favoritos. Puedes abrirlos para ver la ficha o quitarlos de la lista.') }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($patogenos as $p)
                        <div class="relative rounded-xl overflow-hidden shadow hover:shadow-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                            <a href="{{ route('guia.show', $p->id) }}" class="block">
                                @if ($p->image_url)
                                    <img src="{{ asset($p->image_url) }}" alt="{{ $p->nombre }}" class="h-40 w-full object-cover">
                                @else
                                    <div class="h-40 w-full flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 font-semibold">{{ Str::limit($p->nombre, 20) }}</div>
                                @endif
                                <div class="p-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->tipo?->badgeClass() ?? 'bg-gray-100 text-gray-800' }} dark:bg-gray-700 dark:text-gray-300">{{ optional($p->tipo)->nombre ?? 'N/A' }}</span>
                                    <h3 class="mt-2 text-lg font-bold text-gray-900 dark:text-gray-100 truncate">{{ $p->nombre }}</h3>
                                    @if ($p->alerta_activa)
                                        <p class="mt-1 text-xs font-semibold text-red-600 dark:text-red-400">
                                            {{ __('En alerta por aumento de casos') }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                            <form action="{{ route('favoritos.destroy', $p) }}" method="POST" class="absolute top-2 right-2 z-10" onsubmit="return confirm('{{ __('¿Quitar de Mis patógenos?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-full bg-white/90 dark:bg-gray-800/90 shadow text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30" title="{{ __('Quitar de favoritos') }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                            <p class="text-lg">{{ __('Aún no tienes patógenos guardados.') }}</p>
                            <p class="mt-2">{{ __('Entra en la Guía Rápida o el Catálogo y pulsa el corazón en los patógenos que quieras guardar.') }}</p>
                            <a href="{{ route('guia.index') }}" class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg">
                                {{ __('Ir a Guía Rápida') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
