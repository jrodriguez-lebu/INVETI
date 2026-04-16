@extends('layouts.app')

@section('title', 'Nuevo Equipo')
@section('page-title', 'Registrar Nuevo Equipo')

@section('content')
<div class="max-w-5xl"
     x-data="equipoForm()"
     x-init="init()">

    {{-- ── MODAL NUEVO FUNCIONARIO ──────────────────────────────────────────── --}}
    <div x-show="showModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @keydown.escape.window="showModal = false">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" @click="showModal = false"></div>

        {{-- Panel --}}
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg z-10"
             @click.stop>
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-municipal-50 rounded-t-xl">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-municipal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <h3 class="text-base font-semibold text-municipal-900">Agregar Nuevo Funcionario</h3>
                </div>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                {{-- Errores del modal --}}
                <div x-show="modalErrors.length > 0" x-cloak
                     class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                        <template x-for="e in modalErrors" :key="e">
                            <li x-text="e"></li>
                        </template>
                    </ul>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" x-model="nuevoFunc.nombre"
                               placeholder="Ej: María"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Apellido(s) <span class="text-red-500">*</span></label>
                        <input type="text" x-model="nuevoFunc.apellido"
                               placeholder="Ej: González Pérez"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">RUT <span class="text-red-500">*</span></label>
                        <input type="text" x-model="nuevoFunc.rut"
                               placeholder="12.345.678-9"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Cargo <span class="text-red-500">*</span></label>
                        <input type="text" x-model="nuevoFunc.cargo"
                               placeholder="Ej: Administrativo"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Departamento / Dirección</label>
                    <select x-model="nuevoFunc.departamento_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        <option value="">Sin departamento</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" x-model="nuevoFunc.email"
                               placeholder="correo@municipalidadlebu.cl"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" x-model="nuevoFunc.telefono"
                               placeholder="+56 9 XXXX XXXX"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                <button type="button" @click="showModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="button" @click="guardarFuncionario()"
                        :disabled="savingFunc"
                        class="px-5 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 disabled:opacity-50 flex items-center space-x-2">
                    <svg x-show="savingFunc" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <span x-text="savingFunc ? 'Guardando...' : 'Guardar Funcionario'"></span>
                </button>
            </div>
        </div>
    </div>
    {{-- ── /MODAL ───────────────────────────────────────────────────────────── --}}

    <form method="POST" action="{{ route('equipos.store') }}">
        @csrf

        {{-- ── PANEL 1: DATOS COMUNES ──────────────────────────────────────── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-municipal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-municipal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-800">Datos Comunes del Equipo</h2>
                        <p class="text-xs text-gray-500">Esta información se aplicará a todos los equipos que registre.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- Tipo, Marca, Modelo --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tipo de Equipo <span class="text-red-500">*</span>
                        </label>
                        <select name="tipo_equipo_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('tipo_equipo_id') ? 'border-red-400' : '' }}">
                            <option value="">Seleccione un tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Marca <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="marca" value="{{ old('marca') }}" required
                               placeholder="HP, Dell, Lenovo..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('marca') ? 'border-red-400' : '' }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Modelo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="modelo" value="{{ old('modelo') }}" required
                               placeholder="ProBook 450, ThinkPad X1..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500 {{ $errors->has('marca') ? 'border-red-400' : '' }}">
                    </div>
                </div>

                {{-- Estado, Fecha, Valor --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="estado" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            <option value="activo"   {{ old('estado', 'activo') === 'activo'   ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') === 'inactivo'               ? 'selected' : '' }}>Inactivo</option>
                            <option value="baja"     {{ old('estado') === 'baja'                   ? 'selected' : '' }}>Dado de Baja</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha de Adquisición</label>
                        <input type="date" name="fecha_adquisicion" value="{{ old('fecha_adquisicion') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valor de Adquisición (CLP)</label>
                        <input type="number" name="valor_adquisicion" value="{{ old('valor_adquisicion') }}"
                               min="0" step="1" placeholder="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                    </div>
                </div>

                {{-- Funcionario + Departamento --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Funcionario Responsable</label>
                        <div class="flex space-x-2">
                            <select name="funcionario_id" id="select-funcionario"
                                    x-ref="selectFuncionario"
                                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                                <option value="">Sin asignar</option>
                                @foreach($funcionarios as $func)
                                    <option value="{{ $func->id }}"
                                            data-label="{{ $func->nombre_completo }} — {{ $func->cargo }}"
                                            {{ old('funcionario_id') == $func->id ? 'selected' : '' }}>
                                        {{ $func->nombre_completo }} — {{ $func->cargo }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- Botón agregar funcionario --}}
                            <button type="button" @click="abrirModal()"
                                    title="Agregar nuevo funcionario"
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-municipal-100 text-municipal-700 rounded-lg hover:bg-municipal-200 transition-colors border border-municipal-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">¿No aparece? Haz clic en <strong>+</strong> para agregar.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Departamento / Dirección</label>
                        <select name="departamento_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                            <option value="">Sin departamento</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}" {{ old('departamento_id') == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Datos de Adquisición / Proveedor --}}
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Datos de Adquisición y Proveedor</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de OPI</label>
                            <input type="text" name="numero_opi" value="{{ old('numero_opi') }}"
                                   placeholder="Ej: OPI-2026-001"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">N° de Factura</label>
                            <input type="text" name="numero_factura" value="{{ old('numero_factura') }}"
                                   placeholder="Ej: 001234"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">RUT Proveedor</label>
                            <input type="text" name="rut_proveedor" value="{{ old('rut_proveedor') }}"
                                   placeholder="Ej: 76.543.210-K"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre Proveedor</label>
                            <input type="text" name="nombre_proveedor" value="{{ old('nombre_proveedor') }}"
                                   placeholder="Ej: Comercial TechChile SpA"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">
                        </div>
                    </div>
                </div>

                {{-- Descripción / Observaciones --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Descripción</label>
                        <textarea name="descripcion" rows="2" placeholder="Descripción general del equipo..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('descripcion') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Observaciones</label>
                        <textarea name="observaciones" rows="2" placeholder="Observaciones adicionales..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-municipal-500">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── PANEL 2: CANTIDAD + FILAS INDIVIDUALES ──────────────────────── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">N° de Inventario y Serie</h2>
                            <p class="text-xs text-gray-500">Defina la cantidad e identifique cada unidad.</p>
                        </div>
                    </div>

                    {{-- Control de cantidad --}}
                    <div class="flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2">
                        <span class="text-sm font-medium text-gray-600">Cantidad de equipos:</span>
                        <div class="flex items-center space-x-2">
                            <button type="button" @click="decrementar()"
                                    class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-700 font-bold text-lg leading-none transition-colors">−</button>
                            <span x-text="cantidad"
                                  class="w-8 text-center text-base font-bold text-municipal-800"></span>
                            <button type="button" @click="incrementar()"
                                    class="w-7 h-7 rounded-full bg-municipal-600 hover:bg-municipal-700 flex items-center justify-center text-white font-bold text-lg leading-none transition-colors">+</button>
                        </div>
                        <button type="button" @click="regenerarNumeros()"
                                :disabled="loadingNums"
                                class="ml-2 flex items-center space-x-1.5 text-xs text-municipal-600 hover:text-municipal-800 disabled:opacity-50">
                            <svg :class="loadingNums ? 'animate-spin' : ''" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Regenerar N°</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Errores de items --}}
            @if($errors->has('items') || $errors->has('items.*') || $errors->has('items.*.numero_inventario'))
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    @foreach($errors->get('items*') as $msgs)
                        @foreach($msgs as $msg)<p>{{ $msg }}</p>@endforeach
                    @endforeach
                    @if($errors->has('items'))<p>{{ $errors->first('items') }}</p>@endif
                </div>
            @endif

            {{-- Tabla de items --}}
            <div class="p-6">
                {{-- Cabecera --}}
                <div class="grid grid-cols-12 gap-3 mb-2 px-1">
                    <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase">#</div>
                    <div class="col-span-5 text-xs font-semibold text-gray-500 uppercase">
                        N° de Inventario <span class="text-red-500">*</span>
                    </div>
                    <div class="col-span-5 text-xs font-semibold text-gray-500 uppercase">N° de Serie</div>
                    <div class="col-span-1"></div>
                </div>

                {{-- Filas dinámicas --}}
                <div class="space-y-2">
                    <template x-for="(item, idx) in items" :key="idx">
                        <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 rounded-lg px-3 py-2.5 border border-gray-100">
                            {{-- Número de fila --}}
                            <div class="col-span-1">
                                <span class="text-xs font-bold text-gray-400 w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center"
                                      x-text="idx + 1"></span>
                            </div>
                            {{-- N° Inventario --}}
                            <div class="col-span-5">
                                <input type="text"
                                       :name="'items[' + idx + '][numero_inventario]'"
                                       x-model="item.numero_inventario"
                                       required
                                       placeholder="INV-0000"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-municipal-500 bg-white">
                            </div>
                            {{-- N° Serie --}}
                            <div class="col-span-5">
                                <input type="text"
                                       :name="'items[' + idx + '][numero_serie]'"
                                       x-model="item.numero_serie"
                                       placeholder="Opcional"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-municipal-500 bg-white">
                            </div>
                            {{-- Eliminar fila --}}
                            <div class="col-span-1 flex justify-center">
                                <button type="button" @click="eliminarFila(idx)"
                                        x-show="items.length > 1"
                                        class="w-7 h-7 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Resumen --}}
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500 border-t border-gray-100 pt-3">
                    <span>Total: <strong x-text="items.length" class="text-municipal-800"></strong>
                        <span x-text="items.length === 1 ? 'equipo' : 'equipos'"></span> a registrar</span>
                    <span x-show="loadingNums" class="text-xs text-municipal-600 flex items-center space-x-1">
                        <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <span>Generando números...</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- ── PANEL 3: OPCIONES FINALES ────────────────────────────────────── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-5">
                {{-- Generar Acta (solo cuando hay 1 equipo) --}}
                <div x-show="items.length === 1"
                     class="p-4 bg-purple-50 border border-purple-200 rounded-lg mb-4">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="generar_acta"
                               class="w-4 h-4 text-municipal-600 rounded focus:ring-municipal-500">
                        <div>
                            <span class="text-sm font-medium text-purple-900">Generar Acta de Entrega al guardar</span>
                            <p class="text-xs text-purple-600 mt-0.5">Si el equipo tiene un funcionario asignado, se creará el acta automáticamente.</p>
                        </div>
                    </label>
                </div>
                <div x-show="items.length > 1"
                     class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>Registro múltiple:</strong> Se crearán <strong x-text="items.length"></strong> equipos.
                        Podrá generar las actas de entrega individualmente desde el detalle de cada equipo.
                    </p>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50 rounded-b-xl">
                <a href="{{ route('equipos.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-municipal-700 text-white rounded-lg text-sm font-medium hover:bg-municipal-800 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span x-text="items.length === 1 ? 'Guardar Equipo' : 'Guardar ' + items.length + ' Equipos'"></span>
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function equipoForm() {
    return {
        cantidad: 1,
        items: [{ numero_inventario: '', numero_serie: '' }],
        loadingNums: false,

        // Modal funcionario
        showModal: false,
        savingFunc: false,
        modalErrors: [],
        nuevoFunc: { nombre: '', apellido: '', rut: '', cargo: '', departamento_id: '', email: '', telefono: '' },

        async init() {
            // Cargar primer número al iniciar
            await this.cargarNumeros(1);
        },

        async cargarNumeros(count, offset = 0) {
            this.loadingNums = true;
            try {
                const res = await fetch(`/api/next-inventario?count=${count}`);
                const data = await res.json();
                return data.numbers || [];
            } catch (e) {
                return [];
            } finally {
                this.loadingNums = false;
            }
        },

        async regenerarNumeros() {
            const nums = await this.cargarNumeros(this.items.length);
            nums.forEach((n, i) => {
                if (this.items[i]) this.items[i].numero_inventario = n;
            });
        },

        async incrementar() {
            if (this.cantidad >= 20) return;
            this.cantidad++;
            // Pedir solo el siguiente número para la nueva fila
            const nums = await this.cargarNumeros(this.cantidad);
            // Agregar nueva fila con el último número
            this.items.push({
                numero_inventario: nums[this.items.length] || '',
                numero_serie: ''
            });
        },

        decrementar() {
            if (this.cantidad <= 1) return;
            this.cantidad--;
            this.items.pop();
        },

        eliminarFila(idx) {
            if (this.items.length <= 1) return;
            this.items.splice(idx, 1);
            this.cantidad = this.items.length;
        },

        abrirModal() {
            this.nuevoFunc = { nombre: '', apellido: '', rut: '', cargo: '', departamento_id: '', email: '', telefono: '' };
            this.modalErrors = [];
            this.showModal = true;
        },

        async guardarFuncionario() {
            this.modalErrors = [];

            // Validación básica client-side
            if (!this.nuevoFunc.nombre.trim())    { this.modalErrors.push('El nombre es requerido.'); }
            if (!this.nuevoFunc.apellido.trim())  { this.modalErrors.push('El apellido es requerido.'); }
            if (!this.nuevoFunc.rut.trim())       { this.modalErrors.push('El RUT es requerido.'); }
            if (!this.nuevoFunc.cargo.trim())     { this.modalErrors.push('El cargo es requerido.'); }
            if (this.modalErrors.length > 0) return;

            this.savingFunc = true;
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content
                           || document.querySelector('input[name="_token"]')?.value;

                const res = await fetch('/api/funcionarios/quick-store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.nuevoFunc),
                });

                if (!res.ok) {
                    const err = await res.json();
                    if (err.errors) {
                        this.modalErrors = Object.values(err.errors).flat();
                    } else {
                        this.modalErrors = ['Error al guardar el funcionario.'];
                    }
                    return;
                }

                const func = await res.json();

                // Agregar al select y seleccionarlo
                const select = document.getElementById('select-funcionario');
                const option = document.createElement('option');
                option.value = func.id;
                option.text  = func.label;
                option.selected = true;
                select.appendChild(option);

                this.showModal = false;

            } catch (e) {
                this.modalErrors = ['Error de conexión. Intente nuevamente.'];
            } finally {
                this.savingFunc = false;
            }
        },
    };
}
</script>
@endsection
