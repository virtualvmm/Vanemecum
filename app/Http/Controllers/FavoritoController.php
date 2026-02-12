<?php

namespace App\Http\Controllers;

use App\Models\Patogeno;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Listado de patógenos favoritos del usuario.
     */
    public function index()
    {
        $patogenos = auth()->user()
            ->patogenos()
            ->with('tipo')
            ->orderBy('nombre')
            ->get();

        return view('favoritos.index', compact('patogenos'));
    }

    /**
     * Añadir patógeno a favoritos.
     */
    public function store(Request $request, Patogeno $patogeno)
    {
        auth()->user()->patogenos()->syncWithoutDetaching([$patogeno->id]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'message' => __('Añadido a Mis patógenos')]);
        }

        return back()->with('success', __('Añadido a Mis patógenos.'));
    }

    /**
     * Quitar patógeno de favoritos.
     */
    public function destroy(Request $request, Patogeno $patogeno)
    {
        auth()->user()->patogenos()->detach($patogeno->id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'message' => __('Quitado de Mis patógenos')]);
        }

        return back()->with('success', __('Quitado de Mis patógenos.'));
    }
}
