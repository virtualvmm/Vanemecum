<?php

namespace Database\Seeders;

use App\Models\Patogeno;
use App\Models\Sintoma;
use App\Models\Tratamiento;
use Illuminate\Database\Seeder;

class PatogenoSeeder extends Seeder
{
    /**
     * Ejecuta las semillas de la base de datos.
     *
     * Este seeder crea Patógenos y luego les asocia de forma aleatoria
     * Síntomas y Tratamientos para poblar las tablas pivote N:M.
     */
    public function run(): void
    {
        // 1. Crear una colección de Patógenos (ej. 30 patógenos de prueba)
        // Patogeno::factory(30)->create() funcionará siempre y cuando 
        // TipoPatogenoSeeder ya haya corrido para poblar la tabla 'tipo_patogenos'.
        $patogenos = Patogeno::factory(30)->create();

        // 2. Obtener todos los IDs de Síntomas y Tratamientos existentes
        // Esto asume que SintomaSeeder y TratamientoSeeder ya han corrido.
        $sintomaIds = Sintoma::pluck('id');
        $tratamientoIds = Tratamiento::pluck('id');

        // 3. Iterar sobre cada Patógeno y adjuntar relaciones N:M
        foreach ($patogenos as $patogeno) {
            
            // Adjuntar Síntomas:
            // Cada Patógeno tendrá entre 3 y 8 Síntomas.
            $patogeno->sintomas()->attach(
                $sintomaIds->random(rand(3, 8))->all()
            );

            // Adjuntar Tratamientos:
            // Cada Patógeno tendrá entre 2 y 5 Tratamientos asociados.
            $patogeno->tratamientos()->attach(
                $tratamientoIds->random(rand(2, 5))->all()
            );

            // NOTA: Si está utilizando la relación Patogeno-User (para gestores), 
            // la lógica para esa tabla pivote se añadiría aquí. 
            // La omitimos por ahora para centrarnos en las relaciones médicas principales.
        }
    }
}