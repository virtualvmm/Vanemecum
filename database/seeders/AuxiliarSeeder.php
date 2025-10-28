<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Rol; // Necesario para la relación
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuxiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * * Este seeder carga los datos estáticos necesarios para el funcionamiento
     * de las tablas auxiliares y crea un usuario Administrador inicial.
     */
    public function run(): void
    {
        // ----------------------------------------------------------------------
        // 1. ROLES (Tabla: roles)
        // ----------------------------------------------------------------------
        $roles = [
            ['id' => 1, 'nombre' => 'admin', 'descripcion' => 'Administrador completo del sistema.'],
            ['id' => 2, 'nombre' => 'gestor', 'descripcion' => 'Gestor de contenido (Patógenos, Tratamientos, etc.).'],
            ['id' => 3, 'nombre' => 'usuario', 'descripcion' => 'Usuario registrado con acceso a colecciones y guías.'],
        ];

        // Usamos insertOrIgnore para evitar duplicados si ya corriste el seeder.
        DB::table('roles')->insertOrIgnore($roles);

        // ----------------------------------------------------------------------
        // 2. TIPO PATÓGENOS (Tabla: tipo_patogenos)
        // ----------------------------------------------------------------------
        $tiposPatogeno = [
            ['nombre' => 'Virus', 'descripcion' => 'Agente infeccioso acelular que se replica solo dentro de células vivas.'],
            ['nombre' => 'Bacterias', 'descripcion' => 'Organismos unicelulares procariotas.'],
            ['nombre' => 'Hongos', 'descripcion' => 'Organismos eucariotas que incluyen levaduras, mohos y setas.'],
            ['nombre' => 'Parásitos', 'descripcion' => 'Organismos que viven sobre o dentro de otro organismo y se benefician de él.'],
        ];

        DB::table('tipo_patogenos')->insertOrIgnore($tiposPatogeno);

        // ----------------------------------------------------------------------
        // 3. TIPOS TRATAMIENTOS (Tabla: tipo_tratamientos)
        // ----------------------------------------------------------------------
        $tiposTratamiento = [
            ['nombre' => 'Antiviral', 'descripcion' => 'Medicamentos que tratan infecciones virales.'],
            ['nombre' => 'Antibiótico', 'descripcion' => 'Medicamentos que combaten infecciones bacterianas.'],
            ['nombre' => 'Antifúngico', 'descripcion' => 'Medicamentos que tratan infecciones causadas por hongos.'],
            ['nombre' => 'Soporte', 'descripcion' => 'Tratamientos dirigidos a aliviar síntomas.'],
        ];

        DB::table('tipo_tratamientos')->insertOrIgnore($tiposTratamiento);

        // ----------------------------------------------------------------------
        // 4. FUENTES (Tabla: fuentes)
        // ----------------------------------------------------------------------
        $fuentes = [
            ['nombre' => 'OMS', 'url' => 'https://www.who.int', 'descripcion' => 'Organización Mundial de la Salud.'],
            ['nombre' => 'CDC', 'url' => 'https://www.cdc.gov', 'descripcion' => 'Centros para el Control y la Prevención de Enfermedades.'],
            ['nombre' => 'Ministerio de Salud', 'url' => 'https://www.minsalud.gov', 'descripcion' => 'Autoridad Sanitaria Nacional.'],
        ];

        DB::table('fuentes')->insertOrIgnore($fuentes);
        
        // ----------------------------------------------------------------------
        // 5. USUARIO ADMINISTRADOR DE PRUEBA (Tabla: usuarios)
        // CRÍTICO: Creamos un usuario de prueba para poder acceder al admin.
        // ----------------------------------------------------------------------
        
        // Verificamos si ya existe para no duplicar el administrador.
        $existingAdmin = User::where('correo', 'admin@admin.com')->first();
        
        if (!$existingAdmin) {
             $userAdmin = User::create([
                'nombre' => 'Admin',
                'apellidos' => 'Vademecum',
                'dni' => '12345678A',
                'fecha_nacimiento' => Carbon::parse('1990-01-01'),
                'correo' => 'admin@admin.com',
                'password' => Hash::make('password'), // Contraseña: 'password'
                'is_active' => true,
            ]);

            // Asignamos el rol 'admin' (ID 1) al usuario de prueba en la tabla pivote user_rol.
            $adminRole = Rol::where('nombre', 'admin')->first();

            if ($adminRole) {
                 $userAdmin->roles()->attach($adminRole->id);
            }
        }
    }
}