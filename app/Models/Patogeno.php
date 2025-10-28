<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Representa la tabla principal 'patogenos'.
 * Es el modelo central que se relaciona con todos los demás.
 */
class Patogeno extends Model
{
    use HasFactory;

    protected $table = 'patogenos';

    public $timestamps = true;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_patogeno_id', // Clave foránea al tipo
    ];

    /* ----------------------------------------------------------------------
     * RELACIONES N:1
     * ----------------------------------------------------------------------
     */

    /**
     * Relación N:1: Un Patogeno pertenece a un único TipoPatogeno (Virus, Bacteria, Hongo).
     * Esta es la relación inversa a la HasMany definida en TipoPatogeno.php.
     *
     * @return BelongsTo
     */
    public function tipo(): BelongsTo
    {
        // Usa la clave foránea 'tipo_patogeno_id' en esta tabla.
        return $this->belongsTo(TipoPatogeno::class, 'tipo_patogeno_id');
    }

    /* ----------------------------------------------------------------------
     * RELACIONES N:M (Muchos a Muchos)
     * ----------------------------------------------------------------------
     */

    /**
     * Relación N:M: Un Patogeno tiene muchos Sintomas, y un Sintoma se relaciona con muchos Patogenos.
     *
     * @return BelongsToMany
     */
    public function sintomas(): BelongsToMany
    {
        // El segundo argumento es la tabla pivote que definimos en la migración.
        return $this->belongsToMany(Sintoma::class, 'patogeno_sintoma');
    }

    /**
     * Relación N:M: Un Patogeno tiene muchos Tratamientos, y un Tratamiento se relaciona con muchos Patogenos.
     *
     * @return BelongsToMany
     */
    public function tratamientos(): BelongsToMany
    {
        // El segundo argumento es la tabla pivote que definimos en la migración.
        return $this->belongsToMany(Tratamiento::class, 'patogeno_tratamiento');
    }
}