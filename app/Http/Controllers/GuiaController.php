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
        // Obtener el término de búsqueda de la URL (si existe)
        $query = $request->input('query');

        // Iniciar la consulta al modelo Patogeno, cargando la relación 'tipo'
        // Esto es necesario para mostrar el Tipo de Patógeno en la lista (ej: Virus, Bacteria)
        $patogenos = Patogeno::with('tipo');

        // Aplicar filtro de búsqueda si existe un término
        if ($query) {
            // CRÍTICO: Usamos la columna 'nombre' que sí existe en tu tabla 'patogenos'.
            $patogenos = $patogenos->where('nombre', 'LIKE', "%{$query}%");
        }

        // Obtener los patógenos paginados para no sobrecargar la vista.
        // CRÍTICO: Usamos la columna 'nombre' para ordenar.
        $patogenos = $patogenos->orderBy('nombre')->paginate(10);

        // Devolver la vista principal de la guía, pasando los patógenos y el término de búsqueda.
        return view('guia.index', [
            'patogenos' => $patogenos,
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
}