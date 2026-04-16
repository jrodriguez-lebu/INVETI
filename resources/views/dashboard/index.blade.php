@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

@if($incompletos > 0)
<!-- Incomplete Records Alert Banner -->
<div class="mb-5 bg-orange-50 border border-orange-300 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
    <div class="flex items-center gap-3">
        <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-orange-800">
                &#9888;&#65039; Hay <span class="text-orange-900 font-bold">{{ $incompletos }}</span> equipos con datos incompletos que requieren actualización
            </p>
            <p class="text-xs text-orange-600 mt-0.5">Campos faltantes: Encargado, Tipo de equipo, Marca o Dirección.</p>
        </div>
    </div>
    <a href="{{ route('equipos.index', ['incompletos' => 1]) }}"
       class="flex-shrink-0 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
        Ver registros incompletos
    </a>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Equipos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Equipos</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalEquipos }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <span>{{ $totalFuncionarios }} funcionarios activos</span>
        </div>
    </div>

    <!-- Activos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Activos</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $activos }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3">
            <div class="w-full bg-gray-200 rounded-full h-1.5">
                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $totalEquipos > 0 ? round($activos/$totalEquipos*100) : 0 }}%"></div>
            </div>
            <span class="text-xs text-gray-500 mt-1 block">{{ $totalEquipos > 0 ? round($activos/$totalEquipos*100) : 0 }}% del total</span>
        </div>
    </div>

    <!-- Dados de Baja -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Dados de Baja</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $dadosDeBaja }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <span>+ {{ $inactivos }} inactivos</span>
        </div>
    </div>

    <!-- Datos Incompletos -->
    <a href="{{ route('equipos.index', ['incompletos' => 1]) }}"
       class="bg-white rounded-xl shadow-sm border border-orange-200 p-5 hover:border-orange-400 transition-colors block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-orange-600 font-medium">Datos Incompletos</p>
                <p class="text-3xl font-bold text-orange-500 mt-1">{{ $incompletos }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-xs text-orange-500">
            <span>Requieren completar datos</span>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Equipos por Tipo -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Equipos por Tipo</h2>
        </div>
        <div class="p-4 space-y-3">
            @forelse($equiposPorTipo as $tipo)
                <div class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl">{{ $tipo->icono_html }}</span>
                        <div>
                            <a href="{{ route('equipos.index', ['tipo_equipo_id' => $tipo->id]) }}"
                               class="text-sm font-medium text-gray-700 hover:text-municipal-700">{{ $tipo->nombre }}</a>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-municipal-100 text-municipal-800">
                        {{ $tipo->equipos_count }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">No hay equipos registrados.</p>
            @endforelse
        </div>
    </div>

    <!-- Acciones Rápidas + Actas Recientes -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Acciones Rápidas</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('equipos.create') }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-municipal-50 hover:bg-municipal-100 text-municipal-800 transition-colors text-center">
                    <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="text-xs font-medium">Nuevo Equipo</span>
                </a>
                <a href="{{ route('funcionarios.create') }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-green-50 hover:bg-green-100 text-green-800 transition-colors text-center">
                    <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span class="text-xs font-medium">Nuevo Funcionario</span>
                </a>
                <a href="{{ route('actas.create') }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 transition-colors text-center">
                    <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-xs font-medium">Nueva Acta</span>
                </a>
                <a href="{{ route('equipos.index', ['estado' => 'reparacion']) }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-yellow-50 hover:bg-yellow-100 text-yellow-800 transition-colors text-center">
                    <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                    </svg>
                    <span class="text-xs font-medium">En Reparación</span>
                </a>
            </div>
        </div>

        <!-- Recent Actas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-800">Actas Recientes</h2>
                <a href="{{ route('actas.index') }}" class="text-sm text-municipal-600 hover:text-municipal-800 font-medium">Ver todas</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">N° Acta</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Equipo</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Funcionario</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentActas as $acta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <a href="{{ route('actas.show', $acta) }}" class="font-mono text-xs font-semibold text-municipal-700 hover:text-municipal-900">
                                        {{ $acta->numero_acta }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-800">{{ $acta->equipo->tipoEquipo->nombre ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $acta->equipo->marca }} {{ $acta->equipo->modelo }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $acta->funcionario->nombre_completo ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500">{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($acta->firmada)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Firmada</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">No hay actas de entrega registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($equiposIncompletos->isNotEmpty())
<!-- Equipos con Datos Incompletos -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-orange-200">
    <div class="px-5 py-4 border-b border-orange-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h2 class="text-base font-semibold text-gray-800">Equipos con Datos Incompletos</h2>
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                {{ $incompletos }} total
            </span>
        </div>
        <a href="{{ route('equipos.index', ['incompletos' => 1]) }}"
           class="text-sm text-orange-600 hover:text-orange-800 font-medium">
            Ver todos
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-orange-50 text-left">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">N° Inventario</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Marca / Modelo</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Responsable</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Campos Faltantes</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($equiposIncompletos as $equipo)
                    <tr class="hover:bg-orange-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('equipos.show', $equipo) }}"
                               class="font-mono text-xs font-semibold text-municipal-700 hover:text-municipal-900">
                                {{ $equipo->numero_inventario }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs text-gray-600">{{ $equipo->tipoEquipo->nombre ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $equipo->marca }}</div>
                            <div class="text-xs text-gray-500">{{ $equipo->modelo }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($equipo->funcionario)
                                {{ $equipo->funcionario->nombre_completo }}
                            @else
                                <span class="text-gray-400 italic">Sin asignar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @if($equipo->campos_faltantes)
                                    @foreach($equipo->campos_faltantes as $campo)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                            {{ $campo }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('equipos.edit', $equipo) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-orange-100 text-orange-700 hover:bg-orange-200 rounded-lg text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
