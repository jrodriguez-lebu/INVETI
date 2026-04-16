@extends('layouts.app')

@section('title', 'Nueva Acta de Entrega')
@section('page-title', 'Nueva Acta de Entrega')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Generar Acta de Entrega</h2>
                    <p class="text-xs text-gray-500">El número de acta se generará automáticamente</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('actas.store') }}">
            @csrf
            <div class="p-6 space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Equipo <span class="text-red-500">*</span>
                    </label>
                    <select name="equipo_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('equipo_id') ? 'border-red-400' : '' }}">
                        <option value="">Seleccione un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}"
                                {{ (old('equipo_id') ?? $equipoSeleccionado?->id) == $equipo->id ? 'selected' : '' }}>
                                [{{ $equipo->numero_inventario }}] {{ $equipo->tipoEquipo->nombre }} — {{ $equipo->marca }} {{ $equipo->modelo }}
                            </option>
                        @endforeach
                    </select>
                    @if($equipoSeleccionado)
                        <p class="text-xs text-gray-500 mt-1">
                            Equipo preseleccionado: {{ $equipoSeleccionado->marca }} {{ $equipoSeleccionado->modelo }}
                        </p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Funcionario que Recibe <span class="text-red-500">*</span>
                    </label>
                    <select name="funcionario_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('funcionario_id') ? 'border-red-400' : '' }}">
                        <option value="">Seleccione un funcionario</option>
                        @foreach($funcionarios as $func)
                            <option value="{{ $func->id }}"
                                {{ (old('funcionario_id') ?? $equipoSeleccionado?->funcionario_id) == $func->id ? 'selected' : '' }}>
                                {{ $func->nombre_completo }} — {{ $func->cargo }} ({{ $func->departamento->nombre ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Fecha de Entrega <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', date('Y-m-d')) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Observaciones</label>
                    <textarea name="observaciones" rows="3"
                              placeholder="Condición del equipo al momento de la entrega, accesorios incluidos..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('observaciones') }}</textarea>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="firmada" id="firmada"
                           class="w-4 h-4 text-municipal-600 rounded focus:ring-municipal-500">
                    <label for="firmada" class="text-sm font-medium text-gray-700 cursor-pointer">Marcar como firmada</label>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('actas.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Generar Acta
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
