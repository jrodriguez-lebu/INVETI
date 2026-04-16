@extends('layouts.app')

@section('title', 'Equipos')
@section('page-title', 'Inventario de Equipos')

@section('content')

<!-- Quick Filter Tabs -->
<div class="flex flex-wrap gap-2 mb-4">
    <a href="{{ route('equipos.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
              {{ !request('incompletos') ? 'bg-municipal-700 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
        Todos los equipos
    </a>
    <a href="{{ route('equipos.index', ['incompletos' => 1]) }}"
       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors
              {{ request('incompletos') ? 'bg-orange-500 text-white' : 'bg-white border border-orange-200 text-orange-600 hover:bg-orange-50' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        &#9888;&#65039; Incompletos
        @if(isset($totalIncompletos) && $totalIncompletos > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold
                         {{ request('incompletos') ? 'bg-white text-orange-600' : 'bg-orange-500 text-white' }}">
                {{ $totalIncompletos > 99 ? '99+' : $totalIncompletos }}
            </span>
        @endif
    </a>
</div>

<!-- Filter Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-5">
    <form method="GET" action="{{ route('equipos.index') }}" class="flex flex-wrap gap-3 items-end">
        @if(request('incompletos'))
            <input type="hidden" name="incompletos" value="1">
        @endif
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Marca, modelo, serie, inventario..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 focus:border-transparent">
        </div>
        <div class="min-w-[150px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Tipo de Equipo</label>
            <select name="tipo_equipo_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos los tipos</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ request('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[140px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Estado</label>
            <select name="estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                <option value="activo"   {{ request('estado') === 'activo'   ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                <option value="baja"     {{ request('estado') === 'baja'     ? 'selected' : '' }}>Dado de Baja</option>
            </select>
        </div>
        <div class="min-w-[160px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Departamento</label>
            <select name="departamento_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                <option value="">Todos</option>
                @foreach($departamentos as $dep)
                    <option value="{{ $dep->id }}" {{ request('departamento_id') == $dep->id ? 'selected' : '' }}>
                        {{ $dep->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2 items-end">
            <button type="submit" class="px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
                Filtrar
            </button>
            @if(request()->hasAny(['search', 'tipo_equipo_id', 'estado', 'departamento_id', 'incompletos']))
                <a href="{{ route('equipos.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Limpiar
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Equipos</h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Mostrando {{ $equipos->firstItem() }}–{{ $equipos->lastItem() }} de {{ $equipos->total() }} equipos
                </p>
            </div>
            <form method="GET" action="{{ route('equipos.index') }}">
                @foreach(request()->except(['per_page', 'page']) as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <select name="per_page" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-2 py-1.5 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-municipal-500 bg-white">
                    @foreach([10, 15, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ (int) request('per_page', 15) === $n ? 'selected' : '' }}>
                            {{ $n }} / pág
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <a href="{{ route('equipos.create') }}"
           class="flex items-center px-4 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Equipo
        </a>
    </div>

    @php
        $currentSort = request('sort', 'created_at');
        $currentDir  = request('direction', 'desc');

        // Genera URL para ordenar por una columna dada
        $sortUrl = function(string $col) use ($currentSort, $currentDir): string {
            $newDir = ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort' => $col, 'direction' => $newDir, 'page' => null]);
        };

        // Icono de flecha según estado activo/inactivo de la columna
        $sortIcon = function(string $col) use ($currentSort, $currentDir): string {
            if ($currentSort !== $col) {
                return '<svg class="w-3.5 h-3.5 text-gray-300 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>';
            }
            if ($currentDir === 'asc') {
                return '<svg class="w-3.5 h-3.5 text-municipal-600 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                        </svg>';
            }
            return '<svg class="w-3.5 h-3.5 text-municipal-600 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>';
        };
    @endphp

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left border-b border-gray-200">
                    @foreach([
                        ['col' => 'numero_inventario', 'label' => 'N° Inventario'],
                        ['col' => 'tipo',              'label' => 'Tipo'],
                        ['col' => 'marca',             'label' => 'Marca / Modelo'],
                        ['col' => 'numero_serie',      'label' => 'N° Serie'],
                        ['col' => 'estado',            'label' => 'Estado'],
                        ['col' => 'responsable',       'label' => 'Responsable'],
                        ['col' => 'departamento',      'label' => 'Departamento'],
                    ] as $th)
                        <th class="px-4 py-3">
                            <a href="{{ $sortUrl($th['col']) }}"
                               class="inline-flex items-center text-xs font-semibold uppercase tracking-wider transition-colors
                                      {{ $currentSort === $th['col'] ? 'text-municipal-700' : 'text-gray-500 hover:text-gray-800' }}">
                                {{ $th['label'] }}{!! $sortIcon($th['col']) !!}
                            </a>
                        </th>
                    @endforeach
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($equipos as $equipo)
                    <tr class="hover:bg-gray-50 transition-colors {{ $equipo->datos_incompletos ? 'border-l-4 border-l-orange-400' : '' }}">
                        <td class="px-4 py-3">
                            <a href="{{ route('equipos.show', $equipo) }}"
                               class="font-mono text-xs font-semibold text-municipal-700 hover:text-municipal-900">
                                {{ $equipo->numero_inventario }}
                            </a>
                            @if($equipo->datos_incompletos)
                                <span class="ml-1 inline-flex items-center" title="Datos incompletos">
                                    <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <span class="text-base">{{ $equipo->tipoEquipo->icono_html ?? '' }}</span>
                                <span class="text-xs text-gray-600">{{ $equipo->tipoEquipo->nombre ?? '-' }}</span>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $equipo->marca }}</div>
                            <div class="text-xs text-gray-500">{{ $equipo->modelo }}</div>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $equipo->numero_serie ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $equipo->estado_badge }}">
                                {{ $equipo->estado_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($equipo->funcionario)
                                <a href="{{ route('funcionarios.show', $equipo->funcionario) }}"
                                   class="text-municipal-700 hover:text-municipal-900">
                                    {{ $equipo->funcionario->nombre_completo }}
                                </a>
                            @else
                                <span class="text-gray-400">Sin asignar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $equipo->departamento->nombre ?? '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('equipos.show', $equipo) }}"
                                   class="p-1.5 text-gray-500 hover:text-municipal-700 hover:bg-municipal-50 rounded-lg transition-colors"
                                   title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('equipos.edit', $equipo) }}"
                                   class="p-1.5 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('equipos.destroy', $equipo) }}"
                                      x-data
                                      @submit.prevent="if(confirm('¿Eliminar este equipo?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
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
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-medium">No se encontraron equipos</p>
                            <p class="text-xs mt-1">Intente con otros filtros o registre un nuevo equipo.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($equipos->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $equipos->links() }}
        </div>
    @endif
</div>

@endsection
