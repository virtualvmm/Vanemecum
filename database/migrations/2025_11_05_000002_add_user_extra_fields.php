<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'dni')) {
                $table->string('dni', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono', 30)->nullable()->after('dni');
            }
            if (!Schema::hasColumn('users', 'direccion')) {
                $table->string('direccion', 255)->nullable()->after('telefono');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'dni')) { $table->dropColumn('dni'); }
            if (Schema::hasColumn('users', 'telefono')) { $table->dropColumn('telefono'); }
            if (Schema::hasColumn('users', 'direccion')) { $table->dropColumn('direccion'); }
        });
    }
};


