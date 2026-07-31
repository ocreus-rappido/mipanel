<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'comments')) {
                $table->text('comments')->nullable();
            }
            if (!Schema::hasColumn('clients', 'last_edited_by')) {
                $table->string('last_edited_by')->nullable();
            }
            if (!Schema::hasColumn('clients', 'last_payment_by')) {
                $table->string('last_payment_by')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['comments', 'last_edited_by', 'last_payment_by']);
        });
    }
};