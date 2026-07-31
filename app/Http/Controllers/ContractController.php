<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    // 📋 LISTADO Y BÚSQUEDA INSTANTÁNEA DE CONTRATOS
    public function index(Request $request)
    {
        $query = Contract::with('client');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $words = array_filter(explode(' ', $search));

            $query->where(function($q) use ($words) {
                foreach ($words as $word) {
                    $q->where(function($sub) use ($word) {
                        $sub->whereHas('client', function($c) use ($word) {
                            $c->where('name', 'LIKE', "%{$word}%")
                              ->orWhere('dni', 'LIKE', "%{$word}%")
                              ->orWhere('phone', 'LIKE', "%{$word}%");
                        })
                        ->orWhere('ip_address', 'LIKE', "%{$word}%")
                        ->orWhere('pppoe_username', 'LIKE', "%{$word}%")
                        ->orWhere('plan', 'LIKE', "%{$word}%")
                        ->orWhere('address', 'LIKE', "%{$word}%");
                    });
                }
            });
        }

        $perPage = (int) $request->get('per_page', 20);
        $contracts = $query->latest()->paginate($perPage)->withQueryString();

        // Contadores superiores
        $totalContracts = Contract::count();
        $activeContracts = Contract::where('status', 'Habilitado')->count();
        $cutoffContracts = Contract::where('status', 'Cortado')->count();

        return view('contracts.index', compact('contracts', 'totalContracts', 'activeContracts', 'cutoffContracts', 'perPage'));
    }

    // ➕ PANTALLA CREAR CONTRATO
    public function create()
    {
        $clients = Client::select('id', 'name', 'dni', 'phone', 'address')->orderBy('name', 'asc')->get();
        return view('contracts.create', compact('clients'));
    }

    // 💾 GUARDAR NUEVO CONTRATO
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'plan'      => 'required|string',
            'price'     => 'required|numeric',
        ]);

        Contract::create($request->all());

        return redirect()->route('contracts.index')->with('success', '🎉 ¡Contrato creado con éxito!');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('contracts.edit', compact('contract', 'clients'));
    }

    public function update(Request $request, Contract $contract)
    {
        $contract->update($request->all());
        return redirect()->route('contracts.index')->with('success', 'Contrato actualizado correctamente.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contrato eliminado.');
    }
}