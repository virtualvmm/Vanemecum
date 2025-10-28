<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlarmasTable extends Migration
{
    /**
     * Run the migrations (Ejecutar las migraciones).
     * Crea la tabla 'alarmas'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarmas', function (Blueprint $table) {
            // Clave primaria
            $table->id();

            // 1. Relación con Patógeno (Clave foránea MANDATORIA)
            $table->foreignId('patogeno_id')
                  ->constrained('patogenos') 
                  ->onUpdate('cascade')
                  ->onDelete('cascade')
                  ->comment('ID del patógeno que disparó la alarma.');

            // 2. Relación con Diagnóstico (Clave foránea OPCIONAL)
            $table->foreignId('diagnostico_id')
                  ->nullable()
                  ->constrained('diagnosticos') 
                  ->onUpdate('cascade')
                  ->onDelete('set null')
                  ->comment('ID del diagnóstico asociado (opcional).');

            // 3. Campos de Datos de la Alarma
            $table->enum('nivel_prioridad', ['Baja', 'Media', 'Alta', 'Crítica'])
                  ->default('Media')
                  ->comment('Nivel de riesgo de la alarma.');

            $table->string('mensaje_alerta', 500)
                  ->comment('Descripción de la condición que causó la alarma.');
            
            $table->dateTime('fecha_hora_activacion')
                  ->comment('Fecha y hora exacta de la activación.');

            $table->enum('estado', ['Activa', 'Resuelta', 'Ignorada', 'Pendiente'])
                  ->default('Activa')
                  ->comment('Estado actual de la alarma.');

            // Timestamps automáticos (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations (Revertir las migraciones).
     * Elimina la tabla 'alarmas'.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alarmas');
    }
}
