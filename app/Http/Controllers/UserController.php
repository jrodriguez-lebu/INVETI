<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\InvitacionUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
        ]);

        // Crear usuario con contraseña aleatoria (se definirá al activar la cuenta)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make(Str::random(32)),
        ]);

        // Generar token de activación y enviar invitación
        $token = Password::createToken($user);
        $user->notify(new InvitacionUsuario($token, $user->name));

        return redirect()->route('users.index')
            ->with('success', "Usuario \"{$user->name}\" creado. Se ha enviado un correo de invitación a {$user->email} para que active su cuenta.");
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
        ]);

        $emailChanged = $user->email !== $request->email;

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            // Si cambia el email, invalidar verificación anterior
            'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
        ]);

        // Reenviar verificación si cambió el email
        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('users.index')
                ->with('success', "Email actualizado. Se envió un nuevo correo de verificación a {$user->email}.");
        }

        return redirect()->route('users.index')
            ->with('success', "Usuario \"{$user->name}\" actualizado correctamente.");
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('users.index')
            ->with('success', "Contraseña de \"{$user->name}\" actualizada correctamente.");
    }

    public function resendVerification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Este usuario ya tiene el email verificado.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', "Correo de verificación reenviado a {$user->email}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Usuario \"{$name}\" eliminado correctamente.");
    }
}
