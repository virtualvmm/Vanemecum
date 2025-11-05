<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos', function (Blueprint $table) {
            if (!Schema::hasColumn('tratamientos', 'tipo_id')) {
                $table->unsignedBigInteger('tipo_id')->nullable()->after('nombre');
                $table->foreign('tipo_id')
                      ->references('id')
                      ->on('tipo_tratamientos')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tratamientos', function (Blueprint $table) {
            if (Schema::hasColumn('tratamientos', 'tipo_id')) {
                $table->dropForeign(['tipo_id']);
                $table->dropColumn('tipo_id');
            }
        });
    }
};


