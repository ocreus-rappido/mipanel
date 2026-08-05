<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                👥 {{ __('Clientes') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow text-sm transition">
                + Crear nuevo Cliente
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 🔍 BUSCADOR EN TIEMPO REAL CON DESPLEGABLE -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 relative">
                <div class="relative w-full md:w-1/2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" 
                           id="global-db-search" 
                           autocomplete="off"
                           class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                           placeholder="Buscar en BD por nombre, cédula, teléfono, IP o serial...">
                    
                    <!-- Indicador de Carga -->
                    <div id="search-spinner" class="hidden absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <!-- 📜 MENÚ DESPLEGABLE DE RESULTADOS -->
                <div id="search-results-dropdown" class="hidden absolute left-4 right-4 md:right-auto md:w-1/2 mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden divide-y divide-gray-100 max-h-96 overflow-y-auto">
                </div>
            </div>

            <!-- 📋 TABLA PRINCIPAL DE CLIENTES -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100 mt-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Cédula / RUC</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Zona</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="clients-table-body" class="bg-white divide-y divide-gray-200">
                            @forelse ($clients as $client)
                                <tr class="client-row hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $client->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $client->document ?? $client->cedula ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $client->phone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $client->zone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-3">
                                        <a href="{{ route('clients.show', $client) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-full transition" title="Ver Detalle">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" class="text-orange-400 hover:text-orange-600 bg-orange-50 p-2 rounded-full transition" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">No hay clientes registrados aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($clients, 'links'))
                    <div class="p-4 bg-white border-t border-gray-100">
                        {{ $clients->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- ⚡ SCRIPT DE BÚSQUEDA ASÍNCRONA A LA BASE DE DATOS -->
    <script>
        let debounceTimer;
        const searchInput = document.getElementById('global-db-search');
        const dropdown = document.getElementById('search-results-dropdown');
        const spinner = document.getElementById('search-spinner');

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            if (query.length < 2) {
                dropdown.classList.add('hidden');
                dropdown.innerHTML = '';
                return;
            }

            spinner.classList.remove('hidden');

            // Debounce de 300ms para evitar saturar el servidor al escribir
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('clients.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(clients => {
                        spinner.classList.add('hidden');
                        dropdown.innerHTML = '';

                        if (clients.length === 0) {
                            dropdown.innerHTML = `
                                <div class="p-4 text-sm text-gray-500 text-center font-medium">
                                    No se encontraron coincidencias para "${query}".
                                </div>`;
                        } else {
                            clients.forEach(client => {
                                const doc = client.document || client.cedula || 'Sin cédula';
                                const phone = client.phone || 'Sin tel.';
                                const contract = client.contracts && client.contracts.length > 0 ? client.contracts[0] : null;
                                const extraInfo = contract ? ` | IP: ${contract.ip_address || 'N/A'} | Serial: ${contract.device_serial || 'N/A'}` : '';

                                const item = document.createElement('a');
                                item.href = `/clients/${client.id}`;
                                item.className = 'block p-3 hover:bg-blue-50 transition cursor-pointer';
                                item.innerHTML = `
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">${client.name}</p>
                                            <p class="text-xs text-gray-500">📄 ${doc} | 📞 ${phone} ${extraInfo}</p>
                                        </div>
                                        <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-2 py-1 rounded-full">Ver cliente →</span>
                                    </div>
                                `;
                                dropdown.appendChild(item);
                            });
                        }
                        dropdown.classList.remove('hidden');
                    })
                    .catch(() => {
                        spinner.classList.add('hidden');
                    });
            }, 300);
        });

        // Ocultar menú si se hace clic fuera del buscador
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>