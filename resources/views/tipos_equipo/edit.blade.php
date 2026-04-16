@extends('layouts.app')

@section('title', 'Editar Tipo de Equipo')
@section('page-title', 'Editar Tipo de Equipo')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Editando: {{ $tipo->nombre }}</h2>
        </div>
        <form method="POST" action="{{ route('tipos-equipo.update', $tipo) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Icono (nombre)</label>
                    <input type="text" name="icono" value="{{ old('icono', $tipo->icono) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('descripcion', $tipo->descripcion) }}</textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('tipos-equipo.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
