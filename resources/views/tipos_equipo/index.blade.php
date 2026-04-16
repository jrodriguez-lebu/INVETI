@extends('layouts.app')

@section('title', 'Tipos de Equipo')
@section('page-title', 'Tipos de Equipo')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-800">Tipos de Equipo</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $tipos->count() }} tipos registrados</p>
        </div>
        <a href="{{ route('tipos-equipo.create') }}"
           class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Tipo
        </a>
    </div>

    <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
        @forelse($tipos as $tipo)
            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-sm transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-municipal-100 rounded-lg flex items-center justify-center text-xl">
                        {{ $tipo->icono_html }}
                    </div>
                    <div class="flex items-center space-x-1">
                        <a href="{{ route('tipos-equipo.edit', $tipo) }}"
                           class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('tipos-equipo.destroy', $tipo) }}"
                              x-data
                              @submit.prevent="if(confirm('¿Eliminar este tipo?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 class="font-semibold text-gray-800">{{ $tipo->nombre }}</h3>
                @if($tipo->descripcion)
                    <p class="text-xs text-gray-500 mt-1">{{ $tipo->descripcion }}</p>
                @endif
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('equipos.index', ['tipo_equipo_id' => $tipo->id]) }}"
                       class="text-xs text-municipal-700 hover:text-municipal-900 font-medium">
                        {{ $tipo->equipos_count }} equipo{{ $tipo->equipos_count !== 1 ? 's' : '' }} &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 text-sm">No hay tipos de equipo registrados.</div>
        @endforelse
    </div>
</div>

@endsection
