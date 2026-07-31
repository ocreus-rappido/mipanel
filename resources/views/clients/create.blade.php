<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                ➕ Registrar Nuevo Cliente
            </h2>
            <span class="text-xs text-gray-400">Inicio / Clientes / Crear</span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-4">
        <!-- El evento onsubmit valida que los datos obligatorios estén listos antes de enviar -->
        <form action="{{ route('clients.store') }}" method="POST" onsubmit="return validateForm()">
            @csrf

            <!-- NAVEGACIÓN SUPERIOR ESTILO PESTAÑAS -->
            <div class="bg-white rounded-t-xl border-b border-gray-200 flex items-center text-xs font-semibold text-gray-600 shadow-sm overflow-x-auto">
                <button type="button" class="px-6 py-3 border-l-4 border-[#0284c7] text-[#0284c7] bg-gray-50/50 flex items-center gap-2 font-bold">
                    👤 Básico y Servicios
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start mt-4">

                <!-- COLUMNA IZQUIERDA: DATOS OBLIGATORIOS Y SERVICIOS -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 space-y-4">
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2">Información Principal <span class="text-rose-500 font-normal ml-1">(* Obligatorio)</span></h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Tipo de Persona</label>
                            <select class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                                <option>Natural (Cédula)</option>
                                <option>Jurídica (RUC Comercial)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Nombre Completo / Razón Social</label>
                            <input type="text" name="name" id="client_name" required placeholder="Ej: Orlando Creus" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Cédula / RUC</label>
                            <input type="text" name="dni" id="client_dni" required placeholder="Ej: 8-800-1234" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Teléfono Móvil</label>
                            <input type="text" name="phone" placeholder="+507 6000-0000" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Dirección IP Asignada</label>
                            <input type="text" name="ip_address" required placeholder="192.168.1.50" class="w-full text-xs font-mono rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Plan de Internet</label>
                            <input type="text" name="plan" required placeholder="Ej: 200 Megas Fibra" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                    </div>

                    <!-- ASIGNACIÓN DE ROLES (VENDEDOR Y RECAUDADOR) -->
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2 pt-2">Asignación de Personal de Plataforma</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Vendedor Oficial</label>
                            <select name="last_edited_by" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                                <option value="{{ Auth::user()->name ?? 'Admin' }}">Yo ({{ Auth::user()->name ?? 'Admin' }})</option>
                                <option value="Vendedor 1">Vendedor 1</option>
                                <option value="Vendedor 2">Vendedor 2</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Recaudador Asignado</label>
                            <select name="last_payment_by" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                                <option value="">Sin asignar / Pendiente</option>
                                <option value="{{ Auth::user()->name ?? 'Admin' }}">Yo ({{ Auth::user()->name ?? 'Admin' }})</option>
                                <option value="Caja Principal">Caja Principal</option>
                            </select>
                        </div>
                    </div>

                    <!-- EQUIPOS TV / CÁMARAS -->
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2 pt-2">Equipos y Servicios Adicionales</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="has_tv_box" value="1" id="tvbox" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <label for="tvbox" class="text-xs font-semibold text-gray-700">Decodificador TV Box</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="has_cameras" value="1" id="cam" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <label for="cam" class="text-xs font-semibold text-gray-700">Cámaras de Seguridad</label>
                        </div>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: MAPA GPS Y COMENTARIOS -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 space-y-4">
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2">Ubicación GPS y Google Maps</h3>

                    <!-- MAPA INTEGRADO (Centrado en Darién/Panamá) -->
                    <div class="w-full h-48 rounded-lg overflow-hidden border border-gray-300 shadow-sm">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d252445.6983088219!2d-78.14605929285093!3d8.406981881678144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spa!4v1700000000000!5m2!1ses-419!2spa" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Dirección Física / Calle</label>
                            <input type="text" name="address" placeholder="Wacuco, Darién" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Agendar Visita Técnica</label>
                            <input type="datetime-local" name="tech_visit_at" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Comentarios / Observaciones de Instalación</label>
                        <textarea name="comments" rows="5" placeholder="Escriba notas de instalación, especificaciones del router, detalles de facturación..." class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm"></textarea>
                    </div>

                </div>

            </div>

            <!-- BOTONES DE ACCIÓN (Se deshabilitan si faltan campos obligatorios) -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 mt-6">
                <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded shadow-sm">
                    Cancelar
                </a>
                <button type="submit" id="btn-submit" class="px-6 py-2 bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold rounded shadow-sm">
                    💾 Guardar Cliente
                </button>
            </div>
        </form>
    </div>

    <script>
        // Validación en Front-End para obligar a llenar Cédula y Nombre
        function validateForm() {
            let name = document.getElementById('client_name').value.trim();
            let dni = document.getElementById('client_dni').value.trim();
            
            if (name === '' || dni === '') {
                alert('⚠️ El Nombre y la Cédula/RUC son obligatorios. Por favor complételos antes de guardar.');
                return false; // Bloquea el envío del formulario
            }
            return true; // Permite guardar
        }
    </script>
</x-app-layout>