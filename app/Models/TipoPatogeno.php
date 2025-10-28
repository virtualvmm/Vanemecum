<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPatogeno extends Model
{
    use HasFactory;

    // CRÍTICO: Define el nombre exacto de la tabla en la base de datos (plural)
    protected $table = 'tipos_patogenos'; 

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación 1:N: Un TipoPatogeno tiene muchos Patogenos.
     * Es la relación inversa a la BelongsTo definida en Patogeno.php.
     */
    public function patogenos(): HasMany
    {
        // La clave foránea 'tipo_id' se encuentra en la tabla 'patogenos'.
        return $this->hasMany(Patogeno::class, 'tipo_id');
    }
}