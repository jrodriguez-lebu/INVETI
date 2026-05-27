{{--
    Partial: Especificaciones de Hardware
    Uso:
      @include('equipos._specs_hardware', ['equipo' => $equipo])   ← en edit
      @include('equipos._specs_hardware')                          ← en create (Alpine controla visibilidad)

    Requiere Alpine.js con la variable `esComputador` definida en el componente padre.
--}}

<div x-show="esComputador"
     x-cloak
     class="border-t border-blue-100 pt-5">

    <div class="flex items-center space-x-2 mb-4">
        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-800">Especificaciones de Hardware</p>
            <p class="text-xs text-blue-500">Campos disponibles para computadores, notebooks y servidores.</p>
        </div>
    </div>

    {{-- Fila 1: Procesador + RAM --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Procesador</label>
            <input type="text" name="cpu"
                   value="{{ old('cpu', $equipo->cpu ?? '') }}"
                   placeholder="Ej: Intel Core i5-1235U, AMD Ryzen 5 5500U"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Memoria RAM</label>
            <div class="flex space-x-2">
                <input type="text" name="ram"
                       value="{{ old('ram', $equipo->ram ?? '') }}"
                       placeholder="Ej: 8 GB DDR4, 16 GB DDR5"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    {{-- Fila 2: Tipo disco + Capacidad + Pantalla --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipo de Disco</label>
            <select name="tipo_disco"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">— Seleccionar —</option>
                @foreach(['SSD' => 'SSD', 'HDD' => 'HDD', 'NVMe' => 'NVMe (M.2)', 'eMMC' => 'eMMC', 'Hibrido' => 'Híbrido (SSD+HDD)'] as $val => $label)
                    <option value="{{ $val }}"
                        {{ old('tipo_disco', $equipo->tipo_disco ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Capacidad del Disco</label>
            <input type="text" name="almacenamiento"
                   value="{{ old('almacenamiento', $equipo->almacenamiento ?? '') }}"
                   placeholder="Ej: 256 GB, 512 GB, 1 TB"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tamaño de Pantalla</label>
            <div class="relative">
                <input type="text" name="tamano_pantalla"
                       value="{{ old('tamano_pantalla', $equipo->tamano_pantalla ?? '') }}"
                       placeholder='Ej: 15.6, 27, 23.8'
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">″</span>
            </div>
        </div>
    </div>

</div>
