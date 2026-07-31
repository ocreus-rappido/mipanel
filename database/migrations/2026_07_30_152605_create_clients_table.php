<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('clients', function (Blueprint $table) {
    $table->id();
    $table->string('name');              // Nombre completo
    $table->string('dni')->nullable();   // Cédula o Documento
    $table->string('phone')->nullable(); // Teléfono
    $table->string('address')->nullable(); // Dirección
    $table->string('ip_address');        // Dirección IP
    $table->string('plan');              // Plan contratado
    $table->boolean('status')->default(true); // Activo (true) / Cortado (false)
    $table->timestamps();
});   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
