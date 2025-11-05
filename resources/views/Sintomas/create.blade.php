<x-app-layout>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                ➕ Crear Nuevo Síntoma
            </h2>

            <form action="{{ route('admin.sintomas.store') }}" method="POST">
                @include('Sintomas.form', [
                    'sintoma' => $sintoma ?? new \App\Models\Sintoma(),
                    'submitButtonText' => 'Crear Síntoma'
                ])
            </form>
        </div>
    </div>
    </div>
</x-app-layout>