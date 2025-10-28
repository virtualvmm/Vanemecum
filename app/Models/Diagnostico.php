<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Diagnostico
 * * Representa un proceso de diagnóstico o un evento de monitoreo.
 * Contiene el resultado del proceso y puede tener múltiples alarmas asociadas.
 */
class Diagnostico extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'patogeno_id',
        'resultado', // Ejemplo: 'Detectado', 'No Detectado', 'Inconcluso'
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'detalles_adicionales',
    ];
    
    // --- RELACIONES DE ELOQUENT ---

    /**
     * Un Diagnóstico tiene muchas Alarmas asociadas.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alarmas()
    {
        // En este caso, el Diagnóstico es el padre de la relación.
        return $this->hasMany(Alarma::class);
    }

    /**
     * Un Diagnóstico está asociado a un Patógeno específico.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patogeno()
    {
        // La clave foránea 'patogeno_id' está en esta tabla.
        return $this->belongsTo(Patogeno::class);
    }
}