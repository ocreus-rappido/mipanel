<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👤 Cliente: {{ $client->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clients.edit', $client) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    ✏️ Editar Cliente
                </a>
                <a href="{{ route('clients.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    ⬅️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Información General del Cliente -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📌 Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Nombre Completo</span>
                        <span class="text-gray-800 font-semibold">{{ $client->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">E-mail</span>
                        <span class="text-gray-800 font-semibold">{{ $client->email ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Cédula / RUC</span>
                        <span class="text-gray-800 font-semibold">{{ $client->id_card ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Teléfono Fijo</span>
                        <span class="text-gray-800 font-semibold">{{ $client->phone ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Teléfono Celular</span>
                        <span class="text-gray-800 font-semibold">{{ $client->mobile_phone ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Zona</span>
                        <span class="text-gray-800 font-semibold">{{ $client->zone ?? 'N/A' }}</span>
                    </div>
                    <div class="md:col-span-3">
                        <span class="text-xs text-gray-500 uppercase font-bold block">Dirección</span>
                        <span class="text-gray-800 font-semibold">{{ $client->address ?? 'N/A' }}</span>
                    </div>
                    <div class="md:col-span-3">
                        <span class="text-xs text-gray-500 uppercase font-bold block">Observaciones</span>
                        <span class="text-gray-800 font-semibold">{{ $client->observations ?? 'Sin observaciones' }}</span>
                    </div>
                </div>
            </div>

            <!-- Servicios Adicionales -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📺 Servicios y Equipos Adicionales</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded border">
                        <span class="text-xs text-gray-500 uppercase font-bold block">Servicio de TV</span>
                        <span class="text-gray-800 font-bold text-md">{{ $client->tv_services ?? 'Ninguno' }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded border">
                        <span class="text-xs text-gray-500 uppercase font-bold block">Cámaras de Seguridad</span>
                        <span class="text-gray-800 font-bold text-md">{{ $client->cameras ?? 'Ninguna' }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded border">
                        <span class="text-xs text-gray-500 uppercase font-bold block">Equipos Móviles</span>
                        <span class="text-gray-800 font-bold text-md">{{ $client->mobile_equipment ?? 'Ninguno' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>