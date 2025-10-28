<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea la tabla de tratamientos para registrar las opciones terapéuticas.
     */
    public function up(): void
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique(); // Nombre único del tratamiento (ej: 'Antiviral específico', 'Vacunación')
            $table->text('descripcion'); // Instrucciones, dosificación o detalles completos del tratamiento
            
            // CORRECCIÓN: Hacemos la columna 'duracion_dias' nullable para evitar el error 1048
            // Esto permite que el seeder funcione si por alguna razón inserta NULL.
            $table->unsignedSmallInteger('duracion_dias')
                  ->nullable() // ¡ESTA ES LA CLAVE!
                  ->comment('Duración estimada del tratamiento en días');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};