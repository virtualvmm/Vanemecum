<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // 1. Tabla de Tipos de Patógenos
        Schema::create('tipo_patogenos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // 2. Tabla de Fuentes de Información
        Schema::create('fuentes_informacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();
            $table->string('url', 500)->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // 3. Tabla de Tipos de Tratamientos
        Schema::create('tipo_tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_patogenos');
        Schema::dropIfExists('fuentes_informacion');
        Schema::dropIfExists('tipo_tratamientos');
    }
};