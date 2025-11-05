<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importación necesaria

/**
 * TipoPatogeno Model
 * * Representa la clasificación de un Patógeno (e.g., bacteria, virus, hongo).
 * Es el lado "uno" de la relación uno a muchos (1:N) con Patogeno.
 */
class TipoPatogeno extends Model
{
    use HasFactory;

    protected $table = 'tipo_patogenos'; 

    /**
     * Los atributos que se pueden asignar masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion', // Suponemos que tiene un campo de descripción
    ];

    /**
     * Define la relación 1:N con Patogeno.
     * Un TipoPatogeno puede tener muchos Patógenos.
     *
     * @return HasMany
     */
    public function patogenos(): HasMany
    {
        // *** La clave foránea en la tabla 'patogenos' es 'tipo_patogeno_id'.
        return $this->hasMany(Patogeno::class, 'tipo_patogeno_id');
    }
}