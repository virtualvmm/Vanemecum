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
     * Ver un mensaje. Lo marca como leído solo si se entra desde el listado (no al volver desde el toggle).
     */
    public function show(ContactMessage $mensaje): View|RedirectResponse
    {
        $vieneDelToggle = request()->boolean('from_toggle');
        if ($mensaje->exists && ! $mensaje->leido && ! $vieneDelToggle) {
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

        $message = $mensaje->leido ? 'Mensaje marcado como leído.' : 'Mensaje marcado como no leído.';

        return redirect()->route('admin.mensajes.show', ['mensaje' => $mensaje, 'from_toggle' => 1])
            ->with('success', $message);
    }
}
