@extends('layouts.admin')

@section('title', 'Crear Nuevo Tipo de Patógeno')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
        ➕ Crear Nuevo Tipo de Patógeno
    </h2>

    <form action="{{ route('admin.tipo_patogenos.store') }}" method="POST">
        {{-- ¡CORRECCIÓN! Incluye el partial sin el guion bajo: 'tipo_patogenos.form' --}}
        @include('tipo_patogenos.form', [ 
            'tipo' => new \App\Models\TipoPatogeno(), 
            'submitButtonText' => 'Crear Tipo de Patógeno'
        ])
    </form>
</div>
@endsection