<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuxiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Tipos de Patógenos (lo que estaba fallando inicialmente)
        $tiposPatogenos = [
            ['nombre' => 'Virus', 'descripcion' => 'Agente infeccioso acelular que se replica solo dentro de células vivas.'],
            ['nombre' => 'Bacterias', 'descripcion' => 'Organismos unicelulares procariotas.'],
            ['nombre' => 'Hongos', 'descripcion' => 'Organismos eucariotas que incluyen levaduras, mohos y setas.'],
            ['nombre' => 'Parásitos', 'descripcion' => 'Organismos que viven sobre o dentro de otro organismo y se benefician de él.'],
        ];
        DB::table('tipo_patogenos')->insertOrIgnore($tiposPatogenos);
        
        // 2. Tipos de Tratamientos (lo que estaba fallando ahora)
        $tiposTratamientos = [
            ['nombre' => 'Antiviral', 'descripcion' => 'Medicamentos que tratan infecciones virales.'],
            ['nombre' => 'Antibiótico', 'descripcion' => 'Medicamentos que combaten infecciones bacterianas.'],
            ['nombre' => 'Antifúngico', 'descripcion' => 'Medicamentos que tratan infecciones causadas por hongos.'],
            ['nombre' => 'Soporte', 'descripcion' => 'Tratamientos dirigidos a aliviar síntomas.'],
        ];
        DB::table('tipo_tratamientos')->insertOrIgnore($tiposTratamientos);

        // 3. Roles de Usuario (solo Admin y User)
        $roles = [
            ['nombre' => 'Admin', 'descripcion' => 'Administrador del sistema. Control total.'],
            ['nombre' => 'User', 'descripcion' => 'Usuario estándar. Consulta de patógenos y tratamientos.'],
        ];
        DB::table('roles')->insertOrIgnore($roles);

        // 4. Fuentes de Información
        $fuentes = [
            ['nombre' => 'CDC', 'url' => 'https://www.cdc.gov/', 'descripcion' => 'Centros para el Control y la Prevención de Enfermedades.'],
            ['nombre' => 'OMS', 'url' => 'https://www.who.int/', 'descripcion' => 'Organización Mundial de la Salud.'],
        ];
        DB::table('fuentes_informacion')->insertOrIgnore($fuentes);
    }
}