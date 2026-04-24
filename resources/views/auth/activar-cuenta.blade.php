<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar Cuenta — INVETI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-4">
                <svg class="w-11 h-11 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">INVETI</h1>
            <p class="text-blue-300 text-sm mt-1">Activa tu cuenta</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="bg-blue-800 px-6 py-4">
                <h2 class="text-white font-semibold text-base">Crear contraseña</h2>
                <p class="text-blue-300 text-xs mt-0.5">Define tu contraseña para acceder al sistema</p>
            </div>

            {{-- Errores --}}
            @if($errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="mx-6 mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('activar-cuenta.activate') }}" class="p-6 space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Email (solo lectura) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Correo electrónico</label>
                    <input type="email" value="{{ $email }}" readonly
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nueva contraseña <span class="text-red-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="Mínimo 8 caracteres con letras y números"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Confirmar --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Confirmar contraseña <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           placeholder="Repite tu contraseña"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-700">
                    La contraseña debe tener al menos 8 caracteres e incluir letras y números.
                </div>

                <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Activar mi cuenta</span>
                </button>
            </form>

        </div>

        <p class="text-center text-blue-400 text-xs mt-6">
            INVETI v1.0 &mdash; Municipalidad de Lebu
        </p>
    </div>

</body>
</html>
