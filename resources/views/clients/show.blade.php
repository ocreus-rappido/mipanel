<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-[#0284c7] text-2xl">👤</span>
                <h2 class="text-2xl font-bold text-gray-800">
                    Cliente: {{ $client->name }}
                </h2>
                <span class="text-xs text-gray-400 font-normal ml-2">Inicio / Clientes / Ver</span>
            </div>

            <!-- BOTONES SUPERIORES (BORRAR Y VOLVER) -->
            <div class="flex items-center gap-2">
                <button onclick="confirmDelete()" class="bg-[#f87171] hover:bg-red-600 text-white text-xs font-bold px-4 py-2 rounded shadow-sm flex items-center gap-1 transition">
                    🔻 Borrar
                </button>
                
                <a href="{{ route('clients.index') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold px-4 py-2 rounded shadow-sm flex items-center gap-1 transition">
                    ⬅️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- BLOQUE SUPERIOR EN 2 COLUMNAS (DATOS Y GRÁFICA DE CONSUMO) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- DETALLES DEL CLIENTE -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-5">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-800">{{ $client->name }}</h3>
                    <span class="bg-sky-100 text-sky-800 text-xs font-bold px-3 py-1 rounded-full">
                        ID: CL-22-{{ 100 + $client->id }}
                    </span>
                </div>

                <!-- INFORMACIÓN BÁSICA Y CONTRATO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 text-xs">
                    <div>
                        <span class="text-gray-400 block">E-mail de contacto</span>
                        <strong class="text-gray-800">{{ strtolower(str_replace(' ', '', $client->name)) }}@gmail.com</strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Documento o Cédula / RUC</span>
                        <strong class="text-gray-800">{{ $client->dni ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Dirección</span>
                        <strong class="text-gray-800">{{ $client->address ?? 'Sin dirección registrada' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Teléfono celular</span>
                        <strong class="text-gray-800">{{ $client->phone ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Plan de Internet</span>
                        <strong class="text-emerald-600 font-bold">🚀 {{ $client->plan }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Dirección IP Asignada</span>
                        <strong class="text-sky-700 font-mono font-bold">{{ $client->ip_address }}</strong>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Vendedor / Responsable</span>
                        <strong class="text-gray-800">{{ $client->last_edited_by ?? 'Sin asignar' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Recaudador Asignado</span>
                        <strong class="text-gray-800">{{ $client->last_payment_by ?? 'Sin asignar' }}</strong>
                    </div>
                </div>

                <!-- 📺 📹 SECCIÓN DE EQUIPOS Y SERVICIOS ADICIONALES -->
                <div class="border-t border-gray-100 pt-4 space-y-3">
                    <h4 class="font-bold text-xs text-gray-800 flex items-center gap-1.5">
                        📦 Equipos y Servicios Adicionales
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                        <!-- TV BOX -->
                        <div class="p-3 rounded-lg border {{ $client->has_tv_box ? 'bg-sky-50/60 border-sky-200' : 'bg-gray-50 border-gray-100' }}">
                            <span class="text-gray-500 block font-medium">📺 Decodificador TV Box</span>
                            @if($client->has_tv_box)
                                <strong class="text-sky-800 font-bold">{{ $client->tv_box_count ?? 1 }} Equipo(s)</strong>
                            @else
                                <span class="text-gray-400">No contratado</span>
                            @endif
                        </div>

                        <!-- CÁMARAS DE SEGURIDAD -->
                        <div class="p-3 rounded-lg border {{ $client->has_cameras ? 'bg-sky-50/60 border-sky-200' : 'bg-gray-50 border-gray-100' }}">
                            <span class="text-gray-500 block font-medium">📹 Cámaras de Seguridad</span>
                            @if($client->has_cameras)
                                <strong class="text-sky-800 font-bold">{{ $client->camera_count ?? 1 }} Cámara(s)</strong>
                            @else
                                <span class="text-gray-400">No contratado</span>
                            @endif
                        </div>

                        <!-- APLICACIÓN DE TV -->
                        <div class="p-3 rounded-lg border {{ $client->has_tv_app ? 'bg-sky-50/60 border-sky-200' : 'bg-gray-50 border-gray-100' }}">
                            <span class="text-gray-500 block font-medium">📱 Aplicación de TV Móvil</span>
                            @if($client->has_tv_app)
                                <strong class="text-emerald-600 font-bold">✔ Activo</strong>
                            @else
                                <span class="text-gray-400">No contratado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- OBSERVACIONES / COMENTARIOS -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mt-2 space-y-1">
                    <h4 class="font-bold text-xs text-gray-700">Observaciones:</h4>
                    <p class="text-xs text-gray-600 font-medium whitespace-pre-line">{{ $client->comments ?? 'Sin observaciones registradas.' }}</p>
                </div>
            </div>

            <!-- GRÁFICA DE CONSUMO DEL ÚLTIMO DÍA -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="text-sky-600 font-bold">⬇️⬆️</span> Consumo del último día
                    </h3>
                </div>

                <div class="h-56 bg-slate-900 rounded-lg p-3 relative flex flex-col justify-between overflow-hidden shadow-inner">
                    <div class="flex justify-between text-[10px] text-gray-400">
                        <span>28.6 Mb</span>
                        <span>19.1 Mb</span>
                        <span>0 Bits</span>
                    </div>

                    <div class="absolute inset-x-0 bottom-6 h-32 flex items-end justify-between px-3 gap-1 opacity-90">
                        <template x-for="h in [10,25,50,15,80,100,35,60,90,40,20,70,30,85,15,45]">
                            <div class="bg-gradient-to-t from-emerald-500 to-sky-400 w-full rounded-t-sm" :style="'height: ' + h + '%'"></div>
                        </template>
                    </div>

                    <div class="flex justify-between text-[10px] text-gray-400 border-t border-slate-700 pt-1 z-10">
                        <span>30. Jul</span>
                        <span>12:00</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- BLOQUE INFERIOR DE FACTURACIÓN Y MOVIMIENTOS -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-6">
            <div class="flex justify-end">
                <button class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold px-4 py-2 rounded shadow-sm transition">
                    Ver movimientos de facturación
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs">
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500 font-medium">Razón Social</span>
                        <span class="font-bold text-gray-800">Fantasía</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500 font-medium">Régimen</span>
                        <span class="font-bold text-gray-800">Fantasía</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500 font-medium">Tipo factura</span>
                        <span class="font-bold text-gray-800">Comprobante</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500 font-medium">Enviar email con factura emitida al cliente</span>
                        <span class="text-emerald-500 font-bold">✔</span>
                    </div>
                </div>

                <!-- IMPORTES EN BALBOAS DINÁMICOS (B/.) -->
                <div class="space-y-4 text-center md:text-right">
                    <div>
                        <span class="text-xs font-bold text-gray-500 block mb-1">Facturas impagas</span>
                        <span class="text-2xl font-bold {{ ($client->unpaid_invoices ?? 0) > 0 ? 'text-rose-500' : 'text-gray-400' }}">
                            B/. {{ number_format($client->unpaid_invoices ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-500 block mb-1">Balance C/C</span>
                        <span class="text-xl font-bold {{ ($client->account_balance ?? 0) < 0 ? 'text-rose-500' : 'text-gray-400' }}">
                            B/. {{ number_format($client->account_balance ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-500 block mb-1">Crédito disponible en cuenta</span>
                        <span class="text-lg font-bold text-emerald-500">
                            B/. {{ number_format($client->available_credit ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- BOTONES INFERIORES DE BORRAR Y VOLVER -->
            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-6">
                <button onclick="confirmDelete()" class="bg-[#f87171] hover:bg-red-600 text-white text-xs font-bold px-5 py-2.5 rounded shadow-sm transition">
                    🔻 Borrar
                </button>

                <a href="{{ route('clients.index') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold px-6 py-2.5 rounded shadow-sm transition">
                    ⬅️ Volver
                </a>
            </div>
        </div>

    </div>

    <!-- SCRIPT DE CONFIRMACIÓN AL BORRAR -->
    <form id="delete-form" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete() {
            if (confirm('¿Está seguro que desea borrar datos del cliente?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
</x-app-layout>