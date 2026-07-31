<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('client')->latest()->paginate(20);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('contracts.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'plan' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'nullable|string',
            'wifi_password' => 'nullable|string',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')->with('success', 'Contrato creado con éxito.');
    }

    public function show(Contract $contract)
    {
        $contract->load('client');
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('contracts.edit', compact('contract', 'clients'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'plan' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'nullable|string',
            'wifi_password' => 'nullable|string',
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.index')->with('success', 'Contrato actualizado con éxito.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrato eliminado con éxito.');
    }
}