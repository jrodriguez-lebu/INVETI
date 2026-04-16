<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'INVETI') - Municipalidad de Lebu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        municipal: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-item.active { background-color: #1e40af; color: white; }
        .sidebar-item.active svg { color: white; }
    </style>
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: true, mobileOpen: false }">

    <!-- Mobile sidebar overlay -->
    <div x-show="mobileOpen" x-cloak
         @click="mobileOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

    <!-- Wrapper flex principal -->
    <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside :class="mobileOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-municipal-900 text-white transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:flex-shrink-0 flex flex-col">

        <!-- Logo / Brand -->
        <div class="flex items-center px-4 py-5 border-b border-municipal-700 bg-municipal-800">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-municipal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-lg leading-none text-white">INVETI</div>
                    <div class="text-xs text-municipal-300 leading-none mt-0.5">Muni. Lebu</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Equipos -->
            <div x-data="{ open: {{ request()->routeIs('equipos.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Equipos
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-municipal-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="mt-1 ml-4 space-y-1">
                    <a href="{{ route('equipos.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-xs text-municipal-300 hover:bg-municipal-800 hover:text-white transition-colors {{ request()->routeIs('equipos.index') && !request()->filled('tipo_equipo_id') ? 'bg-municipal-800 text-white' : '' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-municipal-500 mr-2"></span>
                        Todos los Equipos
                    </a>
                    <a href="{{ route('equipos.create') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-xs text-municipal-300 hover:bg-municipal-800 hover:text-white transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-municipal-500 mr-2"></span>
                        Nuevo Equipo
                    </a>
                </div>
            </div>

            <!-- Funcionarios -->
            <a href="{{ route('funcionarios.index') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('funcionarios.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Funcionarios
            </a>

            <!-- Departamentos -->
            <a href="{{ route('departamentos.index') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('departamentos.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Departamentos
            </a>

            <!-- Actas de Entrega -->
            <a href="{{ route('actas.index') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('actas.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Actas de Entrega
            </a>

            <!-- Divider -->
            <div class="pt-2 pb-1">
                <p class="px-3 text-xs font-semibold text-municipal-500 uppercase tracking-wider">Configuración</p>
            </div>

            <!-- Usuarios del Sistema -->
            <a href="{{ route('users.index') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Usuarios
            </a>

            <!-- Tipos de Equipo -->
            <a href="{{ route('tipos-equipo.index') }}"
               class="sidebar-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-municipal-200 hover:bg-municipal-800 hover:text-white transition-colors group {{ request()->routeIs('tipos-equipo.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Tipos de Equipo
            </a>

        </nav>

        <!-- Usuario + Logout -->
        <div class="px-3 py-3 border-t border-municipal-700 bg-municipal-800 space-y-2">
            {{-- Info usuario --}}
            <div class="flex items-center space-x-3 px-2 py-2 rounded-lg bg-municipal-900/50">
                <div class="w-8 h-8 rounded-full bg-municipal-600 flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Administrador' }}</p>
                    <p class="text-xs text-municipal-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>
            {{-- Botón logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg text-xs font-medium text-municipal-300 hover:bg-red-700 hover:text-white transition-colors group">
                    <svg class="w-4 h-4 text-municipal-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
            <p class="text-xs text-municipal-500 text-center pb-1">INVETI v1.0 — Muni. Lebu</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 min-w-0 overflow-auto">

        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Mobile menu button -->
                <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Page title -->
                <div class="flex items-center space-x-2">
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'INVETI')</h1>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1.5 text-municipal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </div>
                    <div class="flex items-center space-x-2 bg-municipal-50 text-municipal-800 px-3 py-1.5 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="hidden sm:inline">Muni. Lebu</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content area -->
        <main class="flex-1 p-4 sm:p-6">

            <!-- Flash messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-cloak
                     class="mb-4 flex items-center p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-cloak
                     class="mb-4 flex items-center p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                    <svg class="w-5 h-5 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-red-800">Por favor corrija los siguientes errores:</span>
                    </div>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-6 py-3">
            <p class="text-xs text-gray-400 text-center">
                INVETI &mdash; Sistema de Inventario de Equipos Informáticos &mdash; Ilustre Municipalidad de Lebu &copy; {{ date('Y') }}
            </p>
        </footer>
    </div>

    </div>{{-- /wrapper flex principal --}}

</body>
</html>
