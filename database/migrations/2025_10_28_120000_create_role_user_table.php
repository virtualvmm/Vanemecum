<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla pivote 'role_user'.
 * Esta tabla gestiona la relación de muchos a muchos entre users y roles.
 */
class CreateRoleUserTable extends Migration
{
    /**
     * Ejecuta las migraciones (sube).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            // Clave Foránea para la tabla 'users'
            // constrained('users') automáticamente asume la convención de nombres y onCascadeDelete
            $table->foreignId('user_id')
                ->constrained() // Asume 'users'
                ->onDelete('cascade'); // Si el usuario se elimina, se elimina el registro aquí.

            // Clave Foránea para la tabla 'roles'
            $table->foreignId('role_id')
                ->constrained() // Asume 'roles'
                ->onDelete('cascade'); // Si el rol se elimina, se elimina el registro aquí.

            // Define una clave primaria compuesta para garantizar que la combinación de user_id y role_id sea única.
            $table->primary(['user_id', 'role_id']);

            // Opcional: Si necesita saber cuándo se asignó el rol, puede añadir timestamps
            // $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones (baja).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}