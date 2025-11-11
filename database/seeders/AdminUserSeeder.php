<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Rol::firstOrCreate(['nombre' => 'Admin'], ['descripcion' => 'Administrador del sistema']);

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'dni' => '00000000A',
                'telefono' => '600000000',
                'direccion' => 'Administración',
            ]
        );

        $user->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}


