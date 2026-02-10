<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'tipo',
        'mensaje',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    /** Tipos de consulta (motivos) para el formulario y listado */
    public static function getTiposConsulta(): array
    {
        return [
            'error' => 'Reportar un error en la aplicación',
            'nuevo_patogeno' => 'Sugerir añadir un nuevo patógeno',
            'otro' => 'Otra consulta o sugerencia',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Etiqueta del tipo para mostrar en la vista */
    public function getTipoLabelAttribute(): string
    {
        return self::getTiposConsulta()[$this->tipo] ?? $this->tipo;
    }
}
