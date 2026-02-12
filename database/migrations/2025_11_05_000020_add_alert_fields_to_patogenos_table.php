<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patogenos', function (Blueprint $table) {
            if (!Schema::hasColumn('patogenos', 'alerta_activa')) {
                $table->boolean('alerta_activa')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('patogenos', 'alerta_texto')) {
                $table->string('alerta_texto', 500)->nullable()->after('alerta_activa');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patogenos', function (Blueprint $table) {
            if (Schema::hasColumn('patogenos', 'alerta_texto')) {
                $table->dropColumn('alerta_texto');
            }
            if (Schema::hasColumn('patogenos', 'alerta_activa')) {
                $table->dropColumn('alerta_activa');
            }
        });
    }
};

