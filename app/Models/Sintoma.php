<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sintoma extends Model
{
    use HasFactory;

    // CRÍTICO: Define el nombre exacto de la tabla en la base de datos (plural)
    protected $table = 'sintomas';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'gravedad', // Podrías usar valores como 'Leve', 'Moderado', 'Grave'
    ];

    /**
     * Relación Muchos a Muchos con Patogenos.
     * Define qué patógenos pueden causar este síntoma.
     */
    public function patogenos(): BelongsToMany
    {
        // La tabla pivote por defecto es 'patogeno_sintoma', que es correcta para este caso.
        return $this->belongsToMany(Patogeno::class, 'patogeno_sintoma');
    }
}