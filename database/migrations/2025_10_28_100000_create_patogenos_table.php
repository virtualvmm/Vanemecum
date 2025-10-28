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
        Schema::create('patogenos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();
            $table->text('descripcion');
            
            // CAMBIO CRÍTICO: Usamos la clave foránea 'tipo_patogeno_id' 
            // Esto reemplaza a la antigua columna 'tipo'
            $table->foreignId('tipo_patogeno_id')
                  ->constrained('tipo_patogenos') // Debe apuntar a la tabla auxiliar creada previamente
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patogenos');
    }
};