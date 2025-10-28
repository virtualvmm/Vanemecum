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
        // Crea la tabla pivote para la relación Muchos a Muchos entre patogenos y sintomas.
        Schema::create('patogeno_sintoma', function (Blueprint $table) {
            // Clave foránea para la tabla 'patogenos'
            $table->foreignId('patogeno_id')
                  ->constrained('patogenos')
                  ->onDelete('cascade'); // Si se borra un patógeno, se borran sus relaciones.

            // Clave foránea para la tabla 'sintomas'
            $table->foreignId('sintoma_id')
                  ->constrained('sintomas')
                  ->onDelete('cascade'); // Si se borra un síntoma, se borran sus relaciones.

            // Definir una clave primaria compuesta para asegurar la unicidad de la combinación.
            $table->primary(['patogeno_id', 'sintoma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patogeno_sintoma');
    }
};