<?php

namespace App\Http\Controllers;

use App\Models\Patogeno;
use App\Models\TipoPatogeno;
use Illuminate\Http\Request;

class GuiaController extends Controller
{
    /**
     * Índice de la Guía: una consulta, agrupada por tipo para los carruseles.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $tipoId = $request->input('tipo');

        $patogenos = Patogeno::with('tipo')
            ->activos()
            ->filtradoGuia($query, $tipoId)
            ->get();

        $byTipo = $patogenos->groupBy(fn ($p) => $p->tipo?->nombre ?? 'Otros');
        $tipos = TipoPatogeno::orderBy('nombre')->get();

        return view('guia.index', [
            'virus' => $byTipo->get('Virus', collect()),
            'bacterias' => $byTipo->get('Bacterias', collect()),
            'hongos' => $byTipo->get('Hongos', collect()),
            'parasitos' => $byTipo->get('Parásitos', collect()),
            'query' => $query,
            'tipoId' => $tipoId,
            'tipos' => $tipos,
        ]);
    }


    /**
     * Muestra la página de detalle de un patógeno específico.
     *
     * @param  \App\Models\Patogeno  $patogeno (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function show(Patogeno $patogeno)
    {
        $patogeno->load('tipo', 'tratamientos', 'sintomas', 'fuente');

        $user = auth()->user();
        $esFavorito = $user ? $user->patogenos()->where('patogenos.id', $patogeno->id)->exists() : false;

        return view('guia.show', compact('patogeno', 'esFavorito'));
    }

    /**
     * Catálogo público en cuadrícula (paginado).
     */
    public function catalogo(Request $request)
    {
        $query = $request->input('query');
        $tipoId = $request->input('tipo');

        $patogenos = Patogeno::with('tipo')
            ->activos()
            ->filtradoGuia($query, $tipoId)
            ->paginate(18);

        $tipos = TipoPatogeno::orderBy('nombre')->get();

        return view('guia.catalog', compact('patogenos', 'query', 'tipoId', 'tipos'));
    }
}