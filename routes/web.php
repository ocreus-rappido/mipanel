<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;

Route::get('/', function () {
    return redirect()->route('clients.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes
    Route::get('/clients/export', [ClientController::class, 'export'])->name('clients.export');
    Route::post('/clients/import', [ClientController::class, 'import'])->name('clients.import');
    Route::resource('clients', ClientController::class);

    // Contratos
    Route::resource('contracts', ContractController::class);
});

require __DIR__.'/auth.php';