<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Patógenos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="GET" action="{{ route('catalogo.index') }}" class="mb-6 flex space-x-3">
                    <input type="search" name="query" placeholder="Buscar por nombre o descripción del patógeno..." value="{{ $query ?? '' }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">{{ __('Buscar') }}</button>
                    @if ($query)
                        <a href="{{ route('catalogo.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">{{ __('Limpiar') }}</a>
                    @endif
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($patogenos as $p)
                        @php
                            $tipo = optional($p->tipo)->nombre;
                            $badge = match ($tipo) {
                                'Virus' => 'bg-red-100 text-red-800',
                                'Bacterias' => 'bg-blue-100 text-blue-800',
                                'Hongos' => 'bg-green-100 text-green-800',
                                'Parásitos' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <a href="{{ route('guia.show', $p->id) }}" class="block">
                            <div class="rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform transform hover:scale-[1.02] bg-gray-50 border border-gray-200">
                                @if ($p->image_url)
                                    <img src="{{ $p->image_url }}" alt="{{ $p->nombre }}" class="h-40 w-full object-cover">
                                @else
                                    <div class="h-40 w-full flex items-center justify-center bg-gray-200 text-gray-600 font-semibold">{{ Str::limit($p->nombre, 20) }}</div>
                                @endif
                                <div class="p-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge }}">{{ $tipo ?? 'N/A' }}</span>
                                    <h3 class="mt-2 text-lg font-bold text-gray-900 truncate">{{ $p->nombre }}</h3>
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


