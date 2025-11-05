<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoTratamiento extends Model
{
    use HasFactory;

    protected $table = 'tipo_tratamientos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación 1:N con Tratamiento
     */
    public function tratamientos(): HasMany
    {
        return $this->hasMany(Tratamiento::class, 'tipo_id');
    }
}


