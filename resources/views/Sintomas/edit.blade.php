<x-app-layout>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                ✏️ Editar Síntoma: <span class="text-teal-600 dark:text-teal-400">{{ $sintoma->nombre }}</span>
            </h2>

            <form action="{{ route('admin.sintomas.update', $sintoma) }}" method="POST">
                @method('PUT')
                @include('Sintomas.form', [
                    'sintoma' => $sintoma,
                    'submitButtonText' => 'Guardar Cambios'
                ])
            </form>
        </div>
    </div>
    </div>
</x-app-layout>