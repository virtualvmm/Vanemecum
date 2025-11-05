<?php

use App\Models\User;
use Laravel\Fortify\Fortify;

return [

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar el guard de autenticación por defecto que debe
    | usar Fortify. Por defecto es 'web', que es el estándar de Laravel.
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Username
    |--------------------------------------------------------------------------
    |
    | Aquí se define el campo que se utilizará como "nombre de usuario" para el
    | proceso de inicio de sesión.
    | Campo de nombre de usuario utilizado para iniciar sesión.
    |
    */

    'username' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Fortify Passwords
    |--------------------------------------------------------------------------
    |
    | Especifica el número mínimo de caracteres que deben tener las contraseñas
    | al registrarlas o actualizarlas.
    |
    */

    'password' => [
        'require_uppercase' => true,
        'require_numeric' => true,
        'require_symbols' => true,
        'length' => 8,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fortify Views
    |--------------------------------------------------------------------------
    |
    | Si Fortify está configurado para manejar la lógica de routing y vistas
    | de autenticación, esta opción especifica qué vistas debe usar.
    |
    */

    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Fortify Home Route
    |--------------------------------------------------------------------------
    |
    | Esta es la ruta a la que los usuarios serán redirigidos después de
    | iniciar sesión.
    |
    */

    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes
    |--------------------------------------------------------------------------
    |
    | Aquí se especifica si Fortify debe registrar automáticamente las rutas
    | necesarias para la autenticación (login, register, etc.).
    |
    */

    'routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Fortify Features
    |--------------------------------------------------------------------------
    |
    | Puedes habilitar o deshabilitar las funciones de autenticación de Fortify.
    | CRÍTICO: Reemplazamos todos los métodos estáticos (Fortify::...) por sus cadenas.
    |
    */

    'features' => [
        'registration',             // Habilita el registro de nuevos usuarios
        'reset-passwords',          // Habilita el restablecimiento de contraseñas
        // 'verify-email',           // Verifica el correo (deshabilitado por ahora)
        'update-profile-information', // Actualiza la información del perfil
        'update-passwords',         // Actualiza la contraseña
        'two-factor-authentication',  // Autenticación de dos factores
    ],

    /*
    |--------------------------------------------------------------------------
    | Fortify Model
    |--------------------------------------------------------------------------
    |
    | Define la clase de modelo Eloquent que Fortify debe usar para los usuarios.
    |
    */

    'model' => User::class,

];
