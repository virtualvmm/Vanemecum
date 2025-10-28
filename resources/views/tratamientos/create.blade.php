<!-- resources/views/tratamientos/create.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Simplemente incluye el formulario reutilizable -->
    @include('tratamientos.form', ['tratamiento' => new \App\Models\Tratamiento(), 'tipos' => $tipos])
@endsection
