<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'has_tv_box')) $table->boolean('has_tv_box')->default(false);
            if (!Schema::hasColumn('clients', 'tv_box_count')) $table->integer('tv_box_count')->default(0);
            if (!Schema::hasColumn('clients', 'has_android_tv')) $table->boolean('has_android_tv')->default(false);
            if (!Schema::hasColumn('clients', 'android_tv_count')) $table->integer('android_tv_count')->default(0);
            if (!Schema::hasColumn('clients', 'has_cameras')) $table->boolean('has_cameras')->default(false);
            if (!Schema::hasColumn('clients', 'camera_count')) $table->integer('camera_count')->default(0);
            if (!Schema::hasColumn('clients', 'has_tv_app')) $table->boolean('has_tv_app')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'has_tv_box', 'tv_box_count', 'has_android_tv', 
                'android_tv_count', 'has_cameras', 'camera_count', 'has_tv_app'
            ]);
        });
    }
};