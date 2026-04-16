<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

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
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Dispara el evento que envía el correo de verificación
        event(new Registered($user));

        return redirect()->route('users.index')
            ->with('success', "Usuario \"{$user->name}\" creado. Se ha enviado un correo de verificación a {$user->email}.");
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
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
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
