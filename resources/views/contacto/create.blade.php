<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulario de Contacto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">
                
                <p class="text-gray-600 mb-4 text-sm">
                    {{ __('Si tienes alguna duda, has encontrado un error o necesitas ayuda, por favor completa el siguiente formulario y nos pondremos en contacto contigo lo antes posible.') }}
                </p>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contacto.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre')" class="text-sm" />
                        <x-text-input 
                            id="nombre" 
                            name="nombre" 
                            type="text" 
                            class="mt-1 block w-full text-sm" 
                            :value="old('nombre', auth()->user()->name ?? '')" 
                            required 
                            autofocus 
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('nombre')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-sm" />
                        <x-text-input 
                            id="email" 
                            name="email" 
                            type="email" 
                            class="mt-1 block w-full text-sm" 
                            :value="old('email', auth()->user()->email ?? '')" 
                            required 
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="asunto" :value="__('Asunto')" class="text-sm" />
                        <x-text-input 
                            id="asunto" 
                            name="asunto" 
                            type="text" 
                            class="mt-1 block w-full text-sm" 
                            :value="old('asunto')" 
                            required 
                            placeholder="Ej: Error encontrado, Duda sobre..."
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('asunto')" />
                    </div>

                    <div>
                        <x-input-label for="mensaje" :value="__('Mensaje')" class="text-sm" />
                        <textarea 
                            id="mensaje" 
                            name="mensaje" 
                            rows="5" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" 
                            required
                            placeholder="Describe tu consulta, el error encontrado o tu duda..."
                        >{{ old('mensaje') }}</textarea>
                        <x-input-error class="mt-1" :messages="$errors->get('mensaje')" />
                    </div>

                    <div class="flex items-center justify-end pt-2">
                        <x-primary-button class="text-sm">
                            {{ __('Enviar Mensaje') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
