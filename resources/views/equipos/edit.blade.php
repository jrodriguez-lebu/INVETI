@extends('layouts.app')

@section('title', 'Editar Equipo')
@section('page-title', 'Editar Equipo — ' . $equipo->numero_inventario)

@section('content')

<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-800">Editando: {{ $equipo->numero_inventario }}</h2>
                        <p class="text-xs text-gray-500">{{ $equipo->marca }} {{ $equipo->modelo }}</p>
                    </div>
                </div>
                <a href="{{ route('equipos.show', $equipo) }}" class="text-sm text-gray-500 hover:text-gray-700">Volver</a>
            </div>
        </div>

        <form method="POST" action="{{ route('equipos.update', $equipo) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-5">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipo de Equipo <span class="text-red-500">*</span></label>
                        <select name="tipo_equipo_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            <option value="">Seleccione un tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_equipo_id', $equipo->tipo_equipo_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Marca <span class="text-red-500">*</span></label>
                        <input type="text" name="marca" value="{{ old('marca', $equipo->marca) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Modelo <span class="text-red-500">*</span></label>
                        <input type="text" name="modelo" value="{{ old('modelo', $equipo->modelo) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de Serie</label>
                        <input type="text" name="numero_serie" value="{{ old('numero_serie', $equipo->numero_serie) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de Inventario <span class="text-red-500">*</span></label>
                        <input type="text" name="numero_inventario" value="{{ old('numero_inventario', $equipo->numero_inventario) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Estado <span class="text-red-500">*</span></label>
                        <select name="estado" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            @foreach(['activo' => 'Activo', 'inactivo' => 'Inactivo', 'baja' => 'Dado de Baja'] as $val => $label)
                                <option value="{{ $val }}" {{ old('estado', $equipo->estado) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Funcionario Responsable</label>
                        <select name="funcionario_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            <option value="">Sin asignar</option>
                            @foreach($funcionarios as $func)
                                <option value="{{ $func->id }}" {{ old('funcionario_id', $equipo->funcionario_id) == $func->id ? 'selected' : '' }}>
                                    {{ $func->nombre_completo }} — {{ $func->cargo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Departamento</label>
                        <select name="departamento_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            <option value="">Sin departamento</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}" {{ old('departamento_id', $equipo->departamento_id) == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha de Adquisición</label>
                        <input type="date" name="fecha_adquisicion" value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion?->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valor de Adquisición (CLP)</label>
                        <input type="number" name="valor_adquisicion" value="{{ old('valor_adquisicion', $equipo->valor_adquisicion) }}"
                               min="0" step="1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                {{-- Datos de Adquisición / Proveedor --}}
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Datos de Adquisición y Proveedor</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de OPI</label>
                            <input type="text" name="numero_opi" value="{{ old('numero_opi', $equipo->numero_opi) }}"
                                   placeholder="Ej: OPI-2026-001"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de Factura</label>
                            <input type="text" name="numero_factura" value="{{ old('numero_factura', $equipo->numero_factura) }}"
                                   placeholder="Ej: 001234"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">RUT Proveedor</label>
                            <input type="text" name="rut_proveedor" value="{{ old('rut_proveedor', $equipo->rut_proveedor) }}"
                                   placeholder="Ej: 76.543.210-K"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre Proveedor</label>
                            <input type="text" name="nombre_proveedor" value="{{ old('nombre_proveedor', $equipo->nombre_proveedor) }}"
                                   placeholder="Ej: Comercial TechChile SpA"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Descripción</label>
                        <textarea name="descripcion" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Observaciones</label>
                        <textarea name="observaciones" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('equipos.show', $equipo) }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
