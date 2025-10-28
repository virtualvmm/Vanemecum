<?php

namespace Database\Seeders;

use App\Models\Sintoma;
use Illuminate\Database\Seeder;

class SintomaSeeder extends Seeder
{
    /**
     * Ejecuta las semillas de la base de datos para los Síntomas.
     *
     * El objetivo es crear una base de datos de síntomas de prueba
     * que luego puedan ser asociados a Patógenos en el PatogenoSeeder.
     */
    public function run(): void
    {
        // 1. Limpieza de tabla: 
        // Es una buena práctica usar truncate para asegurar que cada ejecución sea limpia,
        // especialmente en tablas que no tienen relaciones críticas que impidan el borrado.
        Sintoma::truncate();

        // 2. Generación de datos: 
        // Creamos una cantidad razonable de síntomas de prueba (25) utilizando el Factory.
        // El Factory (SintomaFactory) se encarga de darles un nombre, gravedad (1-5) 
        // y una descripción única.
        Sintoma::factory(25)->create();
        
        $this->command->info('✅ 25 Síntomas de prueba creados exitosamente.');
    }
}