<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    use HasFactory;

    // CRÍTICO: Sobreescribe el nombre de la tabla por defecto (de 'rols' a 'roles')
    protected $table = 'roles';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    
    /**
     * Define la relación Muchos a Muchos con Usuarios.
     */
    public function usuarios(): BelongsToMany
    {
        // Tabla pivote real según migración: 'role_user'
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}