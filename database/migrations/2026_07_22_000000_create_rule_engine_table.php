<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rule_engine', function (Blueprint $table) {
            $table->id();
            $table->decimal('temperature_normal_min', 5, 2)->default(25);
            $table->decimal('temperature_normal_max', 5, 2)->default(30);
            $table->decimal('temperature_warning_min', 5, 2)->default(30);
            $table->decimal('temperature_warning_max', 5, 2)->default(32);
            $table->decimal('temperature_danger_min', 5, 2)->default(32);
            $table->decimal('ph_normal_min', 5, 2)->default(6.5);
            $table->decimal('ph_normal_max', 5, 2)->default(8.5);
            $table->decimal('ph_warning_min', 5, 2)->default(6.0);
            $table->decimal('ph_warning_max', 5, 2)->default(6.5);
            $table->decimal('ph_danger_min', 5, 2)->default(6.0);
            $table->decimal('turbidity_very_clear_max', 5, 2)->default(5);
            $table->decimal('turbidity_clear_max', 5, 2)->default(20);
            $table->decimal('turbidity_turbid_max', 5, 2)->default(50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rule_engine');
    }
};
