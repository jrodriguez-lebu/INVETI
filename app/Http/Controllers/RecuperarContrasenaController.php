<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\RecuperarContrasena;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class RecuperarContrasenaController extends Controller
{
    // ── Paso 1: Formulario para ingresar el email ─────────────────────────────

    public function showLinkForm()
    {
        return view('auth.recuperar-contrasena');
    }

    public function sendLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'Ingresa un correo electrónico válido.',
        ]);

        // Buscar el usuario y enviar la notificación personalizada
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Password::createToken($user);
            $user->notify(new RecuperarContrasena($token));
        }

        // Siempre mostrar el mismo mensaje para no revelar si el email existe
        return back()->with('status', 'Si el correo está registrado, recibirás un enlace para restablecer tu contraseña en los próximos minutos.');
    }

    // ── Paso 2: Formulario para ingresar la nueva contraseña ─────────────────

    public function showResetForm(string $token, Request $request)
    {
        return view('auth.restablecer-contrasena', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ], [
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Ingresa un correo electrónico válido.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', '¡Contraseña restablecida correctamente! Ya puedes iniciar sesión.');
        }

        return back()->withErrors(['email' => match ($status) {
            Password::INVALID_TOKEN => 'El enlace ha expirado o es inválido. Solicita uno nuevo.',
            Password::INVALID_USER  => 'No existe una cuenta con ese correo electrónico.',
            default                 => 'No se pudo restablecer la contraseña. Intenta nuevamente.',
        }]);
    }
}
