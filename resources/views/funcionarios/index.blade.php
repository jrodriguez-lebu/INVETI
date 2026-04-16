@extends('layouts.app')

@section('title', 'Funcionarios')
@section('page-title', 'Funcionarios')

@section('content')

<!-- Filter Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-5">
    <form method="GET" action="{{ route('funcionarios.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Nombre, apellido, RUT, cargo..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
        </div>
        <div class="min-w-[160px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Departamento</label>
            <select name="departamento_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                @foreach($departamentos as $dep)
                    <option value="{{ $dep->id }}" {{ request('departamento_id') == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[120px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Estado</label>
            <select name="activo" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">Filtrar</button>
            @if(request()->hasAny(['search', 'departamento_id', 'activo']))
                <a href="{{ route('funcionarios.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Limpiar</a>
            @endif
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-800">Funcionarios</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $funcionarios->total() }} funcionarios encontrados</p>
        </div>
        <a href="{{ route('funcionarios.create') }}"
           class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Funcionario
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cargo</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Departamento</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Equipos</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($funcionarios as $func)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $func->rut }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-municipal-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-municipal-700">
                                        {{ strtoupper(substr($func->nombre, 0, 1)) }}{{ strtoupper(substr($func->apellido, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('funcionarios.show', $func) }}"
                                       class="font-medium text-gray-900 hover:text-municipal-700">
                                        {{ $func->nombre_completo }}
                                    </a>
                                    @if($func->email)
                                        <p class="text-xs text-gray-400">{{ $func->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $func->cargo }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $func->departamento->nombre ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-municipal-100 text-municipal-800">
                                {{ $func->equipos_count }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($func->activo)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('funcionarios.show', $func) }}"
                                   class="p-1.5 text-gray-500 hover:text-municipal-700 hover:bg-municipal-50 rounded-lg transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('funcionarios.edit', $func) }}"
                                   class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('funcionarios.destroy', $func) }}"
                                      x-data
                                      @submit.prevent="if(confirm('¿Eliminar este funcionario?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
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
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                            <p class="text-sm font-medium">No se encontraron funcionarios</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($funcionarios->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $funcionarios->links() }}
        </div>
    @endif
</div>

@endsection
