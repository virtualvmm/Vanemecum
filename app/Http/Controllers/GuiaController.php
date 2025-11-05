<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patogeno; // Importamos el modelo Patogeno

class GuiaController extends Controller
{
    /**
     * Muestra el índice (la página principal) de la Guía de Patógenos (Vanemecum).
     * Incluye lógica para buscar patógenos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $base = Patogeno::with('tipo')
            ->when($query, function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%");
            })
            ->orderBy('nombre');

        // Cargar colecciones por tipo (para carrusel estilo Netflix)
        $virus = (clone $base)->whereHas('tipo', fn($q) => $q->where('nombre', 'Virus'))->get();
        $bacterias = (clone $base)->whereHas('tipo', fn($q) => $q->where('nombre', 'Bacteria'))->get();
        $hongos = (clone $base)->whereHas('tipo', fn($q) => $q->where('nombre', 'Hongo'))->get();
        $parasitos = (clone $base)->whereHas('tipo', fn($q) => $q->where('nombre', 'Parásito'))->get();

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
        // El Patogeno ya viene precargado gracias a Route Model Binding.
        // Cargamos todas las relaciones necesarias para mostrar la ficha completa.
        // NOTA: 'farmacos' se ha corregido a 'tratamientos', según tu modelo Patogeno.php
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
            ->when($query, fn($q) => $q->where('nombre', 'LIKE', "%{$query}%"))
            ->orderBy('nombre')
            ->paginate(18);

        return view('guia.catalog', compact('patogenos', 'query'));
    }
}