<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Listado de mensajes de contacto (solo administrador).
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->orderByDesc('created_at');

        if ($request->boolean('no_leidos')) {
            $query->where('leido', false);
        }

        $mensajes = $query->paginate(15)->withQueryString();

        return view('admin.mensajes.index', compact('mensajes'));
    }

    /**
     * Ver un mensaje y marcarlo como leído.
     */
    public function show(ContactMessage $mensaje): View|RedirectResponse
    {
        if ($mensaje->exists && ! $mensaje->leido) {
            $mensaje->update(['leido' => true]);
        }

        return view('admin.mensajes.show', compact('mensaje'));
    }

    /**
     * Marcar mensaje como leído / no leído.
     */
    public function toggleLeido(ContactMessage $mensaje): RedirectResponse
    {
        $mensaje->update(['leido' => ! $mensaje->leido]);

        return back()->with('success', $mensaje->leido ? 'Mensaje marcado como leído.' : 'Mensaje marcado como no leído.');
    }
}
