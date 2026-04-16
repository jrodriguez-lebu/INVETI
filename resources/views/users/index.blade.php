@extends('layouts.app')
@section('title', 'Usuarios del Sistema')
@section('page-title', 'Usuarios del Sistema')

@section('content')
<div class="max-w-4xl space-y-5">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Administradores</h2>
                <p class="text-xs text-gray-500 mt-0.5">{{ $users->count() }} usuario(s) registrado(s)</p>
            </div>
            <a href="{{ route('users.create') }}"
               class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Nuevo Usuario
            </a>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($users as $user)
            <div class="px-5 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    {{-- Avatar --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                {{ $user->hasVerifiedEmail() ? 'bg-municipal-100' : 'bg-gray-100' }}">
                        <span class="text-sm font-bold {{ $user->hasVerifiedEmail() ? 'text-municipal-700' : 'text-gray-500' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-800">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                                <span class="text-xs bg-municipal-100 text-municipal-700 px-2 py-0.5 rounded-full font-medium">Tú</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs text-gray-500">{{ $user->email }}</span>
                            @if($user->hasVerifiedEmail())
                                <span class="inline-flex items-center gap-1 text-xs text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Verificado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pendiente de verificación
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Creado {{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex items-center gap-1 flex-shrink-0">
                    {{-- Reenviar verificación --}}
                    @if(!$user->hasVerifiedEmail())
                        <form method="POST" action="{{ route('users.resend-verification', $user) }}">
                            @csrf
                            <button type="submit" title="Reenviar verificación"
                                    class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors text-xs flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="hidden sm:inline">Reenviar</span>
                            </button>
                        </form>
                    @endif

                    {{-- Editar --}}
                    <a href="{{ route('users.edit', $user) }}" title="Editar"
                       class="p-2 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>

                    {{-- Eliminar --}}
                    @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}"
                              x-data @submit.prevent="if(confirm('¿Eliminar al usuario {{ addslashes($user->name) }}?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" title="Eliminar"
                                    class="p-2 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
                <div class="px-5 py-10 text-center text-gray-400 text-sm">No hay usuarios registrados.</div>
            @endforelse
        </div>
    </div>

    {{-- Nota informativa sobre verificación --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-semibold mb-1">Verificación de correo electrónico</p>
            <p class="text-xs text-blue-700">Al crear un usuario se envía automáticamente un correo de verificación.
            El usuario debe hacer clic en el enlace del correo antes de poder acceder al sistema.
            Si no llega, usa el botón <strong>Reenviar</strong>.</p>
        </div>
    </div>

</div>
@endsection
