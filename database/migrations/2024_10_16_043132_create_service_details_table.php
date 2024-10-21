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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();  // Identificador único
            $table->enum('name', [
                'FTL', 'LTL', 'hand carrier', 'charter', 'Air Freight', 
                'Container Drayage', 'warehouse', 'Trailer Rental', 
                'us customs broker', 'Transfer'
            ]);  // Tipo de servicio
            $table->string('description')->nullable();  // Descripción del servicio
            $table->timestamps();  // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};