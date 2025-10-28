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
        // La tabla pivote es 'user_rol'. Claves: 'rol_id' y 'user_id'.
        return $this->belongsToMany(User::class, 'user_rol', 'rol_id', 'user_id');
    }
}