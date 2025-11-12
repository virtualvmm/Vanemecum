<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Los atributos que son asignables en masa.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* -------------------------------------------------------------------------- */
    /* RELACIONES */
    /* -------------------------------------------------------------------------- */

    /**
     * Relación Muchos a Muchos con Roles (Tabla Pivote: role_user)
     */
    public function roles(): BelongsToMany
    {
        // Usa el modelo singular Rol
        return $this->belongsToMany(Rol::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Relación Muchos a Muchos con Patogenos (Mi Vanemecum - Tabla Pivote: user_patogeno)
     */
    public function patogenos(): BelongsToMany
    {
        // Tabla pivote real en BD: 'patogeno_user'
        return $this->belongsToMany(Patogeno::class, 'patogeno_user', 'user_id', 'patogeno_id')
                    ->withPivot('estado_coleccion')
                    ->withTimestamps();
    }
    
    /* -------------------------------------------------------------------------- */
    /* HELPERS (Métodos de Ayuda) */
    /* -------------------------------------------------------------------------- */

    /**
     * Verifica si el usuario tiene un rol específico.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('nombre', $role)->exists();
    }

    /**
     * Sobrescribe el método 'getEmailForPasswordReset' usado por Fortify/Auth
     * para asegurar que se use la columna 'correo'.
     */
    public function getEmailForPasswordReset(): string
    {
        return $this->email;
    }
}
