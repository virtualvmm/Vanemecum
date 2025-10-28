<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'diagnosticos',
 * que debe ejecutarse antes que 'alarmas' para que la clave foránea funcione.
 */
return new class extends Migration
{
    /**
     * Run the migrations (Ejecutar las migraciones).
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            // Clave primaria
            $table->id();

            // 1. Relación con Usuario (quién hizo el diagnóstico, opcional)
            // Asume que la tabla 'users' ya existe, lo cual es correcto por el timestamp.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null')
                ->comment('ID del usuario que creó/asoció el diagnóstico.');

            // 2. Resultado del Diagnóstico
            $table->enum('resultado_final', ['Positivo', 'Negativo', 'Inconcluso'])
                ->default('Inconcluso')
                ->comment('Resultado del análisis o diagnóstico.');

            // 3. Detalles adicionales
            $table->text('observaciones')
                ->nullable()
                ->comment('Notas o detalles sobre el diagnóstico.');

            // Timestamps automáticos (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations (Revertir las migraciones).
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};