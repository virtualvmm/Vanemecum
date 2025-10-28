<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea la tabla de síntomas para listar las manifestaciones clínicas.
     */
    public function up(): void
    {
        Schema::create('sintomas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique(); // Nombre único del síntoma (ej: 'Fiebre alta')
            
            // CORRECCIÓN: Agregamos la columna 'gravedad'. 
            // Usamos tinyInteger para valores pequeños (1-5) y la hacemos obligatoria.
            $table->tinyInteger('gravedad')->default(1)->comment('Nivel de gravedad del síntoma (1=Leve, 5=Crítico)'); 
            
            $table->text('descripcion')->nullable(); // Descripción detallada del síntoma
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sintomas');
    }
};