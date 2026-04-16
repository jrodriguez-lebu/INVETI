@extends('layouts.app')

@section('title', 'Departamentos')
@section('page-title', 'Departamentos')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-800">Departamentos</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $departamentos->count() }} departamentos registrados</p>
        </div>
        <a href="{{ route('departamentos.create') }}"
           class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Departamento
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Funcionarios</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Equipos</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($departamentos as $dep)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-municipal-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-municipal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-800">{{ $dep->nombre }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-sm">{{ $dep->descripcion ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('funcionarios.index', ['departamento_id' => $dep->id]) }}"
                               class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">
                                {{ $dep->funcionarios_count }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('equipos.index', ['departamento_id' => $dep->id]) }}"
                               class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-municipal-100 text-municipal-800 hover:bg-municipal-200">
                                {{ $dep->equipos_count }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('departamentos.edit', $dep) }}"
                                   class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('departamentos.destroy', $dep) }}"
                                      x-data
                                      @submit.prevent="if(confirm('¿Eliminar este departamento?')) $el.submit()">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-500 text-sm">No hay departamentos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
