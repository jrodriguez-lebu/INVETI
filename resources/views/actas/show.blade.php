@extends('layouts.app')

@section('title', $acta->numero_acta)
@section('page-title', 'Acta de Entrega — ' . $acta->numero_acta)

@section('content')

<div class="max-w-3xl space-y-5">

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <a href="{{ route('actas.pdf', $acta) }}" target="_blank"
               class="flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Descargar PDF
            </a>
            <a href="{{ route('actas.edit', $acta) }}"
               class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
        </div>
        <a href="{{ route('actas.index') }}" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
            Volver
        </a>
    </div>

    <!-- Acta Preview Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-municipal-900 text-white p-6 text-center">
            <div class="text-xs text-municipal-300 uppercase tracking-widest mb-1">REPÚBLICA DE CHILE</div>
            <h1 class="text-xl font-bold">ILUSTRE MUNICIPALIDAD DE LEBU</h1>
            <div class="mt-3 text-municipal-300 text-sm">Unidad de Informática</div>
            <div class="mt-4 inline-block bg-white text-municipal-900 px-5 py-2 rounded-full">
                <div class="text-xs font-semibold uppercase tracking-wider">Acta de Entrega de Equipo Informático</div>
                <div class="text-lg font-bold text-center">{{ $acta->numero_acta }}</div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">

            <!-- Status & Date -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <div>
                    <span class="text-xs text-gray-500 uppercase font-medium">Fecha de Entrega</span>
                    <p class="text-lg font-semibold text-gray-800 mt-0.5">{{ $acta->fecha_entrega->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                </div>
                <div>
                    @if($acta->firmada)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Firmada
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            Pendiente de Firma
                        </span>
                    @endif
                </div>
            </div>

            <!-- Equipment Section -->
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Equipo Entregado</h3>
                <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-gray-500 text-xs">Tipo</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->equipo->tipoEquipo->nombre ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">N° Inventario</dt>
                        <dd class="font-mono font-bold text-municipal-700">{{ $acta->equipo->numero_inventario }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">Marca</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->equipo->marca }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">Modelo</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->equipo->modelo }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">N° de Serie</dt>
                        <dd class="font-mono text-gray-700">{{ $acta->equipo->numero_serie ?? 'No registrado' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">Estado</dt>
                        <dd>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $acta->equipo->estado_badge }}">
                                {{ $acta->equipo->estado_label }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Recipient Section -->
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Funcionario que Recibe</h3>
                <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-gray-500 text-xs">Nombre Completo</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->funcionario->nombre_completo }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">RUT</dt>
                        <dd class="font-mono text-gray-700">{{ $acta->funcionario->rut }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">Cargo</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->funcionario->cargo }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs">Departamento</dt>
                        <dd class="font-semibold text-gray-800">{{ $acta->funcionario->departamento->nombre ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            @if($acta->observaciones)
            <!-- Observations -->
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Observaciones</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-gray-700">
                    {{ $acta->observaciones }}
                </div>
            </div>
            @endif

            <!-- Signature Boxes -->
            <div class="grid grid-cols-2 gap-6 mt-8">
                <div class="text-center">
                    <div class="border-b-2 border-gray-300 pb-1 mb-2 h-12"></div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">ENTREGA</p>
                    <p class="text-xs text-gray-500 mt-0.5">Unidad de Informática</p>
                    <p class="text-xs text-gray-500">Municipalidad de Lebu</p>
                </div>
                <div class="text-center">
                    <div class="border-b-2 border-gray-300 pb-1 mb-2 h-12">
                        @if($acta->firmada)
                            <p class="text-xs text-green-600 font-medium">[Firmado]</p>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">RECIBE</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $acta->funcionario->nombre_completo }}</p>
                    <p class="text-xs text-gray-400">RUT: {{ $acta->funcionario->rut }}</p>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 text-center">
            <p class="text-xs text-gray-400">
                Documento generado el {{ $acta->created_at->format('d/m/Y H:i') }} | INVETI - Sistema de Inventario Informático
            </p>
        </div>
    </div>
</div>

@endsection
