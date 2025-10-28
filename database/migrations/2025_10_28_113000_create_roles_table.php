<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'roles'.
 * NOTA: La clase ha sido corregida a CreateRolesTable.
 */
class CreateRolesTable extends Migration // <-- ¡Clase Corregida!
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Esta migración solo crea la tabla 'roles'
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique()->comment('Nombre del rol, ej: Admin, Usuario, Médico.');
            $table->string('descripcion')->nullable()->comment('Descripción detallada del rol.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}