<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Rol; // CRÍTICO: Importamos el modelo Rol
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valida y crea un nuevo usuario.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        // 1. Validación: Aseguramos que los campos coincidan con la tabla 'usuarios'.
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:150'],
            // Aseguramos que el DNI sea único en la tabla 'usuarios'
            'dni' => ['required', 'string', 'max:15', 'unique:usuarios'], 
            'fecha_nacimiento' => ['required', 'date', 'before:today'], 
            'correo' => [ 
                'required',
                'string',
                'email',
                'max:150',
                // CRÍTICO: Regla de unicidad usando la tabla 'usuarios' y columna 'correo'
                Rule::unique('usuarios', 'correo'), 
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // 2. Creación del usuario en la tabla 'usuarios' (sin el campo 'rol' simple).
        $user = User::create([
            'nombre' => $input['nombre'],
            'apellidos' => $input['apellidos'],
            'dni' => $input['dni'],
            'fecha_nacimiento' => $input['fecha_nacimiento'],
            'correo' => $input['correo'], 
            'password' => Hash::make($input['password']),
            'is_active' => true, 
        ]);

        // 3. Asignación del rol por defecto mediante la tabla pivote user_rol.
        // Buscamos el ID del rol 'usuario' (debe existir gracias al INSERT en tu script SQL)
        $defaultRole = Rol::where('nombre', 'usuario')->first();

        if ($defaultRole) {
            // Asigna el rol 'usuario' en la tabla 'user_rol'.
            $user->roles()->attach($defaultRole->id);
        } else {
            // Manejo de error si el rol base no existe.
            // Para fines de desarrollo, es una buena práctica dejar un recordatorio.
            // \Log::error("Rol 'usuario' no encontrado. La asignación falló para el nuevo usuario: " . $user->id);
        }

        return $user;
    }
}