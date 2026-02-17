<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Patógenos') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

                <form method="GET" action="{{ route('catalogo.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
                    <input
                        type="search"
                        name="query"
                        placeholder="Buscar por nombre del patógeno..."
                        value="{{ $query ?? '' }}"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:flex-1"
                    >
                    <select
                        name="tipo"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-56"
                    >
                        <option value="">{{ __('Todos los tipos') }}</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ (int)($tipoId ?? 0) === $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                        {{ __('Buscar') }}
                    </button>
                    @if ($query || $tipoId)
                        <a href="{{ route('catalogo.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                            {{ __('Limpiar') }}
                        </a>
                    @endif
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($patogenos as $p)
                        <a href="{{ route('guia.show', $p->id) }}" class="block">
                            <div class="relative rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform transform hover:scale-[1.02] bg-gray-50 border border-gray-200">
                                @if ($p->image_url)
                                    <img src="{{ asset($p->image_url) }}" alt="{{ $p->nombre }}" class="h-40 w-full object-cover">
                                @else
                                    <div class="h-40 w-full flex items-center justify-center bg-gray-200 text-gray-600 font-semibold">{{ Str::limit($p->nombre, 20) }}</div>
                                @endif
                                <div class="p-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->tipo?->badgeClass() ?? 'bg-gray-100 text-gray-800' }}">{{ optional($p->tipo)->nombre ?? 'N/A' }}</span>
                                    <h3 class="mt-2 text-lg font-bold text-gray-900 truncate">{{ $p->nombre }}</h3>
                                    @if ($p->alerta_activa)
                                        <p class="mt-1 text-xs font-semibold text-red-600">
                                            {{ __('En alerta por aumento de casos') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center text-gray-500">{{ __('No se encontraron patógenos.') }}</div>
                    @endforelse
                </div>

                <div class="mt-8">{{ $patogenos->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


