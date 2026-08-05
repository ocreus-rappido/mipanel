<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // La columna ya existe en Railway, no se ejecuta ningún comando SQL.
    }

    public function down(): void
    {
        //
    }
};