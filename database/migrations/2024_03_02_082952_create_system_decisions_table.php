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
        Schema::create('system_decisions', function (Blueprint $table) {
            $table->id();
            $table->float('decision');
            $table->foreignId('ph_sensor_id')->constrained('ph_sensors');
            $table->foreignId('temp_sensor_id')->constrained('temp_sensors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_decisions');
    }
};
