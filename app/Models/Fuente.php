<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fuente extends Model
{
    use HasFactory;

    // 1. Configuración de la tabla
    protected $table = 'fuentes';
    public $timestamps = false; // No tiene campos created_at/updated_at

    // 2. Campos permitidos para asignación masiva
    protected $fillable = [
        'nombre',
        'url',
    ];

    // 3. Relación con los patógenos que utilizan esta fuente
    public function patogenos(): HasMany
    {
        return $this->hasMany(Patogeno::class, 'fuente_id');
    }
}
