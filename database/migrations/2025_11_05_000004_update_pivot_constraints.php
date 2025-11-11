<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // patogeno_sintoma
        Schema::table('patogeno_sintoma', function (Blueprint $table) {
            // Índice único para evitar duplicados
            if (!Schema::hasColumn('patogeno_sintoma', 'patogeno_id')) {
                $table->unsignedBigInteger('patogeno_id');
            }
            if (!Schema::hasColumn('patogeno_sintoma', 'sintoma_id')) {
                $table->unsignedBigInteger('sintoma_id');
            }
            $table->unique(['patogeno_id', 'sintoma_id'], 'patogeno_sintoma_unique');

            // FKs con borrado en cascada
            $table->foreign('patogeno_id')->references('id')->on('patogenos')->onDelete('cascade');
            $table->foreign('sintoma_id')->references('id')->on('sintomas')->onDelete('cascade');
        });

        // patogeno_tratamiento
        Schema::table('patogeno_tratamiento', function (Blueprint $table) {
            if (!Schema::hasColumn('patogeno_tratamiento', 'patogeno_id')) {
                $table->unsignedBigInteger('patogeno_id');
            }
            if (!Schema::hasColumn('patogeno_tratamiento', 'tratamiento_id')) {
                $table->unsignedBigInteger('tratamiento_id');
            }
            $table->unique(['patogeno_id', 'tratamiento_id'], 'patogeno_tratamiento_unique');

            $table->foreign('patogeno_id')->references('id')->on('patogenos')->onDelete('cascade');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos')->onDelete('cascade');
        });

        // patogeno_user (colecciones de usuario)
        Schema::table('patogeno_user', function (Blueprint $table) {
            if (!Schema::hasColumn('patogeno_user', 'patogeno_id')) {
                $table->unsignedBigInteger('patogeno_id');
            }
            if (!Schema::hasColumn('patogeno_user', 'user_id')) {
                $table->unsignedBigInteger('user_id');
            }
            // estado_coleccion puede existir; no lo tocamos
            $table->unique(['patogeno_id', 'user_id'], 'patogeno_user_unique');

            $table->foreign('patogeno_id')->references('id')->on('patogenos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('patogeno_sintoma', function (Blueprint $table) {
            $table->dropForeign(['patogeno_id']);
            $table->dropForeign(['sintoma_id']);
            $table->dropUnique('patogeno_sintoma_unique');
        });
        Schema::table('patogeno_tratamiento', function (Blueprint $table) {
            $table->dropForeign(['patogeno_id']);
            $table->dropForeign(['tratamiento_id']);
            $table->dropUnique('patogeno_tratamiento_unique');
        });
        Schema::table('patogeno_user', function (Blueprint $table) {
            $table->dropForeign(['patogeno_id']);
            $table->dropForeign(['user_id']);
            $table->dropUnique('patogeno_user_unique');
        });
    }
};


