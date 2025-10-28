<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Alarma
 *
 * Representa las notificaciones o alertas críticas que se disparan
 * cuando se detectan ciertas condiciones (usualmente la presencia de un Patógeno)
 * durante un Diagnóstico.
 *
 * @property int $id
 * @property int $patogeno_id ID del patógeno que activó la alarma.
 * @property int|null $diagnostico_id ID del diagnóstico asociado, si aplica.
 * @property string $nivel_prioridad Nivel de riesgo (Ej: 'Baja', 'Media', 'Alta', 'Crítica').
 * @property string $mensaje_alerta Descripción clara de la alerta.
 * @property string $fecha_hora_activacion Marca de tiempo de la activación.
 * @property string $estado Estado actual de la alarma (Ej: 'Activa', 'Resuelta', 'Ignorada').
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Alarma extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'alarmas';

    // Indica que Laravel debe manejar las columnas created_at y updated_at
    public $timestamps = true;

    // Atributos que pueden ser asignados masivamente (Mass Assignable)
    protected $fillable = [
        'patogeno_id',
        'diagnostico_id',
        'nivel_prioridad',
        'mensaje_alerta',
        'fecha_hora_activacion',
        'estado',
    ];

    // Aseguramos que ciertos campos se traten como fechas
    protected $casts = [
        'fecha_hora_activacion' => 'datetime',
    ];

    /**
     * Relación: Una Alarma pertenece a un Patógeno.
     * @return BelongsTo
     */
    public function patogeno(): BelongsTo
    {
        // Asume que la clave foránea es 'patogeno_id'
        return $this->belongsTo(Patogeno::class);
    }

    /**
     * Relación: Una Alarma pertenece a un Diagnóstico (opcional).
     * @return BelongsTo
     */
    public function diagnostico(): BelongsTo
    {
        // Asume que la clave foránea es 'diagnostico_id'
        return $this->belongsTo(Diagnostico::class);
    }
}