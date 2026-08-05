<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Muestra el listado de contratos y sus métricas principales.
     */
    public function index()
    {
        // Paginación activa para ser compatible con $contracts->links()
        $contracts = Contract::with('client')->latest()->paginate(10);

        $totalContracts  = Contract::count();
        $activeContracts = Contract::whereIn('status', ['active', 'habilitado', 'Activo'])->count();
        $cutoffContracts = Contract::whereIn('status', ['suspended', 'cortado', 'Suspendido', 'Cortado', 'inactive'])->count();

        return view('contracts.index', compact('contracts', 'totalContracts', 'activeContracts', 'cutoffContracts'));
    }

    /**
     * Muestra el formulario para crear un nuevo contrato.
     */
    public function create()
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('contracts.create', compact('clients'));
    }

    /**
     * Almacena un nuevo contrato en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'     => 'required|exists:clients,id',
            'plan_name'     => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'wifi_password' => 'nullable|string|max:255',
            'billing_zone'  => 'nullable|string|in:darien,panama',
            'status'        => 'required|string',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')->with('success', '🎉 ¡Contrato creado con éxito!');
    }

    /**
     * Muestra la vista detallada de un contrato.
     */
    public function show(Contract $contract)
    {
        $contract->load(['client', 'invoices']);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Muestra el formulario de edición de un contrato.
     */
    public function edit(Contract $contract)
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('contracts.edit', compact('contract', 'clients'));
    }

    /**
     * Actualiza la información del contrato.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'client_id'     => 'sometimes|exists:clients,id',
            'plan_name'     => 'nullable|string|max:255',
            'price'         => 'nullable|numeric|min:0',
            'wifi_password' => 'nullable|string|max:255',
            'billing_zone'  => 'nullable|string|in:darien,panama',
            'status'        => 'nullable|string',
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.index')->with('success', '¡Contrato actualizado con éxito!');
    }

    /**
     * Elimina un contrato del sistema.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrato eliminado correctamente.');
    }
}