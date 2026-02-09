<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\TipoTratamiento; // Necesario para el dropdown en formularios
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra una lista de los recursos (Tratamientos).
     */
    public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Consulta base con paginación
        $query = Tratamiento::with('tipo');

        // Aplicar filtro si existe término de búsqueda
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        // Obtener resultados paginados (10 por página)
        $tratamientos = $query->orderBy('nombre', 'asc')->paginate(10);

        return view('tratamientos.index', compact('tratamientos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // CRÍTICO: Inyectar la colección de Tipos de Tratamiento
        $tipos = TipoTratamiento::orderBy('nombre')->get();
        
        return view('tratamientos.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     * Almacena un recurso recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->merge(['tipo_id' => $request->input('tipo_id') ?: null]);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:150|unique:tratamientos,nombre',
            'tipo_id' => 'nullable|exists:tipo_tratamientos,id',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $data = [
                'nombre'      => $request->input('nombre'),
                'descripcion' => $request->input('descripcion', ''),
                'tipo_id'     => $request->filled('tipo_id') ? $request->input('tipo_id') : null,
            ];
            Tratamiento::create($data);

            return redirect()->route('tratamientos.index')->with('success', 'Tratamiento creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear tratamiento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al guardar el tratamiento. Inténtelo de nuevo.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Muestra el recurso especificado (opcional para administración).
     */
    public function show(Tratamiento $tratamiento)
    {
        // Para administración, normalmente se redirige a 'edit' o se omite.
        // Si necesitas una vista de detalle, la podrías renderizar aquí.
        return redirect()->route('tratamientos.edit', $tratamiento->id);
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Tratamiento $tratamiento)
    {
        // CRÍTICO: Inyectar la colección de Tipos de Tratamiento
        $tipos = TipoTratamiento::orderBy('nombre')->get();
        
        return view('tratamientos.edit', compact('tratamiento', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza el recurso especificado en la base de datos.
     */
    public function update(Request $request, Tratamiento $tratamiento)
    {
        $request->merge(['tipo_id' => $request->input('tipo_id') ?: null]);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:150|unique:tratamientos,nombre,' . $tratamiento->id,
            'tipo_id' => 'nullable|exists:tipo_tratamientos,id',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $data = [
                'nombre'      => $request->input('nombre'),
                'descripcion' => $request->input('descripcion', ''),
                'tipo_id'     => $request->filled('tipo_id') ? $request->input('tipo_id') : null,
            ];
            $tratamiento->update($data);

            return redirect()->route('tratamientos.index')->with('success', 'Tratamiento actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar tratamiento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al actualizar el tratamiento. Inténtelo de nuevo.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Elimina el recurso especificado de la base de datos.
     */
    public function destroy(Tratamiento $tratamiento)
    {
        try {
            // Eliminar el tratamiento
            $tratamiento->delete();
            
            return redirect()->route('tratamientos.index')->with('success', 'Tratamiento eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar tratamiento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al eliminar el tratamiento.');
        }
    }
}