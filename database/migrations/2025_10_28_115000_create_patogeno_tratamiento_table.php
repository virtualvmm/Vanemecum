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
        // Crea la tabla pivote para la relación Muchos a Muchos entre patogenos y tratamientos.
        Schema::create('patogeno_tratamiento', function (Blueprint $table) {
            // Clave foránea para la tabla 'patogenos'
            $table->foreignId('patogeno_id')
                  ->constrained('patogenos')
                  ->onDelete('cascade');

            // Clave foránea para la tabla 'tratamientos'
            $table->foreignId('tratamiento_id')
                  ->constrained('tratamientos')
                  ->onDelete('cascade');

            // Definir una clave primaria compuesta.
            $table->primary(['patogeno_id', 'tratamiento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patogeno_tratamiento');
    }
};