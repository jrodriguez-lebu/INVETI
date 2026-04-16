@extends('layouts.app')

@section('title', 'Editar Acta')
@section('page-title', 'Editar Acta — ' . $acta->numero_acta)

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Editando: {{ $acta->numero_acta }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">Solo se puede editar la fecha, observaciones y estado de firma</p>
        </div>

        <form method="POST" action="{{ route('actas.update', $acta) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">

                <!-- Read-only info -->
                <div class="p-4 bg-gray-50 rounded-lg text-sm space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Equipo:</span>
                        <span class="font-medium">{{ $acta->equipo->marca }} {{ $acta->equipo->modelo }} [{{ $acta->equipo->numero_inventario }}]</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Funcionario:</span>
                        <span class="font-medium">{{ $acta->funcionario->nombre_completo }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha de Entrega <span class="text-red-500">*</span></label>
                    <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', $acta->fecha_entrega->format('Y-m-d')) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Observaciones</label>
                    <textarea name="observaciones" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('observaciones', $acta->observaciones) }}</textarea>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="firmada" id="firmada" {{ old('firmada', $acta->firmada) ? 'checked' : '' }}
                           class="w-4 h-4 text-municipal-600 rounded focus:ring-municipal-500">
                    <label for="firmada" class="text-sm font-medium text-gray-700 cursor-pointer">Marcar como firmada</label>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('actas.show', $acta) }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
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
