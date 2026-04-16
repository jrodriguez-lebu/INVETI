@extends('layouts.app')

@section('title', $equipo->numero_inventario)
@section('page-title', 'Detalle del Equipo')

@section('content')

<div class="max-w-5xl space-y-5">

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-municipal-100 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                    {{ $equipo->tipoEquipo->icono_html ?? '💾' }}
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h1 class="text-xl font-bold text-gray-900">{{ $equipo->marca }} {{ $equipo->modelo }}</h1>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $equipo->estado_badge }}">
                            {{ $equipo->estado_label }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">{{ $equipo->tipoEquipo->nombre ?? '-' }}</p>
                    <p class="font-mono text-sm font-semibold text-municipal-700 mt-1">{{ $equipo->numero_inventario }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('actas.create', ['equipo_id' => $equipo->id]) }}"
                   class="flex items-center px-3 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Nueva Acta
                </a>
                <a href="{{ route('equipos.edit', $equipo) }}"
                   class="flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('equipos.index') }}" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Equipment Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Información del Equipo</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Tipo</dt>
                    <dd class="font-medium text-gray-800">{{ $equipo->tipoEquipo->nombre ?? '-' }}</dd>
                </div>
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Marca</dt>
                    <dd class="font-medium text-gray-800">{{ $equipo->marca }}</dd>
                </div>
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Modelo</dt>
                    <dd class="font-medium text-gray-800">{{ $equipo->modelo }}</dd>
                </div>
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">N° de Serie</dt>
                    <dd class="font-mono text-gray-700">{{ $equipo->numero_serie ?? 'No registrado' }}</dd>
                </div>
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">N° Inventario</dt>
                    <dd class="font-mono font-semibold text-municipal-700">{{ $equipo->numero_inventario }}</dd>
                </div>
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Estado</dt>
                    <dd>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $equipo->estado_badge }}">
                            {{ $equipo->estado_label }}
                        </span>
                    </dd>
                </div>
                @if($equipo->fecha_adquisicion)
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Fecha Adquisición</dt>
                    <dd class="font-medium text-gray-800">{{ $equipo->fecha_adquisicion->format('d/m/Y') }}</dd>
                </div>
                @endif
                @if($equipo->valor_adquisicion)
                <div class="px-5 py-3 flex justify-between text-sm">
                    <dt class="text-gray-500">Valor Adquisición</dt>
                    <dd class="font-medium text-gray-800">$ {{ number_format($equipo->valor_adquisicion, 0, ',', '.') }}</dd>
                </div>
                @endif
                @if($equipo->descripcion)
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 mb-1">Descripción</dt>
                    <dd class="text-gray-800">{{ $equipo->descripcion }}</dd>
                </div>
                @endif
                @if($equipo->observaciones)
                <div class="px-5 py-3 text-sm">
                    <dt class="text-gray-500 mb-1">Observaciones</dt>
                    <dd class="text-gray-800">{{ $equipo->observaciones }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Responsible Person -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Asignación Actual</h2>
            </div>
            @if($equipo->funcionario)
                <div class="p-5">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-municipal-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-lg font-bold text-municipal-700">
                                {{ strtoupper(substr($equipo->funcionario->nombre, 0, 1)) }}{{ strtoupper(substr($equipo->funcionario->apellido, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $equipo->funcionario->nombre_completo }}</p>
                            <p class="text-sm text-gray-500">{{ $equipo->funcionario->cargo }}</p>
                        </div>
                    </div>
                    <dl class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-500">RUT</dt>
                            <dd class="font-mono text-gray-700">{{ $equipo->funcionario->rut }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-500">Departamento</dt>
                            <dd class="text-gray-700">{{ $equipo->funcionario->departamento->nombre ?? '-' }}</dd>
                        </div>
                        @if($equipo->funcionario->email)
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="text-gray-700">{{ $equipo->funcionario->email }}</dd>
                        </div>
                        @endif
                        @if($equipo->funcionario->telefono)
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-500">Teléfono</dt>
                            <dd class="text-gray-700">{{ $equipo->funcionario->telefono }}</dd>
                        </div>
                        @endif
                    </dl>
                    <a href="{{ route('funcionarios.show', $equipo->funcionario) }}"
                       class="mt-4 flex items-center text-sm text-municipal-700 hover:text-municipal-900 font-medium">
                        Ver perfil completo
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="p-5 text-center">
                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-sm text-gray-500 mb-2">Este equipo no está asignado a ningún funcionario.</p>
                    @if($equipo->departamento)
                        <p class="text-xs text-gray-400">Departamento: {{ $equipo->departamento->nombre }}</p>
                    @endif
                    <a href="{{ route('equipos.edit', $equipo) }}"
                       class="mt-3 inline-flex items-center text-sm text-municipal-700 hover:text-municipal-900 font-medium">
                        Asignar responsable
                    </a>
                </div>
            @endif
        </div>

    </div>

    <!-- Datos de Adquisición y Proveedor -->
    @if($equipo->numero_opi || $equipo->numero_factura || $equipo->rut_proveedor || $equipo->nombre_proveedor)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center space-x-2">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h2 class="text-sm font-semibold text-gray-800">Datos de Adquisición y Proveedor</h2>
        </div>
        <dl class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-gray-100">
            <div class="px-5 py-4">
                <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">N° OPI</dt>
                <dd class="font-mono text-sm font-semibold text-gray-800">{{ $equipo->numero_opi ?? '—' }}</dd>
            </div>
            <div class="px-5 py-4">
                <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">N° Factura</dt>
                <dd class="font-mono text-sm font-semibold text-gray-800">{{ $equipo->numero_factura ?? '—' }}</dd>
            </div>
            <div class="px-5 py-4">
                <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">RUT Proveedor</dt>
                <dd class="font-mono text-sm text-gray-700">{{ $equipo->rut_proveedor ?? '—' }}</dd>
            </div>
            <div class="px-5 py-4">
                <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Nombre Proveedor</dt>
                <dd class="text-sm text-gray-700">{{ $equipo->nombre_proveedor ?? '—' }}</dd>
            </div>
        </dl>
    </div>
    @endif

    <!-- Actas de Entrega History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Historial de Actas de Entrega</h2>
            <a href="{{ route('actas.create', ['equipo_id' => $equipo->id]) }}"
               class="text-sm text-municipal-700 hover:text-municipal-900 font-medium">+ Nueva acta</a>
        </div>
        @if($equipo->actasEntrega->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">N° Acta</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Funcionario</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Fecha Entrega</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($equipo->actasEntrega->sortByDesc('fecha_entrega') as $acta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono text-xs font-semibold text-municipal-700">{{ $acta->numero_acta }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $acta->funcionario->nombre_completo ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
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
            <div class="p-8 text-center text-gray-500 text-sm">No hay actas de entrega para este equipo.</div>
        @endif
    </div>

</div>

@endsection
