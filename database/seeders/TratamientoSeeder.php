<?php

namespace Database\Seeders;

use App\Models\Tratamiento;
use Illuminate\Database\Seeder;

class TratamientoSeeder extends Seeder
{
    /**
     * Ejecuta las semillas de la base de datos.
     *
     * Este seeder utiliza TratamientoFactory para poblar la tabla
     * con datos de prueba realistas.
     */
    public function run(): void
    {
        // Creamos una cantidad considerable de tratamientos (ej. 50)
        // para tener un catálogo variado que pueda ser asociado a múltiples
        // patógenos a través de la relación N:M (patogeno_tratamiento).
        Tratamiento::factory(50)->create();
    }
}
