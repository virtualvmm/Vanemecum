<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patogeno; // Importamos el modelo Patogeno
use App\Models\TipoPatogeno;

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

        // Secciones dinámicas por cada tipo existente en BD
        $sections = [];
        $tipos = TipoPatogeno::orderBy('nombre')->get();
        foreach ($tipos as $tipo) {
            $sections[$tipo->nombre] = (clone $base)->where('tipo_patogeno_id', $tipo->id)->get();
        }

        return view('guia.index', [
            'sections' => $sections,
            'query' => $query,
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