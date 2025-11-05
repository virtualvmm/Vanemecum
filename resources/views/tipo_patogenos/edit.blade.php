@extends('layouts.admin')

@section('title', 'Editar Tipo de Patógeno: ' . $tipo->nombre)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
        ✏️ Editar Tipo de Patógeno: <span class="text-teal-600 dark:text-teal-400">{{ $tipo->nombre }}</span>
    </h2>

    <form action="{{ route('admin.tipo_patogenos.update', $tipo) }}" method="POST">
        @method('PUT') 
        {{-- ¡CORRECCIÓN! Incluye el partial sin el guion bajo: 'tipo_patogenos.form' --}}
        @include('tipo_patogenos.form', [
            'submitButtonText' => 'Guardar Cambios'
        ])
    </form>
</div>
@endsection