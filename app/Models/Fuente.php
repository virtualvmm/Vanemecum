<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Fuente Model
 * * Representa la fuente de origen de un Patógeno (e.g., Agua, Aire, Vector).
 * Es el lado "uno" de la relación uno a muchos (1:N) con Patogeno.
 */
class Fuente extends Model
{
    use HasFactory;

    // La migración creó la tabla 'fuentes_informacion'
    protected $table = 'fuentes_informacion';

    /**
     * Los atributos que se pueden asignar masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'url',
        'descripcion',
    ];

    /**
     * Define la relación 1:N con Patogeno.
     * Una Fuente puede tener muchos Patógenos.
     *
     * @return HasMany
     */
    public function patogenos(): HasMany
    {
        // La clave foránea en la tabla 'patogenos' es 'fuente_id'.
        return $this->hasMany(Patogeno::class, 'fuente_id');
    }
}