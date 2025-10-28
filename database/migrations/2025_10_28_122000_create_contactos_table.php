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
        // Crea la tabla 'contactos' para contactos de emergencia o colaboradores.
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            
            // Vincular el contacto con el usuario que lo creó o lo necesita.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
                  
            $table->string('nombre');
            $table->string('telefono', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('organizacion')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            
            // Se podría añadir un índice para búsquedas rápidas
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
