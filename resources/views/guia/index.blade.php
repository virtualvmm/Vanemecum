<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guía de Patógenos (Vanemecum)') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

                <!-- Formulario de Búsqueda y Filtro por Tipo -->
                <form method="GET" action="{{ route('guia.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
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
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                        {{ __('Buscar') }}
                    </button>
                    @if ($query || $tipoId)
                        <a href="{{ route('guia.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-150 flex items-center">
                            {{ __('Limpiar') }}
                        </a>
                    @endif
                </form>

                <!-- Carruseles por tipo (estilo Netflix) -->
                @php
                    $sections = [
                        'Virus' => $virus ?? collect(),
                        'Bacterias' => $bacterias ?? collect(),
                        'Hongos' => $hongos ?? collect(),
                        'Parásitos' => $parasitos ?? collect(),
                    ];
                @endphp
                @foreach ($sections as $title => $items)
                    @if ($items->count())
                        <div class="mt-10">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                            <div class="relative">
                                <div class="flex gap-4 sm:gap-6 overflow-x-auto pb-4 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-thin" style="scrollbar-width: thin;">
                                    @foreach ($items as $p)
                                        <a href="{{ route('guia.show', $p->id) }}" class="flex-none w-56 min-w-[200px] sm:w-64">
                                            <div class="relative rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform transform hover:scale-[1.02] bg-white {{ $p->tipo?->borderClass() ?? 'border-l-4 border-gray-400' }}">
                                                @if ($p->image_url)
                                                    <img src="{{ $p->image_url }}" alt="{{ $p->nombre }}" class="h-44 w-full object-cover">
                                                @else
                                                    <div class="h-44 w-full flex items-center justify-center {{ $p->tipo?->placeholderBgClass() ?? 'bg-gray-500' }} text-white font-semibold">{{ Str::limit($p->nombre, 22) }}</div>
                                                @endif
                                                @if ($p->alerta_activa)
                                                    <span class="absolute top-2 right-2 inline-flex items-center px-2 py-1 text-xs font-bold rounded-full bg-red-600 text-white shadow">
                                                        {{ __('ALERTA') }}
                                                    </span>
                                                @endif
                                                <div class="p-3 {{ $p->tipo?->cardFooterClass() ?? 'bg-gray-50 text-gray-900' }}">
                                                    <p class="text-xs uppercase tracking-wide {{ $p->tipo?->labelClass() ?? 'text-gray-600 font-medium' }}">{{ optional($p->tipo)->nombre }}</p>
                                                    <h4 class="text-base font-semibold leading-tight truncate mt-0.5">{{ $p->nombre }}</h4>
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