@extends('layouts.app')

@section('title', 'Direcciones')
@section('page-title', 'Direcciones')

@section('content')

<div class="space-y-4">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Direcciones</h2>
                <p class="text-xs text-gray-500 mt-0.5">{{ $direcciones->count() }} direcciones registradas</p>
            </div>
            <a href="{{ route('direcciones.create') }}"
               class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Dirección
            </a>
        </div>

        {{-- Lista de direcciones con sus departamentos --}}
        <div class="divide-y divide-gray-100">
            @forelse($direcciones as $dir)
                <div class="px-5 py-4" x-data="{ open: false }">
                    <div class="flex items-center justify-between">
                        {{-- Nombre y descripción --}}
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-municipal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-municipal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm">{{ $dir->nombre }}</p>
                                @if($dir->descripcion)
                                    <p class="text-xs text-gray-500 truncate">{{ $dir->descripcion }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Badge departamentos + acciones --}}
                        <div class="flex items-center space-x-3 ml-4">
                            {{-- Toggle departamentos --}}
                            @if($dir->departamentos_count > 0)
                                <button @click="open = !open"
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-municipal-100 text-municipal-800 hover:bg-municipal-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span>{{ $dir->departamentos_count }} {{ $dir->departamentos_count === 1 ? 'departamento' : 'departamentos' }}</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                    Sin departamentos
                                </span>
                            @endif

                            {{-- Editar --}}
                            <a href="{{ route('direcciones.edit', $dir) }}"
                               class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Eliminar --}}
                            <form method="POST" action="{{ route('direcciones.destroy', $dir) }}"
                                  x-data
                                  @submit.prevent="if(confirm('¿Eliminar la dirección «{{ $dir->nombre }}»?')) $el.submit()">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Departamentos expandibles --}}
                    @if($dir->departamentos_count > 0)
                        <div x-show="open" x-cloak class="mt-3 ml-13 pl-13 border-l-2 border-municipal-200 ml-[52px] pl-4 space-y-2">
                            @foreach($dir->departamentos as $dep)
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-municipal-400"></div>
                                        <span class="text-sm text-gray-700 font-medium">{{ $dep->nombre }}</span>
                                        @if($dep->descripcion)
                                            <span class="text-xs text-gray-400">— {{ $dep->descripcion }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('departamentos.edit', $dep) }}"
                                       class="text-xs text-municipal-600 hover:text-municipal-800 font-medium">
                                        Editar
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="px-4 py-12 text-center text-gray-500 text-sm">
                    No hay direcciones registradas. Crea la primera para organizar los departamentos.
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
