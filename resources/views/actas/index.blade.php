@extends('layouts.app')

@section('title', 'Actas de Entrega')
@section('page-title', 'Actas de Entrega')

@section('content')

<!-- Filter Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-5">
    <form method="GET" action="{{ route('actas.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="min-w-[160px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Funcionario</label>
            <select name="funcionario_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                @foreach($funcionarios as $func)
                    <option value="{{ $func->id }}" {{ request('funcionario_id') == $func->id ? 'selected' : '' }}>{{ $func->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[120px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Estado</label>
            <select name="firmada" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                <option value="1" {{ request('firmada') === '1' ? 'selected' : '' }}>Firmada</option>
                <option value="0" {{ request('firmada') === '0' ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>
        <div class="min-w-[130px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Desde</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
        </div>
        <div class="min-w-[130px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Hasta</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">Filtrar</button>
            @if(request()->hasAny(['funcionario_id', 'firmada', 'fecha_desde', 'fecha_hasta']))
                <a href="{{ route('actas.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Limpiar</a>
            @endif
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-800">Actas de Entrega</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $actas->total() }} actas encontradas</p>
        </div>
        <a href="{{ route('actas.create') }}"
           class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Acta
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">N° Acta</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Equipo</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">N° Inventario</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Funcionario</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Estado</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($actas as $acta)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('actas.show', $acta) }}"
                               class="font-mono text-xs font-semibold text-municipal-700 hover:text-municipal-900">
                                {{ $acta->numero_acta }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-800">{{ $acta->equipo->tipoEquipo->nombre ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $acta->equipo->marca }} {{ $acta->equipo->modelo }}</div>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $acta->equipo->numero_inventario ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-800">{{ $acta->funcionario->nombre_completo ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $acta->funcionario->departamento->nombre ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if($acta->firmada)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Firmada
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('actas.show', $acta) }}"
                                   class="p-1.5 text-gray-500 hover:text-municipal-700 hover:bg-municipal-50 rounded-lg transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('actas.pdf', $acta) }}" target="_blank"
                                   class="p-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Descargar PDF">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('actas.edit', $acta) }}"
                                   class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('actas.destroy', $acta) }}"
                                      x-data
                                      @submit.prevent="if(confirm('¿Eliminar esta acta?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
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
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500 text-sm">
                            No hay actas de entrega registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($actas->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $actas->links() }}
        </div>
    @endif
</div>

@endsection
