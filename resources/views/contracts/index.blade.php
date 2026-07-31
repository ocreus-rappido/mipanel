<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sky-600 text-xl font-bold">📄</span>
                <h2 class="text-2xl font-bold text-gray-800">Contratos / Servicios</h2>
                <span class="text-xs text-gray-400 font-normal ml-1">Inicio / Contratos</span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('contracts.create') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-semibold px-4 py-2 rounded shadow-sm transition flex items-center gap-1">
                    <span class="text-sm font-bold">+</span> Crear nuevo Contrato
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-4">
        
        <!-- 📊 CONTADORES RÁPIDOS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-sky-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400">Total Contratos</p>
                    <h3 class="text-2xl font-extrabold text-sky-700 mt-1">{{ $totalContracts }}</h3>
                </div>
                <div class="w-10 h-10 bg-sky-50 rounded-full flex items-center justify-center text-sky-600 font-bold text-lg">📑</div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400">Habilitados (En Línea)</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $activeContracts }}</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 font-bold text-lg">⚡</div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-rose-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400">Suspendidos / Cortados</p>
                    <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ $cutoffContracts }}</h3>
                </div>
                <div class="w-10 h-10 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 font-bold text-lg">🔒</div>
            </div>
        </div>

        <!-- 🔍 BARRA DE BÚSQUEDA INSTANTÁNEA -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('contracts.index') }}" method="GET" onsubmit="return false;">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sky-500 text-sm">🔍</span>
                    <input type="text" 
                           id="live-contract-search" 
                           oninput="filterContractsTable()" 
                           placeholder="Buscar por: Nombre de Cliente, Cédula, Plan, IP o Usuario PPPoE..." 
                           class="w-full pl-11 pr-4 py-2.5 text-xs rounded-full border-gray-200 focus:border-sky-500 focus:ring-sky-500 shadow-sm text-gray-700 font-medium">
                </div>
            </form>
        </div>

        <!-- 📋 TABLA DE CONTRATOS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto" style="max-height: 650px;">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-gray-50/80 border-b border-gray-100 text-gray-500 font-bold sticky top-0 z-10 backdrop-blur-sm">
                        <tr>
                            <th class="px-4 py-3"># ID / Cliente</th>
                            <th class="px-4 py-3">Plan / Servidor</th>
                            <th class="px-4 py-3">IP / Credenciales</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="contracts-table-body" class="divide-y divide-gray-100">
                        @forelse($contracts as $contract)
                            <tr class="contract-row hover:bg-sky-50/50 transition">
                                <td class="px-4 py-4">
                                    <span class="text-xs font-bold text-sky-700">#{{ $contract->id }}</span>
                                    <div class="font-bold text-gray-800 text-sm mt-0.5">{{ $contract->client->name ?? 'Cliente sin asignar' }}</div>
                                    <div class="text-[11px] text-gray-400 mt-0.5">📍 {{ $contract->address ?? $contract->client->address ?? 'Sin dirección' }}</div>
                                </td>

                                <td class="px-4 py-4 space-y-1">
                                    <div class="font-bold text-emerald-600">🚀 {{ $contract->plan }}</div>
                                    <div class="text-[11px] text-gray-500">🖥️ {{ $contract->server ?? 'MIKROTIK TOCUMEN' }}</div>
                                    <div class="text-[10px] text-gray-400">💵 ${{ number_format($contract->price, 2) }} / {{ $contract->billing_frequency }}</div>
                                </td>

                                <td class="px-4 py-4 space-y-1 font-mono text-[11px]">
                                    <div class="text-sky-700 font-bold">🌐 IP: {{ $contract->ip_address ?? 'Auto / DHCP' }}</div>
                                    <div class="text-gray-500">👤 User: {{ $contract->pppoe_username ?? 'N/A' }}</div>
                                    <div class="text-gray-400">🔑 Pass: {{ $contract->pppoe_password ?? '***' }}</div>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $contract->status == 'Habilitado' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $contract->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex items-center gap-1 bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
                                        <a href="{{ route('contracts.show', $contract->id) }}" class="p-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded text-xs transition">🔍</a>
                                        <a href="{{ route('contracts.edit', $contract->id) }}" class="p-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded text-xs transition">✏️</a>
                                        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Borrar contrato?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-gray-100 hover:bg-red-500 hover:text-white text-gray-600 rounded text-xs transition">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">No hay contratos registrados. Haga clic en "+ Crear nuevo Contrato".</td>
                            </tr>
                        @endforelse

                        <tr id="empty-contract-search" style="display: none;">
                            <td colspan="5" class="px-4 py-8 text-center text-rose-500 font-bold">
                                No se encontraron contratos con esa coincidencia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-white border-t border-gray-100">
                {{ $contracts->links() }}
            </div>
        </div>

    </div>

    <!-- ⚡ SCRIPT BÚSQUEDA INSTANTÁNEA -->
    <script>
        function filterContractsTable() {
            const input = document.getElementById('live-contract-search');
            const searchTerms = input.value.toLowerCase().trim().split(' ').filter(term => term.length > 0);
            const rows = document.querySelectorAll('#contracts-table-body tr.contract-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const matchesAll = searchTerms.every(term => text.includes(term));

                if (matchesAll || searchTerms.length === 0) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const emptyRow = document.getElementById('empty-contract-search');
            if (visibleCount === 0 && searchTerms.length > 0) {
                emptyRow.style.display = '';
            } else {
                emptyRow.style.display = 'none';
            }
        }
    </script>
</x-app-layout>