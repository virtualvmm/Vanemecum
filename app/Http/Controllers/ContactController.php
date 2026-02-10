<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Muestra el formulario de contacto (usuarios autenticados). Si es admin, redirige al listado de mensajes.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user() && method_exists($request->user(), 'hasRole') && $request->user()->hasRole('Admin')) {
            return redirect()->route('admin.mensajes.index');
        }

        return view('contact.create', [
            'tipos' => ContactMessage::getTiposConsulta(),
        ]);
    }

    /**
     * Envía el mensaje por email al administrador.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipo' => ['required', 'string', 'in:error,nuevo_patogeno,otro'],
            'mensaje' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'tipo.required' => 'Indique el motivo del contacto.',
            'tipo.in' => 'Seleccione un motivo válido.',
            'mensaje.required' => 'Escriba su mensaje.',
            'mensaje.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'mensaje.max' => 'El mensaje no puede superar 2000 caracteres.',
        ]);

        $user = $request->user();

        $mensaje = ContactMessage::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'tipo' => $validated['tipo'],
            'mensaje' => $validated['mensaje'],
        ]);

        $admin = User::whereHas('roles', fn ($q) => $q->where('nombre', 'Admin'))->first();
        $adminEmail = $admin?->email ?? config('mail.from.address');

        if (! empty($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new ContactMessageMail(
                    userName: $user->name,
                    userEmail: $user->email,
                    tipo: $validated['tipo'],
                    tipoLabel: ContactMessage::getTiposConsulta()[$validated['tipo']],
                    mensaje: $validated['mensaje'],
                ));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('contact.create')->with('success', 'Su mensaje se ha enviado correctamente. El administrador le responderá si es necesario.');
    }
}
