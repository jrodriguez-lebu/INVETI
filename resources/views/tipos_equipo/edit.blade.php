@extends('layouts.app')

@section('title', 'Editar Tipo de Equipo')
@section('page-title', 'Editar Tipo de Equipo')

@section('content')
<div class="max-w-lg">

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200" x-data="{ icono: '{{ old('icono', $tipo->icono_html) }}' }">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-800">Editando: {{ $tipo->nombre }}</h2>
            <span class="text-xs text-gray-400">{{ $tipo->equipos_count }} equipo(s)</span>
        </div>
        <form method="POST" action="{{ route('tipos-equipo.update', $tipo) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-5">

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $tipo->nombre) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('nombre') ? 'border-red-400' : '' }}">
                </div>

                {{-- Selector de ícono emoji --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícono</label>
                    <input type="hidden" name="icono" x-model="icono">

                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-municipal-100 rounded-xl flex items-center justify-center text-2xl border-2 border-municipal-200">
                            <span x-text="icono"></span>
                        </div>
                        <span class="text-sm text-gray-500">Selecciona un ícono:</span>
                    </div>

                    <div class="grid grid-cols-8 gap-2">
                        @foreach([
                            '🖥️','💻','🖨️','📱','🖱️','⌨️','💾','📺',
                            '📡','🔌','🔋','💡','📷','📸','🎥','📹',
                            '📟','☎️','📠','🖲️','💿','📀','🖧','🔧',
                            '⚙️','🔩','🖦','📦','🗄️','🖨','📲','🔦',
                        ] as $emoji)
                        <button type="button"
                                @click="icono = '{{ $emoji }}'"
                                :class="icono === '{{ $emoji }}' ? 'ring-2 ring-municipal-500 bg-municipal-50' : 'hover:bg-gray-100'"
                                class="w-9 h-9 rounded-lg text-xl flex items-center justify-center transition-colors border border-gray-200">
                            {{ $emoji }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descripción</label>
                    <textarea name="descripcion" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('descripcion', $tipo->descripcion) }}</textarea>
                </div>

            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('tipos-equipo.index') }}"
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
