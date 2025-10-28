<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- NECESARIO para deshabilitar las FKs

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // IMPORTANTE: Desactivar temporalmente las restricciones de claves foráneas
        // Esto previene errores de "Cannot truncate" en tablas relacionadas (N:M).
        // Solo es necesario para MySQL/MariaDB.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // ---------------------------------------------------------------------

        // 1. Tablas de datos auxiliares (SIN dependencias)
        $this->call([
            AuxiliarSeeder::class,     // Asumimos que aquí está TipoPatogenoSeeder
            SintomaSeeder::class,      // Siembra los datos de síntomas
            TratamientoSeeder::class,  // Siembra los datos de tratamientos
        ]);

        // 2. Tablas principales y tablas pivote (CON dependencias)
        // PatogenoSeeder DEBE ir al final, ya que utiliza los datos sembrados anteriormente.
        $this->call([
            PatogenoSeeder::class,
        ]);
        
        // ---------------------------------------------------------------------
        // IMPORTANTE: Volver a activar las restricciones
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // ---------------------------------------------------------------------
    }
}