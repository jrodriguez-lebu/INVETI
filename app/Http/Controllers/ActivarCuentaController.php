<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ActivarCuentaController extends Controller
{
    /**
     * Muestra el formulario para crear contraseña.
     */
    public function show(string $token, Request $request)
    {
        return view('auth.activar-cuenta', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Activa la cuenta: valida token, guarda contraseña y verifica email.
     */
    public function activate(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'           => Hash::make($password),
                    'email_verified_at'  => now(),
                ])->save();

                event(new Verified($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', '¡Cuenta activada correctamente! Ya puedes iniciar sesión.');
        }

        return back()->withErrors(['email' => match($status) {
            Password::INVALID_TOKEN => 'El enlace de activación ha expirado o es inválido. Solicita uno nuevo al administrador.',
            Password::INVALID_USER  => 'No se encontró un usuario con ese correo.',
            default                 => 'No se pudo activar la cuenta. Intenta nuevamente.',
        }]);
    }
}
