<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-800">
        <div class="min-h-screen flex">
            
            <!-- Sidebar (Menú Lateral) -->
            <aside class="w-64 bg-white shadow-md border-r border-gray-200 hidden md:block flex-shrink-0">
                
                <!-- Logo Oficial Alliance Telecoms Group, S.A -->
                <div class="h-20 flex items-center justify-center p-4 border-b border-gray-200 bg-white">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Alliance Telecoms Group, S.A" 
                         class="w-auto h-auto max-h-14 max-w-full object-contain">
                </div>

                <!-- Navegación Lateral -->
                <nav class="p-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="text-lg">📊</span> Panel de control
                    </a>

                    <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('clients.*') ? 'bg-sky-50 text-sky-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="text-lg">👥</span> Clientes
                    </a>

                    <a href="{{ route('contracts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('contracts.*') ? 'bg-sky-50 text-sky-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="text-lg">📄</span> Contratos
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        <span class="text-lg">🚀</span> Planes
                    </a>
                </nav>
            </aside>

            <!-- CONTENIDO PRINCIPAL -->
            <div class="flex-1 flex flex-col min-w-0">
                
                <!-- BARRA SUPERIOR -->
                <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-end">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-[#0284c7] text-white font-bold flex items-center justify-center text-xs shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                        </div>
                        <span class="text-xs font-bold text-gray-700 capitalize">
                            {{ Auth::user()->name ?? 'orlando' }}
                        </span>
                    </div>
                </div>

                <!-- CABECERA DE LA PÁGINA -->
                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-gray-100 py-4 px-6">
                        {{ $header }}
                    </header>
                @endif

                <!-- CONTENIDO DE LA VISTA -->
                <main class="p-6 flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>