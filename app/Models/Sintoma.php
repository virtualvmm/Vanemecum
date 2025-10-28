<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Representa la tabla 'sintomas'.
 */
class Sintoma extends Model
{
    use HasFactory;

    // Relación N:M con Patógenos
    public function patogenos()
    {
        // 'belongsToMany' indica la relación de muchos a muchos a través de la tabla pivote.
        return $this->belongsToMany(Patogeno::class, 'patogeno_sintoma');
    }
}
