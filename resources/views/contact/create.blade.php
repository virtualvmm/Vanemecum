<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contactar') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Use este formulario para reportar un error, sugerir la inclusión de un nuevo patógeno o enviar cualquier consulta. El mensaje se enviará por correo al administrador.
                </p>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-500 text-green-700 dark:text-green-300 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-500 text-red-700 dark:text-red-300 rounded-lg" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="tipo" :value="__('Motivo del contacto')" />
                        <select name="tipo" id="tipo" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($tipos as $value => $label)
                                <option value="{{ $value }}" {{ old('tipo') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('tipo')" />
                    </div>

                    <div>
                        <x-input-label for="mensaje" :value="__('Mensaje')" />
                        <textarea name="mensaje" id="mensaje" rows="6" required
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Describa el error, el patógeno que desea sugerir o su consulta (mín. 10 caracteres)...">{{ old('mensaje') }}</textarea>
                        <x-input-error class="mt-1" :messages="$errors->get('mensaje')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button type="submit">
                            {{ __('Enviar mensaje') }}
                        </x-primary-button>
                        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 text-sm">
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
