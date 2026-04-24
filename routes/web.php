<?php

use App\Http\Controllers\ActivarCuentaController;
use App\Http\Controllers\ActaEntregaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\TipoEquipoController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Autenticación (rutas públicas) ───────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Activación de cuenta (invitación por email) ───────────────────────────────
Route::get('/activar-cuenta/{token}',  [ActivarCuentaController::class, 'show'])->name('activar-cuenta.show');
Route::post('/activar-cuenta',         [ActivarCuentaController::class, 'activate'])->name('activar-cuenta.activate');

// ── Verificación de email ────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', '¡Email verificado correctamente! Bienvenido al sistema.');
    })->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Correo de verificación reenviado.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ── Rutas protegidas (requieren sesión activa) ───────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('equipos', EquipoController::class);
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('departamentos', DepartamentoController::class)->except(['show']);
    Route::resource('tipos-equipo', TipoEquipoController::class)->except(['show']);
    Route::resource('actas', ActaEntregaController::class);
    Route::get('/actas/{acta}/pdf', [ActaEntregaController::class, 'pdf'])->name('actas.pdf');

    // Usuarios del sistema
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('/users/{user}/resend-verification', [UserController::class, 'resendVerification'])->name('users.resend-verification');
    Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // API helpers internos
    Route::get('/api/next-inventario', [EquipoController::class, 'nextInventario'])->name('api.next-inventario');
    Route::post('/api/funcionarios/quick-store', [FuncionarioController::class, 'quickStore'])->name('api.funcionarios.quick-store');

});
