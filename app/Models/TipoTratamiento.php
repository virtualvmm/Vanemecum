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

    /** Clases CSS para badge por tipo (comparación insensible a mayúsculas). */
    public function badgeClass(): string
    {
        $nombre = mb_strtolower(trim((string) ($this->nombre ?? '')));
        return match ($nombre) {
            'antiviral' => 'bg-red-100 text-red-800 border-red-500',
            'antibiótico', 'antibiotico' => 'bg-blue-100 text-blue-800 border-blue-500',
            'antifúngico', 'antifungico' => 'bg-green-100 text-green-800 border-green-500',
            'soporte' => 'bg-amber-100 text-amber-800 border-amber-500',
            default => 'bg-gray-100 text-gray-800 border-gray-400',
        };
    }

    /** Borde izquierdo para fila por tipo. */
    public function rowBorderClass(): string
    {
        $nombre = mb_strtolower(trim((string) ($this->nombre ?? '')));
        return match ($nombre) {
            'antiviral' => 'border-l-4 border-red-500',
            'antibiótico', 'antibiotico' => 'border-l-4 border-blue-500',
            'antifúngico', 'antifungico' => 'border-l-4 border-green-500',
            'soporte' => 'border-l-4 border-amber-500',
            default => 'border-l-4 border-gray-400',
        };
    }
}


