<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactoRequest;
use App\Models\ContactoMensaje;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactoController extends Controller
{
    /**
     * Muestra el formulario de contacto (público)
     */
    public function create(): View
    {
        return view('contacto.create');
    }

    /**
     * Guarda el mensaje y envía email al admin
     */
    public function store(StoreContactoRequest $request): RedirectResponse
    {
        $mensaje = ContactoMensaje::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'user_id' => auth()->id(), // Si está autenticado, guardamos su ID
            'leido' => false,
        ]);

        // Enviar email al admin
        $admin = User::whereHas('roles', function ($q) {
            $q->where('nombre', 'Admin');
        })->first();

        if ($admin) {
            try {
                Mail::raw(
                    "Nuevo mensaje de contacto:\n\n" .
                    "Nombre: {$mensaje->nombre}\n" .
                    "Email: {$mensaje->email}\n" .
                    "Asunto: {$mensaje->asunto}\n\n" .
                    "Mensaje:\n{$mensaje->mensaje}",
                    function ($message) use ($admin, $mensaje) {
                        $message->to($admin->email)
                                ->subject('Nuevo mensaje de contacto: ' . $mensaje->asunto);
                    }
                );
            } catch (\Exception $e) {
                // Si falla el email, no bloqueamos el guardado
                \Log::error('Error enviando email de contacto: ' . $e->getMessage());
            }
        }

        return redirect()->route('contacto.create')
            ->with('success', 'Tu mensaje ha sido enviado correctamente. Te responderemos pronto.');
    }

    /**
     * Listado de mensajes (solo admin)
     */
    public function index(Request $request): View
    {
        $mensajes = ContactoMensaje::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('contacto.index', compact('mensajes'));
    }

    /**
     * Marcar mensaje como leído
     */
    public function marcarLeido(ContactoMensaje $mensaje): RedirectResponse
    {
        $mensaje->update(['leido' => true]);

        return redirect()->route('admin.contacto.index')
            ->with('success', 'Mensaje marcado como leído.');
    }
}

