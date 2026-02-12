<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patogeno;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertaController extends Controller
{
    /**
     * Módulo de alertas: lista los patógenos con alerta activa.
     */
    public function index(Request $request): View
    {
        $query = Patogeno::with('tipo')
            ->where('alerta_activa', true)
            ->orderBy('nombre');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', '%' . $search . '%');
        }

        $patogenos = $query->paginate(15)->withQueryString();

        return view('admin.alertas.index', compact('patogenos'));
    }
}

