<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // 📋 LISTADO, BÚSQUEDA Y ORDENAMIENTO DE CLIENTES
    public function index(Request $request)
    {
        $query = Client::query();

        // 🔍 Búsqueda inteligente
        if ($request->filled('search')) {
            $search = trim($request->search);
            $words = array_filter(explode(' ', $search));

            $query->where(function($q) use ($words) {
                foreach ($words as $word) {
                    $q->where(function($sub) use ($word) {
                        $sub->where('name', 'LIKE', "%{$word}%")
                            ->orWhere('dni', 'LIKE', "%{$word}%")
                            ->orWhere('ip_address', 'LIKE', "%{$word}%")
                            ->orWhere('phone', 'LIKE', "%{$word}%")
                            ->orWhere('address', 'LIKE', "%{$word}%")
                            ->orWhere('comments', 'LIKE', "%{$word}%");
                    });
                }
            });
        }

        // 🔃 Ordenamiento por Columna (A-Z, Z-A, ID)
        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'asc');

        if (in_array($sortBy, ['id', 'name', 'dni', 'ip_address'])) {
            $query->orderBy($sortBy, $sortDir === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('id', 'asc');
        }

        // 📄 Cantidad de Clientes por Página (20, 50, 100, 500)
        $perPage = (int) $request->get('per_page', 20);
        if (!in_array($perPage, [20, 50, 100, 500])) {
            $perPage = 20;
        }

        $clients = $query->paginate($perPage)->withQueryString();

        return view('clients.index', compact('clients', 'sortBy', 'sortDir', 'perPage'));
    }

    public function create() { return view('clients.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'dni' => 'required', 'ip_address' => 'required', 'plan' => 'required']);
        $client = new Client();
        $this->saveClientData($client, $request);
        return redirect()->route('clients.index')->with('success', 'Cliente creado con éxito');
    }

    public function show(Client $client) { return view('clients.show', compact('client')); }
    public function edit(Client $client) { return view('clients.edit', compact('client')); }

    public function update(Request $request, Client $client)
    {
        $request->validate(['name' => 'required', 'dni' => 'required', 'ip_address' => 'required', 'plan' => 'required']);
        $this->saveClientData($client, $request);
        return redirect()->route('clients.index')->with('success', 'Datos actualizados correctamente');
    }

    private function saveClientData(Client $client, Request $request)
    {
        $client->name = $request->name;
        $client->dni = $request->dni;
        $client->ip_address = $request->ip_address;
        $client->plan = $request->plan;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->comments = $request->comments;
        $client->last_edited_by = $request->last_edited_by ?? (Auth::user()->name ?? 'Sistema');
        $client->last_payment_by = $request->last_payment_by;
        
        $client->has_tv_box = $request->has('has_tv_box');
        $client->tv_box_count = $request->has('has_tv_box') ? ($request->tv_box_count ?? 1) : 0;
        $client->has_android_tv = $request->has('has_android_tv');
        $client->android_tv_count = $request->has('has_android_tv') ? ($request->android_tv_count ?? 1) : 0;
        $client->has_cameras = $request->has('has_cameras');
        $client->camera_count = $request->has('has_cameras') ? ($request->camera_count ?? 1) : 0;
        $client->has_tv_app = $request->has('has_tv_app');
        $client->save();
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado');
    }

    // 📥 EXPORTAR CLIENTES A CSV
    public function export()
    {
        $clients = Client::all();
        $fileName = 'clientes_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID CLIENTE', 'ID PERSONALIZABLE', 'NOMBRE', 'OBSERVACIONES', 'EMAIL', 'TELÉFONO', 'TELÉFONO CELULAR', 'DIRECCIÓN', 'BARRIO', 'ZONA', 'DATO ADICIONAL', 'DOCUMENTO/CÉDULA', 'CIUDAD', 'PROVINCIA/ESTADO/REGION', 'FACTURACIÓN HABILITADA', 'TIPO DE FACTURA', 'CONDICIÓN IMPOSITIVA', 'CREADO EL', 'VENDEDOR', 'RECAUDADOR'];

        $callback = function() use($clients, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, (chr(0xEF) . chr(0xBB) . chr(0xBF))); 
            fputcsv($file, $columns, ',');

            foreach ($clients as $client) {
                $email = strtolower(str_replace(' ', '', $client->name)) . '@gmail.com';
                fputcsv($file, [
                    $client->id, 'CL-22-' . (100 + $client->id), $client->name, $client->comments, $email, $client->phone, $client->phone, $client->address, '', 'Tocumen', '', $client->dni, 'Panamá', 'Provincia de Panamá', 'Si', 'Comprobante', 'Fantasía', $client->created_at ? $client->created_at->format('d/m/Y H:i:s') : '', $client->last_edited_by, $client->last_payment_by
                ], ',');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 📤 IMPORTAR CLIENTES DESDE CSV
    public function import(Request $request)
    {
        $request->validate(['csv_file' => 'required|mimes:csv,txt|max:10240']);
        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), "r");
        fgetcsv($handle, 1000, ","); 
        
        $imported = 0;
        while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
            if (!isset($data[2]) || empty($data[2])) continue;

            $rawAddress = $data[7] ?? null;
            $cleanAddress = $rawAddress ? mb_substr(trim($rawAddress), 0, 1000) : null;

            Client::firstOrCreate(
                ['dni' => $data[11] ?? 'Sin DNI ' . uniqid()],
                [
                    'name'            => $data[2] ?? 'Sin Nombre',
                    'phone'           => $data[5] ?? null,
                    'address'         => $cleanAddress,
                    'comments'        => $data[3] ?? null,
                    'last_edited_by'  => $data[25] ?? 'Importación Wispro',
                    'last_payment_by' => $data[26] ?? null,
                    'ip_address'      => 'Por Asignar',
                    'plan'            => 'Plan Básico',
                ]
            );
            $imported++;
        }
        fclose($handle);

        return redirect()->route('clients.index')->with('success', "$imported clientes importados exitosamente.");
    }
}