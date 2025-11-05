<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tratamiento extends Model
{
    use HasFactory;

    // CRÍTICO: Define el nombre exacto de la tabla en la base de datos (plural)
    protected $table = 'tratamientos';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        // Opcionales/extendidos (pueden no existir en DB, se ignoran si no están)
        'dosis_o_metodo',
        'duracion_estimada',
        'efectividad_porcentaje',
        'tipo_id',
    ];

    /**
     * Relación Muchos a Muchos con Patogenos.
     * Define a qué patógenos aplica este tratamiento.
     */
    public function patogenos(): BelongsToMany
    {
        // La tabla pivote por defecto es 'patogeno_tratamiento', que es correcta para este caso.
        return $this->belongsToMany(Patogeno::class, 'patogeno_tratamiento');
    }

    /**
     * Relación N:1 con TipoTratamiento (nullable).
     */
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoTratamiento::class, 'tipo_id');
    }
}