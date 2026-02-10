<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mensaje de contacto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fecha</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Usuario</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $mensaje->user_name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="mailto:{{ $mensaje->user_email }}" class="hover:underline">{{ $mensaje->user_email }}</a>
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Motivo</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $mensaje->tipo_label }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Mensaje</span>
                        <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $mensaje->mensaje }}</div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('admin.mensajes.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        ← Volver al listado
                    </a>
                    <form action="{{ route('admin.mensajes.toggle-leido', $mensaje) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-gray-600 dark:text-gray-400 hover:underline">
                            {{ $mensaje->leido ? 'Marcar como no leído' : 'Marcar como leído' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
