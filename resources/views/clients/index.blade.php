<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Clientes
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    + Crear nuevo Cliente
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula / RUC</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zona</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                    {{ $client->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $client->id_card ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $client->mobile_phone ?? $client->phone ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $client->zone ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                    <!-- 🔍 Ver Cliente -->
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900 text-lg" title="Ver Cliente">
                                        🔍
                                    </a>

                                    <!-- ✏️ Editar Cliente -->
                                    <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 text-lg" title="Editar Cliente">
                                        ✏️
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No hay clientes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $clients->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>