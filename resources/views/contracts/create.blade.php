<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Creación de Contrato</h2>
            <a href="{{ route('contracts.index') }}" class="text-xs text-gray-500 hover:text-gray-800 border px-3 py-1.5 rounded-lg bg-white shadow-sm">
                ← Volver a Contratos
            </a>
        </div>
    </x-slot>

    <!-- PESTAÑAS Y CONTENEDOR TIPO WISPRO -->
    <div x-data="{ 
            tab: 'basic', 
            selectedClientId: '', 
            clients: {{ json_encode($clients) }},
            get selectedClient() { 
                return this.clients.find(c => c.id == this.selectedClientId) || null; 
            } 
         }" 
         class="space-y-4">

        <!-- NAVEGACIÓN DE PESTAÑAS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 flex items-center gap-2">
            <button type="button" @click="tab = 'basic'" :class="tab === 'basic' ? 'bg-[#0284c7] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'" class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-2">
                🪪 Básico
            </button>
            <button type="button" @click="tab = 'billing'" :class="tab === 'billing' ? 'bg-[#0284c7] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'" class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-2">
                💵 Facturación
            </button>
            <button type="button" @click="tab = 'advanced'" :class="tab === 'advanced' ? 'bg-[#0284c7] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'" class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-2">
                ⚙️ Avanzado
            </button>
        </div>

        <form action="{{ route('contracts.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- COLUMNA IZQUIERDA: FORMULARIO -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                    
                    <!-- 📌 PESTAÑA 1: BÁSICO -->
                    <div x-show="tab === 'basic'" class="space-y-4 text-xs">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- CLIENTE -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">* Cliente</label>
                                <select name="client_id" x-model="selectedClientId" required class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="">Busque por nombre...</option>
                                    <template x-for="c in clients" :key="c.id">
                                        <option :value="c.id" x-text="c.name + ' (' + (c.dni || 'Sin Cédula') + ')'"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- PLAN -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">* Plan</label>
                                <select name="plan" required class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="FIBRA 100 MEGAS">FIBRA 100 MEGAS</option>
                                    <option value="FIBRA 200 MEGAS">FIBRA 200 MEGAS</option>
                                    <option value="RAPPIDO FAMILIAR">RAPPIDO FAMILIAR</option>
                                    <option value="PLAN BÁSICO">PLAN BÁSICO</option>
                                </select>
                            </div>

                            <!-- ESTADO -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">* Estado</label>
                                <select name="status" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="Habilitado">Habilitado</option>
                                    <option value="Cortado">Cortado</option>
                                    <option value="Suspendido">Suspendido</option>
                                </select>
                            </div>

                            <!-- 🖧 SERVIDOR (COMPLETAMENTE EN BLANCO HASTA VINCULAR) -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Servidor</label>
                                <select name="server" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 bg-gray-50">
                                    <option value="">-- No hay servidores vinculados --</option>
                                </select>
                            </div>

                            <!-- MODO DE CONEXIÓN -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Modo de Conexión</label>
                                <select name="connection_mode" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="PPPoE">PPPoE</option>
                                    <option value="Estática">Estática</option>
                                    <option value="DHCP">DHCP</option>
                                </select>
                            </div>

                            <!-- DIRECCIÓN IP -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Dirección IP</label>
                                <input type="text" name="ip_address" placeholder="Ej: 10.23.65.46" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 font-mono">
                            </div>

                            <!-- USER PPPoE -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Nombre de usuario PPPoE</label>
                                <input type="text" name="pppoe_username" placeholder="Usuario PPPoE" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <!-- PASS PPPoE -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Contraseña PPPoE</label>
                                <input type="text" name="pppoe_password" value="zte" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>
                        </div>

                        <!-- UBICACIÓN -->
                        <div class="border-t border-gray-100 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Calle / Barriada</label>
                                <input type="text" name="address" placeholder="Ej: Nuevo Tocumen, calle 87b" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Número de Casa / Local</label>
                                <input type="text" name="house_number" placeholder="Ej: Casa m345" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>
                        </div>
                    </div>

                    <!-- 📌 PESTAÑA 2: FACTURACIÓN -->
                    <div x-show="tab === 'billing'" class="space-y-4 text-xs" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">* Precio ($)</label>
                                <input type="number" step="0.01" name="price" value="30.00" required class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 font-bold text-emerald-600">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Frecuencia</label>
                                <select name="billing_frequency" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="Mensual">Mensual</option>
                                    <option value="Anual">Anual</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Estado de Facturación</label>
                                <select name="billing_status" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                                    <option value="Al día (sin mora)">Al día (sin mora)</option>
                                    <option value="En Mora">En Mora</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 📌 PESTAÑA 3: AVANZADO -->
                    <div x-show="tab === 'advanced'" class="space-y-4 text-xs" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Contraseña Wifi</label>
                                <input type="text" name="wifi_password" placeholder="Clave Wifi asignada" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Fecha de Alta</label>
                                <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                            </div>
                        </div>
                    </div>

                    <!-- BOTONES DE ACCIÓN -->
                    <div class="border-t border-gray-100 pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('contracts.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 text-xs transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-[#0284c7] hover:bg-sky-700 text-white font-bold text-xs shadow-sm transition">
                            🚀 Crear Contrato
                        </button>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: FICHA REACTIVA DEL CLIENTE -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 sticky top-4">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-2">
                        Información del Cliente
                    </h3>

                    <template x-if="!selectedClient">
                        <div class="text-center py-8 space-y-3">
                            <div class="w-12 h-12 bg-sky-50 rounded-full flex items-center justify-center mx-auto text-sky-500 text-xl font-bold">👤</div>
                            <h4 class="font-bold text-gray-700 text-xs">No hay Cliente Seleccionado</h4>
                            <p class="text-[11px] text-gray-400">Elija uno en el menú desplegable "Cliente" para cargar sus datos aquí.</p>
                        </div>
                    </template>

                    <template x-if="selectedClient">
                        <div class="space-y-3 text-xs">
                            <div class="bg-sky-50 p-3 rounded-lg border border-sky-100">
                                <p class="font-bold text-sky-900 text-sm" x-text="selectedClient.name"></p>
                                <p class="text-[11px] text-sky-700 mt-0.5">📑 Cédula/RUC: <span x-text="selectedClient.dni || 'N/A'"></span></p>
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <span class="font-bold text-gray-500 block">📱 Teléfono:</span>
                                    <span class="text-gray-800 font-medium" x-text="selectedClient.phone || 'Sin número'"></span>
                                </div>

                                <div>
                                    <span class="font-bold text-gray-500 block">📍 Dirección Registrada:</span>
                                    <span class="text-gray-800 font-medium" x-text="selectedClient.address || 'Sin dirección registrada'"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </form>

    </div>
</x-app-layout>