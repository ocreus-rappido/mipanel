@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Editar Contrato #{{ $contract->id }}</h1>

    <form action="{{ route('contracts.update', $contract->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md border space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-bold mb-1">Plan</label>
            <input type="text" name="plan_name" value="{{ old('plan_name', $contract->plan_name ?? $contract->plan) }}" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 font-bold mb-1">Precio ($)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $contract->price) }}" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('contracts.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection