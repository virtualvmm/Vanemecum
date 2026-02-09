<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                $message = 'Si existe una cuenta con ese correo, te hemos enviado un enlace para restablecer la contraseña.';
                if (config('mail.default') === 'log') {
                    $message .= ' En modo desarrollo revisa storage/logs/laravel.log para ver el enlace.';
                }
                return back()->with('status', $message);
            }

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No hemos encontrado ningún usuario con ese correo electrónico.']);
        } catch (\Throwable $e) {
            Log::error('Error al enviar enlace de reseteo de contraseña: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No se pudo enviar el correo. Comprueba la configuración de correo (MAIL_*) en .env. Para desarrollo usa MAIL_MAILER=log.']);
        }
    }
}
