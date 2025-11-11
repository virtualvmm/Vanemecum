<!-- resources/views/tratamientos/edit.blade.php -->

<x-app-layout>
    @include('tratamientos.form', ['tratamiento' => $tratamiento, 'tipos' => $tipos])
</x-app-layout>
