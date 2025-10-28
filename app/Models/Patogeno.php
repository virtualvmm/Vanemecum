<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patogeno extends Model
{
    use HasFactory;

    // CRÍTICO: Sobreescribe el nombre de la tabla por defecto (de 'patogenos' a 'patogenos')
    protected $table = 'patogenos';

    public $timestamps = true;

    protected $fillable = [
        'nombre_comun',
        'nombre_cientifico',
        'agente_etiologico',
        'ciclo_vida',
        'imagen_url',
        'tipo_id',
    ];
    
    /* -------------------------------------------------------------------------- */
    /* RELACIONES */
    /* -------------------------------------------------------------------------- */

    /**
     * Relación N:1: Muchos Patogenos pertenecen a un TipoPatogeno.
     * (El Patógeno tiene una clave foránea 'tipo_id').
     */
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoPatogeno::class, 'tipo_id');
    }

    /**
     * Relación Muchos a Muchos con Usuarios (Mi Vademecum / Colección).
     * Permite saber qué patógenos ha añadido un usuario a su colección personal.
     */
    public function usuarios(): BelongsToMany
    {
        // La tabla pivote es 'user_patogeno'.
        return $this->belongsToMany(User::class, 'user_patogeno', 'patogeno_id', 'user_id')
                    ->withPivot('estado_coleccion') // Atributo extra en la tabla pivote
                    ->withTimestamps();
    }
    
    /**
     * Relación Muchos a Muchos con Síntomas.
     * Define los síntomas asociados a este patógeno.
     */
    public function sintomas(): BelongsToMany
    {
        // La tabla pivote es 'patogeno_sintoma'.
        return $this->belongsToMany(Sintoma::class, 'patogeno_sintoma');
    }

    /**
     * Relación Muchos a Muchos con Tratamientos.
     * Define los tratamientos aplicables a este patógeno.
     */
    public function tratamientos(): BelongsToMany
    {
        // La tabla pivote es 'patogeno_tratamiento'.
        return $this->belongsToMany(Tratamiento::class, 'patogeno_tratamiento');
    }
}