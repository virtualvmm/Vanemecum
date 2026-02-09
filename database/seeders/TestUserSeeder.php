<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $userRole = Rol::firstOrCreate(
            ['nombre' => 'Usuario'],
            ['descripcion' => 'Usuario estándar']
        );

        $user = User::firstOrCreate(
            ['email' => 'usuario@example.com'],
            [
                'name' => 'Usuario de pruebas',
                'password' => Hash::make('12345678'),
                'dni' => '11111111A',
                'telefono' => '611111111',
                'direccion' => null,
            ]
        );

        $user->roles()->syncWithoutDetaching([$userRole->id]);
    }
}
