<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders de la aplicación.
     * Este método se encarga de llamar a todos los seeders necesarios
     * para la inicialización completa del sistema Vanemecum.
     */
    public function run(): void
    {
        // NOTA IMPORTANTE:
        // El orden es CRÍTICO, ya que AuxiliarSeeder (Roles, Tipos, Fuentes)
        // debe ejecutarse antes que PatogenoSeeder, que depende de esos datos.

        $this->call([
            // 1. Carga de datos auxiliares estáticos (Roles, Tipos, Fuentes)
            // y creación del usuario 'admin@admin.com'.
            AuxiliarSeeder::class,
            
            // 2. Carga de datos de Patógenos, Síntomas, Tratamientos de prueba.
            // Descomenta la línea si quieres datos de ejemplo.
            // PatogenoSeeder::class, 
        ]);
    }
}