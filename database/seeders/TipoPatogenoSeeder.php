<?php

namespace Database\Seeders;

use App\Models\TipoPatogeno;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPatogenoSeeder extends Seeder
{
    /**
     * Ejecuta las semillas de la base de datos para los tipos de patógenos.
     *
     * Inyecta los tipos de patógenos base para que la tabla 'patogenos' pueda
     * hacer referencia a ellos correctamente.
     */
    public function run(): void
    {
    
        // Definición de los tipos de patógenos más comunes en el vademécum
        $tipos = [
            // El más común y que requiere alta especificidad
            ['nombre' => 'Virus', 'descripcion' => 'Agentes infecciosos submicroscópicos que se replican solo dentro de las células vivas.'],
            
            // Tratados habitualmente con antibióticos
            ['nombre' => 'Bacteria', 'descripcion' => 'Organismos procariotas unicelulares, pueden ser patógenos o benéficos.'],
            
            // Agentes que causan micosis
            ['nombre' => 'Hongo', 'descripcion' => 'Organismos eucariotas que pueden ser unicelulares (levaduras) o multicelulares (mohos).'],
            
            // Eucariotas más complejos, a menudo tratados con antiparasitarios
            ['nombre' => 'Parásito', 'descripcion' => 'Organismos que viven sobre o dentro de otro organismo y se alimentan de él a expensas del huésped.'],
            
            // Entidad para casos especiales o no clasificados (ej. priones, toxinas)
            ['nombre' => 'Otro Agente', 'descripcion' => 'Cualquier otro agente biológico o químico capaz de causar enfermedad.'],
        ];

        // 1. Borrar todos los registros existentes para evitar duplicados en cada ejecución
        // Esto es seguro ya que el borrado fue restringido en la migración de patógenos.
        DB::table('tipo_patogenos')->delete();
        
        // 2. Insertar los tipos definidos
        DB::table('tipo_patogenos')->insert($tipos);

        // Opcional: Si creó un modelo `TipoPatogeno` (recomendado), podría usar:
        // foreach ($tipos as $tipo) { TipoPatogeno::create($tipo); }
    }
}