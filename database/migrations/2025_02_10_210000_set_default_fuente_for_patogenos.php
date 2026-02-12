<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Asignar la fuente "OMS" por defecto a todos los patógenos que no tengan fuente
        $idFuenteOms = DB::table('fuentes_informacion')
            ->where('nombre', 'OMS')
            ->value('id');

        if ($idFuenteOms) {
            DB::table('patogenos')
                ->whereNull('fuente_id')
                ->update(['fuente_id' => $idFuenteOms]);
        }
    }

    public function down(): void
    {
        // Revertir: dejar sin fuente los patógenos que apunten a "OMS"
        $idFuenteOms = DB::table('fuentes_informacion')
            ->where('nombre', 'OMS')
            ->value('id');

        if ($idFuenteOms) {
            DB::table('patogenos')
                ->where('fuente_id', $idFuenteOms)
                ->update(['fuente_id' => null]);
        }
    }
};

