<?php

namespace App\Http\Controllers;

use App\Models\Patogeno;
use Illuminate\Http\Request;

class GuiaController extends Controller
{
    /**
     * Muestra el índice (la página principal) de la Guía de Patógenos (Vanemecum).
     * Una sola consulta a BD; se agrupa por tipo en PHP para los carruseles.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $patogenos = Patogeno::with('tipo')
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                  ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->orderBy('nombre')
            ->get();

        // Agrupar por nombre del tipo (una sola consulta ya hecha)
        $byTipo = $patogenos->groupBy(fn ($p) => $p->tipo?->nombre ?? 'Otros');
        $virus = $byTipo->get('Virus', collect());
        $bacterias = $byTipo->get('Bacterias', collect());
        $hongos = $byTipo->get('Hongos', collect());
        $parasitos = $byTipo->get('Parásitos', collect());

        return view('guia.index', compact('virus', 'bacterias', 'hongos', 'parasitos', 'query'));
    }


    /**
     * Muestra la página de detalle de un patógeno específico.
     *
     * @param  \App\Models\Patogeno  $patogeno (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function show(Patogeno $patogeno)
    {
        // Route Model Binding ya carga el patógeno; eager load de relaciones para la ficha.
        $patogeno->load('tipo', 'tratamientos', 'sintomas', 'fuente');

        // Devolver la vista de detalle, pasando el objeto patogeno completo.
        return view('guia.show', [
            'patogeno' => $patogeno,
        ]);
    }

    /**
     * Catálogo público de todos los patógenos en cuadrícula.
     */
    public function catalogo(Request $request)
    {
        $query = $request->input('query');
        $patogenos = Patogeno::with('tipo')
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                  ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->orderBy('nombre')
            ->paginate(18);

        return view('guia.catalog', compact('patogenos', 'query'));
    }
}