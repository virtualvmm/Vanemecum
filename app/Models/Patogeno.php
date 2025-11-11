<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        // --- CAMPOS ADICIONALES AÑADIDOS PARA SINCRONIZAR CON EL FORMULARIO ---
        'image_url',       // Para guardar la ruta de la imagen subida
        'is_active',       // Checkbox de estado activo/inactivo
        'fuente_id',       // Clave foránea 1:N a la fuente de referencia (Opcional)
        // ----------------------------------------------------------------------
    ];

    /**
     * Define la conversión de tipos (casting) para asegurar la consistencia.
     */
    protected $casts = [
        'is_active' => 'boolean', // Es fundamental para los checkboxes
    ];


    /* ----------------------------------------------------------------------
     * RELACIONES N:1 (Pertenece a)
     * ----------------------------------------------------------------------
     */

    /**
     * Relación N:1: Un Patogeno pertenece a un único TipoPatogeno (Virus, Bacteria, Hongo).
     */
    public function tipo(): BelongsTo
    {
        // Usa la clave foránea 'tipo_patogeno_id' en esta tabla.
        return $this->belongsTo(TipoPatogeno::class, 'tipo_patogeno_id');
    }

    /**
     * Relación N:1: Un Patogeno pertenece a una Fuente de Referencia (opcional).
     * Nota: Asume que tienes un modelo llamado 'Fuente'.
     *
     * @return BelongsTo
     */
    public function fuente(): BelongsTo
    {
        // Asume que la clave foránea es 'fuente_id' en esta tabla.
        return $this->belongsTo(Fuente::class, 'fuente_id');
    }


    /* ----------------------------------------------------------------------
     * RELACIONES N:M (Muchos a Muchos)
     * ----------------------------------------------------------------------
     */

    /**
     * Relación N:M: Un Patogeno tiene muchos Sintomas.
     *
     * @return BelongsToMany
     */
    public function sintomas(): BelongsToMany
    {
        // Usa la tabla pivote que definiste en la migración.
        return $this->belongsToMany(Sintoma::class, 'patogeno_sintoma');
    }

    /**
     * Relación N:M: Un Patogeno tiene muchos Tratamientos.
     *
     * @return BelongsToMany
     */
    public function tratamientos(): BelongsToMany
    {
        // Usa la tabla pivote que definiste en la migración.
        return $this->belongsToMany(Tratamiento::class, 'patogeno_tratamiento');
    }

    /**
     * Relación 1:N con imágenes adicionales del patógeno.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PatogenoImage::class, 'patogeno_id');
    }

    /**
     * Imagen principal (si existe) marcada con is_primary.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(PatogenoImage::class, 'patogeno_id')->where('is_primary', true);
    }
}