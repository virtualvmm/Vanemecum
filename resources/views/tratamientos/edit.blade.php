<!-- resources/views/tratamientos/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Simplemente incluye el formulario reutilizable, pasándole el objeto a editar -->
    @include('tratamientos.form', ['tratamiento' => $tratamiento, 'tipos' => $tipos])
@endsection
