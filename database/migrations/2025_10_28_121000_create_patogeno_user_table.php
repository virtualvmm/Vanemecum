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
        // Crea la tabla pivote para la relación Muchos a Muchos entre patogenos y usuarios (ej: para patógenos favoritos/seguidos).
        // Asume que las tablas 'patogenos' y 'users' ya existen.
        Schema::create('patogeno_user', function (Blueprint $table) {
            // Clave foránea para la tabla 'patogenos'
            $table->foreignId('patogeno_id')
                  ->constrained('patogenos')
                  ->onDelete('cascade');

            // Clave foránea para la tabla 'users'
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Definir una clave primaria compuesta.
            $table->primary(['patogeno_id', 'user_id']);
            $table->timestamps(); // Para saber cuándo un usuario siguió/agregó un patógeno.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patogeno_user');
    }
};