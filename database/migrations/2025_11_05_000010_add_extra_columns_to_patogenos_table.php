<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade columnas usadas por el formulario de patógenos (micros-db):
     * fuente_id, image_url, is_active.
     */
    public function up(): void
    {
        Schema::table('patogenos', function (Blueprint $table) {
            if (!Schema::hasColumn('patogenos', 'fuente_id')) {
                $table->unsignedBigInteger('fuente_id')->nullable()->after('tipo_patogeno_id');
                $table->foreign('fuente_id')->references('id')->on('fuentes_informacion')->onDelete('set null');
            }
            if (!Schema::hasColumn('patogenos', 'image_url')) {
                $table->string('image_url', 500)->nullable()->after('descripcion');
            }
            if (!Schema::hasColumn('patogenos', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patogenos', function (Blueprint $table) {
            if (Schema::hasColumn('patogenos', 'fuente_id')) {
                $table->dropForeign(['fuente_id']);
                $table->dropColumn('fuente_id');
            }
            if (Schema::hasColumn('patogenos', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('patogenos', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
