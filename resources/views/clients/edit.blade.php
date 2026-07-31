<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-2xl">✏️</span>
                <h2 class="text-2xl font-bold text-gray-800">
                    Editar Cliente: <span class="text-[#0284c7]">{{ $client->name }}</span>
                </h2>
                <span class="text-xs text-gray-400 font-normal ml-2">Inicio / Clientes / Editar</span>
            </div>

            <a href="{{ route('clients.index') }}" class="bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold px-4 py-2 rounded shadow-sm flex items-center gap-1 transition">
                ⬅️ Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-4">
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start mt-4">

                <!-- COLUMNA IZQUIERDA -->
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
                            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Cédula / RUC</label>
                            <input type="text" name="dni" value="{{ old('dni', $client->dni) }}" required class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Teléfono Móvil</label>
                            <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Dirección IP Asignada</label>
                            <input type="text" name="ip_address" value="{{ old('ip_address', $client->ip_address) }}" required class="w-full text-xs font-mono rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">*Plan de Internet</label>
                            <input type="text" name="plan" value="{{ old('plan', $client->plan) }}" required class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm border-l-4 border-l-rose-500">
                        </div>
                    </div>

                    <!-- ROLES Y ASIGNACIÓN -->
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2 pt-2">Asignación de Vendedor y Recaudador</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Vendedor / Responsable</label>
                            <input type="text" name="last_edited_by" value="{{ old('last_edited_by', $client->last_edited_by) }}" placeholder="Nombre del vendedor" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Recaudador Asignado</label>
                            <input type="text" name="last_payment_by" value="{{ old('last_payment_by', $client->last_payment_by) }}" placeholder="Ej: Caja Principal" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                        </div>
                    </div>

                    <!-- 📦 EQUIPOS Y SERVICIOS ADICIONALES -->
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2 pt-2">Equipos y Servicios Adicionales</h3>
                    
                    <div class="space-y-3 bg-gray-50/70 p-3.5 rounded-xl border border-gray-200">
                        <!-- 1. TV BOX -->
                        <div class="grid grid-cols-2 gap-4 items-center">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="has_tv_box" value="1" id="tvbox" {{ $client->has_tv_box ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                                <label for="tvbox" class="text-xs font-semibold text-gray-700 cursor-pointer">📺 Decodificador TV Box</label>
                            </div>
                            <div>
                                <input type="number" name="tv_box_count" min="1" value="{{ $client->tv_box_count > 0 ? $client->tv_box_count : 1 }}" placeholder="Cantidad TV Box" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                            </div>
                        </div>

                        <!-- 2. TV ANDROID -->
                        <div class="grid grid-cols-2 gap-4 items-center border-t border-gray-200/60 pt-2.5">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="has_android_tv" value="1" id="androidtv" {{ $client->has_android_tv ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                                <label for="androidtv" class="text-xs font-semibold text-gray-700 cursor-pointer">🤖 TV Android / Smart TV</label>
                            </div>
                            <div>
                                <input type="number" name="android_tv_count" min="1" value="{{ $client->android_tv_count > 0 ? $client->android_tv_count : 1 }}" placeholder="Cantidad TV Android" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                            </div>
                        </div>

                        <!-- 3. CÁMARAS DE SEGURIDAD -->
                        <div class="grid grid-cols-2 gap-4 items-center border-t border-gray-200/60 pt-2.5">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="has_cameras" value="1" id="cam" {{ $client->has_cameras ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                                <label for="cam" class="text-xs font-semibold text-gray-700 cursor-pointer">📹 Cámaras de Seguridad</label>
                            </div>
                            <div>
                                <input type="number" name="camera_count" min="1" value="{{ $client->camera_count > 0 ? $client->camera_count : 1 }}" placeholder="Cantidad Cámaras" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                            </div>
                        </div>

                        <!-- 4. APLICACIÓN DE TV MÓVIL -->
                        <div class="flex items-center gap-2 border-t border-gray-200/60 pt-2.5">
                            <input type="checkbox" name="has_tv_app" value="1" id="tvapp" {{ $client->has_tv_app ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <label for="tvapp" class="text-xs font-semibold text-gray-700 cursor-pointer">📱 Aplicación de TV Móvil</label>
                        </div>
                    </div>

                </div>

                <!-- COLUMNA DERECHA -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 space-y-4">
                    <h3 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-2">Ubicación y Referencias</h3>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Dirección Física / Calle</label>
                        <input type="text" name="address" value="{{ old('address', $client->address) }}" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Comentarios / Observaciones Extensas</label>
                        <textarea name="comments" rows="6" class="w-full text-xs rounded border-gray-300 focus:border-sky-500 focus:ring-sky-500 shadow-sm">{{ old('comments', $client->comments) }}</textarea>
                    </div>

                </div>

            </div>

            <!-- BOTONES -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 mt-6">
                <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded shadow-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-[#0284c7] hover:bg-sky-700 text-white text-xs font-bold rounded shadow-sm transition">
                    💾 Actualizar Datos
                </button>
            </div>
        </form>
    </div>
</x-app-layout>