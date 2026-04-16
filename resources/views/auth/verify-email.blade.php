<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo — INVETI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-municipal-900 via-municipal-800 to-municipal-700 min-h-screen flex items-center justify-center p-4"
      style="--tw-gradient-from: #1e3a8a; --tw-gradient-via: #1e40af; --tw-gradient-to: #1d4ed8;">
<style>
    body { background: linear-gradient(135deg, #1e3a8a, #1e40af, #1d4ed8); }
</style>

<div class="w-full max-w-md text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6">
        <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Verifica tu correo electrónico</h1>
        <p class="text-sm text-gray-600 mb-6">
            Hemos enviado un enlace de verificación a <strong>{{ auth()->user()->email }}</strong>.
            Revisa tu bandeja de entrada y haz clic en el enlace para activar tu cuenta.
        </p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button type="submit"
                    class="w-full bg-municipal-700 hover:bg-municipal-800 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors flex items-center justify-center gap-2"
                    style="background:#1e40af;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reenviar correo de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
</body>
</html>
