@extends('layouts.app')

@section('title', $funcionario->nombre_completo)
@section('page-title', 'Perfil del Funcionario')

@section('content')

<div class="max-w-5xl space-y-5">

    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-municipal-700 rounded-full flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($funcionario->nombre, 0, 1)) }}{{ strtoupper(substr($funcionario->apellido, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h1 class="text-xl font-bold text-gray-900">{{ $funcionario->nombre_completo }}</h1>
                        @if($funcionario->activo)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Activo</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Inactivo</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $funcionario->cargo }}</p>
                    <p class="text-sm text-gray-500">{{ $funcionario->departamento->nombre ?? 'Sin departamento' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('funcionarios.edit', $funcionario) }}"
                   class="flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('funcionarios.index') }}" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Personal Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Información Personal</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">RUT</dt>
                    <dd class="font-mono font-semibold text-gray-800">{{ $funcionario->rut }}</dd>
                </div>
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">Cargo</dt>
                    <dd class="font-medium text-gray-800">{{ $funcionario->cargo }}</dd>
                </div>
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">Departamento</dt>
                    <dd class="text-gray-800">{{ $funcionario->departamento->nombre ?? '-' }}</dd>
                </div>
                @if($funcionario->email)
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">Email</dt>
                    <dd><a href="mailto:{{ $funcionario->email }}" class="text-municipal-700 hover:underline">{{ $funcionario->email }}</a></dd>
                </div>
                @endif
                @if($funcionario->telefono)
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">Teléfono</dt>
                    <dd class="text-gray-800">{{ $funcionario->telefono }}</dd>
                </div>
                @endif
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 text-xs mb-0.5">Equipos asignados</dt>
                    <dd class="font-bold text-2xl text-municipal-700">{{ $funcionario->equipos->count() }}</dd>
                </div>
            </dl>
        </div>

        <!-- Assigned Equipos -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-800">Equipos Asignados</h2>
                <a href="{{ route('equipos.create') }}" class="text-sm text-municipal-700 hover:text-municipal-900 font-medium">+ Asignar equipo</a>
            </div>
            @if($funcionario->equipos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Inventario</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tipo</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Marca / Modelo</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Estado</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Ver</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($funcionario->equipos as $equipo)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono text-xs font-semibold text-municipal-700">{{ $equipo->numero_inventario }}</td>
                                    <td class="px-4 py-3">
                                        <span class="flex items-center space-x-1">
                                            <span>{{ $equipo->tipoEquipo->icono_html ?? '' }}</span>
                                            <span class="text-xs text-gray-600">{{ $equipo->tipoEquipo->nombre ?? '-' }}</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800 text-xs">{{ $equipo->marca }}</div>
                                        <div class="text-xs text-gray-400">{{ $equipo->modelo }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $equipo->estado_badge }}">
                                            {{ $equipo->estado_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('equipos.show', $equipo) }}" class="text-xs text-municipal-700 hover:underline">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-500 text-sm">Este funcionario no tiene equipos asignados.</div>
            @endif
        </div>

    </div>

    <!-- Actas History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-800">Historial de Actas de Entrega</h2>
        </div>
        @if($funcionario->actasEntrega->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">N° Acta</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Equipo</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($funcionario->actasEntrega->sortByDesc('fecha_entrega') as $acta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono text-xs font-semibold text-municipal-700">{{ $acta->numero_acta }}</td>
                                <td class="px-4 py-3 text-xs text-gray-700">
                                    {{ $acta->equipo->tipoEquipo->nombre ?? '-' }} — {{ $acta->equipo->marca }} {{ $acta->equipo->modelo }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500">{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($acta->firmada)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Firmada</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('actas.show', $acta) }}" class="text-xs text-municipal-700 hover:underline">Ver</a>
                                    <a href="{{ route('actas.pdf', $acta) }}" target="_blank" class="text-xs text-red-600 hover:underline">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-gray-500 text-sm">Sin historial de actas.</div>
        @endif
    </div>

</div>

@endsection
