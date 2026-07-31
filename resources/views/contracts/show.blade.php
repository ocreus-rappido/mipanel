<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📜 Detalle del Contrato #{{ $contract->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('contracts.edit', $contract) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    ✏️ Editar Contrato
                </a>
                <a href="{{ route('contracts.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    ⬅️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📋 Información del Contrato</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Cliente Asignado</span>
                        <a href="{{ route('clients.show', $contract->client_id) }}" class="text-blue-600 font-bold hover:underline">
                            {{ $contract->client->name ?? 'Cliente Desconocido' }} 👤
                        </a>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Plan Contratado</span>
                        <span class="text-gray-800 font-semibold">{{ $contract->plan }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Precio Mensual</span>
                        <span class="text-gray-800 font-semibold">B/. {{ number_format($contract->price, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Contraseña Wi-Fi</span>
                        <span class="text-gray-800 font-semibold">{{ $contract->wifi_password ?? 'No registrada' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold block">Estado</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $contract->status ?? 'Habilitado' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>