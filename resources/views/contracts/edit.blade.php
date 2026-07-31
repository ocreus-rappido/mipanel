<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Editar Contrato
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('contracts.update', $contract) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Cliente *</label>
                            <select name="client_id" class="w-full border-gray-300 rounded-lg p-2" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $contract->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Plan *</label>
                            <input type="text" name="plan" value="{{ old('plan', $contract->plan) }}" class="w-full border-gray-300 rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Precio (B/.) *</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $contract->price) }}" class="w-full border-gray-300 rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Contraseña Wi-Fi</label>
                            <input type="text" name="wifi_password" value="{{ old('wifi_password', $contract->wifi_password) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('contracts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
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