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
        Schema::create('devices', function (Blueprint $table) {

            $table->id();

            $table->string('device_id')->unique();

            $table->string('nama_device');

            $table->string('lokasi')->nullable();

            $table->decimal('latitude',10,7)->nullable();

            $table->decimal('longitude',10,7)->nullable();

            $table->decimal('altitude',8,2)->nullable();

            $table->string('ip_address')->nullable();

            $table->enum('status',['online','offline'])
                ->default('offline');

            $table->timestamp('last_seen')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
