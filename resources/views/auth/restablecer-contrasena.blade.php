<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña — INVETI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        municipal: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-municipal-900 via-municipal-800 to-municipal-700 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo y nombre --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-4">
                <svg class="w-11 h-11 text-municipal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">INVETI</h1>
            <p class="text-municipal-300 text-sm mt-1">Sistema de Inventario Informático</p>
            <p class="text-municipal-400 text-xs mt-0.5">Ilustre Municipalidad de Lebu</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="bg-municipal-800 px-6 py-4">
                <h2 class="text-white font-semibold text-base">Crear nueva contraseña</h2>
                <p class="text-municipal-300 text-xs mt-0.5">Elige una contraseña segura para tu cuenta</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Error global --}}
                @if ($errors->any())
                    <div class="flex items-start space-x-3 p-3.5 bg-red-50 border border-red-200 rounded-xl">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ $errors->first() }}</p>
                    </div>
                @endif

                {{-- Email (oculto visualmente pero requerido por el broker) --}}
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $email ?? '') }}"
                               required readonly autocomplete="email"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                </div>

                {{-- Nueva contraseña --}}
                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Nueva contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres con letras y números"
                               class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 focus:border-transparent transition
                                      {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                    </div>
                    <p class="text-xs text-gray-400">Mínimo 8 caracteres, debe incluir letras y números.</p>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmar contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               required autocomplete="new-password"
                               placeholder="Repite la contraseña"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 focus:border-transparent transition bg-white">
                    </div>
                </div>

                {{-- Botón --}}
                <button type="submit"
                        class="w-full bg-municipal-700 hover:bg-municipal-800 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors duration-200 flex items-center justify-center space-x-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Guardar nueva contraseña</span>
                </button>

            </form>
        </div>

        <p class="text-center text-municipal-400 text-xs mt-6">
            INVETI v1.0 &mdash; Municipalidad de Lebu &copy; {{ date('Y') }}
        </p>
    </div>

</body>
</html>
