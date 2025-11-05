<?php

namespace App\Http\Controllers\Admin; // IMPORTANTE: Cambiamos al namespace Admin

use App\Http\Controllers\Controller;
use App\Models\Sintoma; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SintomaController extends Controller
{
    /**
     * Define los niveles de gravedad disponibles para el formulario.
     */
    private function getGravedadLevels(): array
    {
        return [
            1 => '1 (Leve - Suele remitir)', 
            2 => '2 (Bajo - Puede requerir atención)', 
            3 => '3 (Medio - Evaluación necesaria)', 
            4 => '4 (Alto - Requiere tratamiento específico)', 
            5 => '5 (Crítico - Atención médica inmediata)'
        ];
    }

    /**
     * Muestra el listado de todos los Síntomas con soporte para búsqueda.
     */
    public function index(Request $request): View
    {
        $query = $request->input('query');
        
        // Carga la lista de síntomas con paginación y aplica búsqueda (mantenemos su lógica)
        $sintomas = Sintoma::when($query, function ($q) use ($query) {
            $q->where('nombre', 'LIKE', "%{$query}%")
              ->orWhere('descripcion', 'LIKE', "%{$query}%");
        })
        ->orderBy('nombre')
        ->paginate(10);
        
        // Ajuste de path de vista a carpeta existente 'resources/views/Sintomas'
        return view('Sintomas.index', compact('sintomas', 'query'));
    }

    /**
     * Muestra el formulario para crear un nuevo Síntoma.
     */
    public function create(): View
    {
        $gravedades = $this->getGravedadLevels();

        // Ajuste de path de vista a carpeta existente 'resources/views/Sintomas'
        return view('Sintomas.create', [
            'sintoma' => new Sintoma(), 
            'gravedades' => $gravedades
        ]);
    }

    /**
     * Almacena un nuevo Síntoma en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de datos: Añadimos la regla para 'gravedad'
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:sintomas,nombre'],
            'gravedad' => ['required', 'integer', 'min:1', 'max:5'], // Validación clave
            'descripcion' => ['nullable', 'string'],
        ]);

        Sintoma::create($request->all());

        // Redirección con nombre de ruta 'admin.sintomas.index'
        return redirect()->route('admin.sintomas.index')->with('success', 'El Síntoma ha sido creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un Síntoma existente.
     */
    public function edit(Sintoma $sintoma): View
    {
        $gravedades = $this->getGravedadLevels();

        // Ajuste de path de vista a carpeta existente 'resources/views/Sintomas'
        return view('Sintomas.edit', compact('sintoma', 'gravedades'));
    }

    /**
     * Actualiza el Síntoma en la base de datos.
     */
    public function update(Request $request, Sintoma $sintoma): RedirectResponse
    {
        // Validación de datos: Incluimos gravedad y Rule::unique (su lógica)
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('sintomas', 'nombre')->ignore($sintoma->id)],
            'gravedad' => ['required', 'integer', 'min:1', 'max:5'], // Validación clave
            'descripcion' => ['nullable', 'string'],
        ]);

        $sintoma->update($request->all());

        // Redirección con nombre de ruta 'admin.sintomas.index'
        return redirect()->route('admin.sintomas.index')->with('success', 'El Síntoma ha sido actualizado con éxito.');
    }

    /**
     * Elimina un Síntoma de la base de datos.
     */
    public function destroy(Sintoma $sintoma): RedirectResponse
    {
        // La eliminación en cascada en la tabla pivote es manejada por el motor de BD.
        $sintoma->delete();

        // Redirección con nombre de ruta 'admin.sintomas.index'
        return redirect()->route('admin.sintomas.index')->with('success', 'El Síntoma ha sido eliminado correctamente.');
    }
}