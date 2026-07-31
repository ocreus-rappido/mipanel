<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Editar Cliente: {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📌 Datos Personales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Nombre Completo *</label>
                            <input type="text" name="name" value="{{ old('name', $client->name) }}" class="w-full border-gray-300 rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">E-mail</label>
                            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Cédula / RUC</label>
                            <input type="text" name="id_card" value="{{ old('id_card', $client->id_card) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Teléfono Fijo</label>
                            <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Teléfono Celular</label>
                            <input type="text" name="mobile_phone" value="{{ old('mobile_phone', $client->mobile_phone) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Zona</label>
                            <input type="text" name="zone" value="{{ old('zone', $client->zone) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-gray-700 font-bold mb-1">Dirección</label>
                            <input type="text" name="address" value="{{ old('address', $client->address) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-gray-700 font-bold mb-1">Observaciones</label>
                            <textarea name="observations" rows="2" class="w-full border-gray-300 rounded-lg p-2">{{ old('observations', $client->observations) }}</textarea>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📺 Servicios y Equipos Adicionales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-gray-50 p-4 rounded-lg border">
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Servicio de TV</label>
                            <input type="text" name="tv_services" value="{{ old('tv_services', $client->tv_services) }}" class="w-full border-gray-300 rounded-lg p-2" placeholder="Ej. Plan Full HD">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Cámaras de Seguridad</label>
                            <input type="text" name="cameras" value="{{ old('cameras', $client->cameras) }}" class="w-full border-gray-300 rounded-lg p-2" placeholder="Ej. 2 Cámaras Exterior">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Equipos Móviles</label>
                            <input type="text" name="mobile_equipment" value="{{ old('mobile_equipment', $client->mobile_equipment) }}" class="w-full border-gray-300 rounded-lg p-2" placeholder="Ej. Router SIM 4G">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('clients.show', $client) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>