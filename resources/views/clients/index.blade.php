<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-rose-500 text-xl font-bold">?</span>
                <h2 class="text-2xl font-bold text-gray-800">Clientes</h2>
                <span class="text-xs text-gray-400 font-normal ml-1">Inicio / Clientes</span>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" onclick="document.getElementById('modal-importacion').classList.remove('hidden'); document.getElementById('modal-importacion').classList.add('flex');" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-semibold px-3 py-2 rounded shadow-sm transition">
                    ☁️ Importar Clientes
                </button>
                
                <a href="{{ route('clients.export') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-semibold px-3 py-2 rounded shadow-sm flex items-center gap-1 transition">
                    📥 Exportar CSV
                </a>
                
                <a href="{{ route('clients.create') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-semibold px-3 py-2 rounded shadow-sm transition flex items-center gap-1">
                    <span class="text-sm font-bold">+</span> Crear nuevo Cliente
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-4" x-data="{ showModal: false, modalClient: {} }">
        
        <!-- 🔍 BARRA DE BÚSQUEDA -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('clients.index') }}" method="GET" class="flex gap-2">
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sky-500 text-sm">🔍</span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Buscar por: Nombre, E-mail, Teléfono, Cédula / RUC o IP..." 
                           class="w-full pl-11 pr-4 py-2.5 text-xs rounded-full border-gray-200 focus:border-sky-500 focus:ring-sky-500 shadow-sm text-gray-700 font-medium">
                </div>
                <button type="submit" class="bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 px-5 py-2.5 rounded-full text-xs font-semibold transition">
                    Buscar
                </button>
            </form>
        </div>

        <!-- 📊 TABLA DE CLIENTES -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start relative">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700">
                        <thead class="bg-gray-50/80 border-b border-gray-100 text-gray-500 font-bold">
                            <tr>
                                <!-- 🔃 COLUMNA # ORDENABLE -->
                                <th class="px-4 py-3 w-12 text-center">
                                    <a href="{{ route('clients.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_dir' => ($sortBy == 'id' && $sortDir == 'asc') ? 'desc' : 'asc'])) }}" class="hover:text-sky-600 flex items-center justify-center gap-1">
                                        # {!! $sortBy == 'id' ? ($sortDir == 'asc' ? '▲' : '▼') : '▲' !!}
                                    </a>
                                </th>

                                <!-- 🔃 COLUMNA NOMBRE Y APELLIDO ORDENABLE (A-Z / Z-A) -->
                                <th class="px-4 py-3">
                                    <a href="{{ route('clients.index', array_merge(request()->query(), ['sort_by' => 'name', 'sort_dir' => ($sortBy == 'name' && $sortDir == 'asc') ? 'desc' : 'asc'])) }}" class="hover:text-sky-600 flex items-center gap-1">
                                        Nombre y Apellido {!! $sortBy == 'name' ? ($sortDir == 'asc' ? '▲' : '▼') : '▲' !!}
                                    </a>
                                </th>

                                <th class="px-4 py-3">Facturación / IP</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($clients as $index => $client)
                                <tr class="bg-[#e0f2fe]/80 border-l-4 border-sky-600 transition hover:bg-sky-100">
                                    <td class="px-3 py-4 text-center font-bold text-gray-800">
                                        {{ $clients->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-[#0284c7] hover:underline flex items-center gap-1.5 text-sm cursor-pointer" @click="modalClient = {{ json_encode($client) }}; showModal = true">
                                            <span>{{ $client->name }}</span>
                                            <span class="text-[10px] bg-sky-200 text-sky-800 rounded-full w-4 h-4 inline-flex items-center justify-center font-bold">i</span>
                                        </div>
                                        <div class="text-[11px] text-gray-500 mt-1 font-medium">📍 {{ $client->address ?? 'Sin dirección' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-[11px] text-gray-600 space-y-1">
                                        <div class="font-medium">📑 Cédula/RUC: {{ $client->dni ?? 'N/A' }}</div>
                                        <div class="font-mono text-sky-700 font-bold">🌐 IP: {{ $client->ip_address }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center gap-1 bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
                                            <a href="{{ route('clients.show', $client->id) }}?tab=billing" class="p-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded text-xs font-bold transition inline-block">$</a>
                                            <a href="{{ route('clients.show', $client->id) }}" class="p-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded text-xs transition inline-block">🔍</a>
                                            <a href="{{ route('clients.edit', $client->id) }}" class="p-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded text-xs transition inline-block">✏️</a>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de borrar este cliente?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-gray-100 hover:bg-red-500 hover:text-white text-gray-600 rounded text-xs transition">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">No hay clientes registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ======================================================== -->
                <!-- 📄 PAGINACIÓN ESTILO WISPRO (IGUAL A TU CAPTURA DE PANTALLA) -->
                <!-- ======================================================== -->
                <div class="p-4 bg-white border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-600">
                    
                    <!-- LADO IZQUIERDO: PÁGINAS Y BOTONES -->
                    <div class="flex items-center gap-1">
                        @if($clients->onFirstPage())
                            <span class="px-3 py-1.5 border border-gray-200 rounded text-gray-300 bg-gray-50 cursor-not-allowed">1</span>
                        @else
                            <a href="{{ $clients->url(1) }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-100">1</a>
                        @endif

                        @if($clients->currentPage() > 1)
                            <a href="{{ $clients->url(2) }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-100">2</a>
                        @endif

                        @if($clients->currentPage() > 2)
                            <a href="{{ $clients->url(3) }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-100">3</a>
                        @endif

                        @if($clients->hasMorePages())
                            <a href="{{ $clients->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-700 hover:bg-gray-100 font-medium">Siguiente</a>
                            <a href="{{ $clients->url($clients->lastPage()) }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-700 hover:bg-gray-100 font-medium">Último</a>
                        @endif
                    </div>

                    <!-- LADO DERECHO: SELECTOR DE BLOQUES (20, 50, 100, 500) -->
                    <div class="flex items-center gap-2">
                        <span>Paginar de a</span>
                        <div class="inline-flex rounded-md shadow-sm">
                            @foreach([20, 50, 100, 500] as $size)
                                <a href="{{ route('clients.index', array_merge(request()->query(), ['per_page' => $size])) }}" 
                                   class="px-3 py-1.5 text-xs font-semibold border border-gray-200 first:rounded-l-md last:rounded-r-md {{ $perPage == $size ? 'bg-gray-300 text-gray-800 font-bold border-gray-300' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                                    {{ $size }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- LEYENDA DEL TOTAL EN LA PARTE INFERIOR -->
                <div class="px-4 pb-3 bg-white text-xs text-gray-500 font-medium">
                    Mostrando Clientes {{ $clients->firstItem() ?? 0 }} - {{ $clients->lastItem() ?? 0 }} de {{ $clients->total() }} en total
                </div>
            </div>

            <!-- FICHA LATERAL DERECHA -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 space-y-4 sticky top-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 text-gray-400 text-xs font-bold">
                    <span class="text-sky-600">👥 Información Rápida</span>
                </div>
                @if($clients->count() > 0)
                    @php $first = $clients->first(); @endphp
                    <div class="space-y-3">
                        <h3 class="font-bold text-gray-900 text-sm">{{ $first->name }} <span class="text-xs text-gray-400 font-normal">(ID: CL-22-{{ $first->id }})</span></h3>
                    </div>
                @endif
            </div>
        </div>

        <!-- 🪟 MODAL RESUMEN -->
        <div x-show="showModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" style="display: none;" @click.self="showModal = false">
            <div class="bg-white rounded-xl shadow-2xl border border-sky-200 max-w-md w-full overflow-hidden">
                <div class="bg-[#0284c7] text-white px-5 py-3 flex items-center justify-between">
                    <h3 class="font-bold text-sm">Resumen del cliente 👤</h3>
                    <button @click="showModal = false" class="text-white hover:text-red-200 text-lg font-bold">✕</button>
                </div>
                <div class="p-5 space-y-4 text-xs text-gray-700">
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-900 text-sm" x-text="'Información general (ID: CL-22-' + (100 + modalClient.id) + ')'"></p>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-start gap-2"><span>📍</span><span class="font-medium" x-text="modalClient.address || 'Sin dirección registrada'"></span></div>
                        <div class="flex items-center gap-2"><span>📱</span><span class="font-medium" x-text="modalClient.phone || 'Sin número de contacto'"></span></div>
                        <div class="flex items-center gap-2 border-t border-gray-100 pt-2"><span>📑</span><span class="font-bold">Documento/Cédula:</span><span x-text="modalClient.dni || 'N/A'"></span></div>
                        <div class="flex items-center gap-2 border-t border-gray-100 pt-2"><span>🚀</span><span class="font-bold text-emerald-600">Plan Asignado:</span><span x-text="modalClient.plan || 'Sin plan'"></span></div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3 text-right">
                    <button @click="showModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold px-4 py-1.5 rounded transition">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ☁️ MODAL IMPORTAR CLIENTES -->
    <div id="modal-importacion" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-xl shadow-2xl border border-sky-200 max-w-lg w-full overflow-hidden">
            <div class="bg-[#0284c7] text-white px-5 py-3 flex items-center justify-between">
                <h3 class="font-bold text-sm">☁️ Importar Clientes desde archivo (CSV)</h3>
                <button type="button" onclick="document.getElementById('modal-importacion').classList.remove('flex'); document.getElementById('modal-importacion').classList.add('hidden');" class="text-white hover:text-red-200 text-lg font-bold">✕</button>
            </div>
            
            <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="text-xs text-gray-600 bg-sky-50 border border-sky-100 p-3 rounded-lg">
                    <strong class="text-sky-800">ℹ️ Instrucciones:</strong> Suba el archivo CSV con el listado de sus clientes para procesar e importar la información automáticamente.
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition relative">
                    <input type="file" name="csv_file" required accept=".csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="text-4xl mb-2">📁</div>
                    <span class="text-sm font-bold text-gray-700">Arrastre o presione aquí para seleccionar archivo .CSV</span>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="document.getElementById('modal-importacion').classList.remove('flex'); document.getElementById('modal-importacion').classList.add('hidden');" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold px-4 py-2 rounded transition">Cancelar</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2 rounded transition shadow-sm">🚀 Procesar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>