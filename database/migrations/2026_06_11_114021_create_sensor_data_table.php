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
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
            $table->float('suhu');
            $table->float('ph');
            $table->float('kekeruhan');
            
            // Tambahkan ->nullable() di sini
            $table->string('status_suhu')->nullable();
            $table->string('status_ph')->nullable();
            $table->string('status_kekeruhan')->nullable();
            
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
