@extends('layouts.app')

@section('title', 'Editar Funcionario')
@section('page-title', 'Editar Funcionario')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Editando: {{ $funcionario->nombre_completo }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $funcionario->rut }}</p>
        </div>

        <form method="POST" action="{{ route('funcionarios.update', $funcionario) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $funcionario->nombre) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="apellido" value="{{ old('apellido', $funcionario->apellido) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">RUT <span class="text-red-500">*</span></label>
                        <input type="text" name="rut" value="{{ old('rut', $funcionario->rut) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cargo <span class="text-red-500">*</span></label>
                        <input type="text" name="cargo" value="{{ old('cargo', $funcionario->cargo) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Departamento <span class="text-red-500">*</span></label>
                    <select name="departamento_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ old('departamento_id', $funcionario->departamento_id) == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $funcionario->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $funcionario->telefono) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="activo" id="activo" {{ old('activo', $funcionario->activo) ? 'checked' : '' }}
                           class="w-4 h-4 text-municipal-600 rounded focus:ring-municipal-500">
                    <label for="activo" class="text-sm font-medium text-gray-700 cursor-pointer">Funcionario activo</label>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('funcionarios.show', $funcionario) }}"
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
