<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            
            // Datos Básicos
            $table->string('plan')->default('RAPPIDO FAMILIAR');
            $table->string('status')->default('Habilitado'); // Habilitado, Cortado, Pendiente
            $table->string('server')->nullable()->default('MIKROTIK TOCUMEN');
            $table->string('vlan')->nullable()->default('1015');
            $table->string('connection_mode')->default('PPPoE'); // PPPoE, Estática, DHCP
            
            // Red y Credenciales
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->string('ppp_profile')->nullable()->default('wispro');
            $table->string('pppoe_server')->nullable()->default('tocumen');

            // Equipos (OLT / NAP)
            $table->string('technology')->default('OLT'); // Cable Modem, OLT
            $table->string('onu_id')->nullable();
            $table->string('nap')->nullable();
            $table->string('nap_port')->nullable();

            // Ubicación
            $table->text('address')->nullable();
            $table->string('house_number')->nullable();
            $table->string('city')->default('Panamá');
            $table->string('province')->default('Panamá');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Facturación
            $table->decimal('price', 8, 2)->default(30.00);
            $table->string('billing_frequency')->default('Mensual');
            $table->string('billing_status')->default('Al día (sin mora)');
            $table->date('start_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};