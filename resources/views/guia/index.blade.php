<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guía de Patógenos (Vanemecum)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
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

                <!-- Carruseles por tipo (estilo Netflix) -->
                @php
                    $typeColors = [
                        'Virus' => 'bg-red-600',
                        'Bacterias' => 'bg-blue-600',
                        'Hongos' => 'bg-green-600',
                        'Parásitos' => 'bg-yellow-600',
                    ];
                @endphp

                @foreach ($sections as $title => $items)
                    @if ($items->count())
                        <div class="mt-10">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                            <div class="relative">
                                <div class="flex space-x-6 overflow-x-auto scrollbar-thin pb-4">
                                    @foreach ($items as $p)
                                        <a href="{{ route('guia.show', $p->id) }}" class="flex-none w-64">
                                            <div class="rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform transform hover:scale-[1.02] bg-gray-100">
                                                @if ($p->image_url)
                                                    <img src="{{ $p->image_url }}" alt="{{ $p->nombre }}" class="h-44 w-full object-cover">
                                                @else
                                                    <div class="h-44 w-full flex items-center justify-center {{ $typeColors[$title] ?? 'bg-indigo-600' }} text-white font-semibold">{{ Str::limit($p->nombre, 22) }}</div>
                                                @endif
                                                <div class="p-3">
                                                    <p class="text-sm text-gray-500">{{ optional($p->tipo)->nombre }}</p>
                                                    <h4 class="text-base font-semibold text-gray-900 leading-tight truncate">{{ $p->nombre }}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>