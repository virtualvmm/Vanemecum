<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tratamiento extends Model
{
    use HasFactory;

    // CRÍTICO: Define el nombre exacto de la tabla en la base de datos (plural)
    protected $table = 'tratamientos';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'dosis_o_metodo', // Puede ser una dosis de medicamento o un procedimiento
        'duracion_estimada',
        'efectividad_porcentaje',
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
}