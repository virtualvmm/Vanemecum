<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Representa la tabla auxiliar 'tipo_patogenos' que clasifica los patógenos
 * (e.g., Virus, Bacterias, Hongos).
 */
class TipoPatogeno extends Model
{
    use HasFactory;

    // *** Nombre de la tabla según la migración.
    protected $table = 'tipo_patogenos'; 

    // Un TipoPatogeno tiene muchos Patógenos (relación 1:N)
    public function patogenos()
    {
        // *** La clave foránea en la tabla 'patogenos' es 'tipo_patogeno_id'.
        return $this->hasMany(Patogeno::class, 'tipo_patogeno_id');
    }
}