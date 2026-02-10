<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Índices para acelerar las consultas de la Guía y el listado.
     * - is_active: filtro en guia.index y catalogo
     * - (is_active, nombre): filtro + orden típico
     */
    public function up(): void
    {
        if (!Schema::hasColumn('patogenos', 'is_active')) {
            return;
        }
        Schema::table('patogenos', function (Blueprint $table) {
            $table->index(['is_active', 'nombre'], 'patogenos_is_active_nombre_index');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('patogenos', 'is_active')) {
            return;
        }
        Schema::table('patogenos', function (Blueprint $table) {
            $table->dropIndex('patogenos_is_active_nombre_index');
        });
    }
};
