<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoPatogeno;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TipoPatogenoController extends Controller
{
    /**
     * Muestra el listado de todos los Tipos de Patógeno con soporte para búsqueda.
     */
    public function index(Request $request): View
    {
        $query = $request->input('query');
        
        $tipos = TipoPatogeno::when($query, function ($q) use ($query) {
            $q->where('nombre', 'LIKE', "%{$query}%")
              ->orWhere('descripcion', 'LIKE', "%{$query}%");
        })
        ->orderBy('nombre')
        ->paginate(10);
        
        // Vista: resources/views/tipo_patogenos/index.blade.php
        return view('tipo_patogenos.index', compact('tipos', 'query'));
    }

    /**
     * Muestra el formulario para crear un nuevo Tipo de Patógeno.
     */
    public function create(): View
    {
        // Vista: resources/views/tipo_patogenos/create.blade.php
        return view('tipo_patogenos.create', ['tipo' => new TipoPatogeno()]);
    }

    /**
     * Almacena un nuevo Tipo de Patógeno en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:tipo_patogenos,nombre'],
            'descripcion' => ['nullable', 'string'],
        ]);

        TipoPatogeno::create($request->all());

        return redirect()->route('admin.tipo_patogenos.index')->with('success', 'El Tipo de Patógeno ha sido creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un Tipo de Patógeno existente.
     */
    public function edit(TipoPatogeno $tipoPatogeno): View
    {
        // Vista: resources/views/tipo_patogenos/edit.blade.php
        return view('tipo_patogenos.edit', ['tipo' => $tipoPatogeno]);
    }

    /**
     * Actualiza el Tipo de Patógeno en la base de datos.
     */
    public function update(Request $request, TipoPatogeno $tipoPatogeno): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('tipo_patogenos', 'nombre')->ignore($tipoPatogeno->id)],
            'descripcion' => ['nullable', 'string'],
        ]);

        $tipoPatogeno->update($request->all());

        return redirect()->route('admin.tipo_patogenos.index')->with('success', 'El Tipo de Patógeno ha sido actualizado con éxito.');
    }

    /**
     * Elimina un Tipo de Patógeno de la base de datos.
     */
    public function destroy(TipoPatogeno $tipoPatogeno): RedirectResponse
    {
        $tipoPatogeno->delete();

        return redirect()->route('admin.tipo_patogenos.index')->with('success', 'El Tipo de Patógeno ha sido eliminado correctamente.');
    }
}