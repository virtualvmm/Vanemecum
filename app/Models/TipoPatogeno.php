<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importación necesaria

/**
 * TipoPatogeno Model
 * * Representa la clasificación de un Patógeno (e.g., bacteria, virus, hongo).
 * Es el lado "uno" de la relación uno a muchos (1:N) con Patogeno.
 */
class TipoPatogeno extends Model
{
    use HasFactory;

    protected $table = 'tipo_patogenos'; 

    /**
     * Los atributos que se pueden asignar masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion', // Suponemos que tiene un campo de descripción
    ];

    /**
     * Define la relación 1:N con Patogeno.
     * Un TipoPatogeno puede tener muchos Patógenos.
     *
     * @return HasMany
     */
    public function patogenos(): HasMany
    {
        return $this->hasMany(Patogeno::class, 'tipo_patogeno_id');
    }

    /** Clases CSS para badge por tipo. */
    public function badgeClass(): string
    {
        return match ($this->nombre ?? '') {
            'Virus' => 'bg-red-100 text-red-800',
            'Bacterias' => 'bg-blue-100 text-blue-800',
            'Hongos' => 'bg-green-100 text-green-800',
            'Parásitos' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /** Borde izquierdo para tarjeta por tipo. */
    public function borderClass(): string
    {
        return match ($this->nombre ?? '') {
            'Virus' => 'border-l-4 border-red-500',
            'Bacterias' => 'border-l-4 border-blue-500',
            'Hongos' => 'border-l-4 border-green-500',
            'Parásitos' => 'border-l-4 border-amber-500',
            default => 'border-l-4 border-gray-400',
        };
    }

    /** Fondo del pie de tarjeta por tipo. */
    public function cardFooterClass(): string
    {
        return match ($this->nombre ?? '') {
            'Virus' => 'bg-red-50 text-red-900',
            'Bacterias' => 'bg-blue-50 text-blue-900',
            'Hongos' => 'bg-green-50 text-green-900',
            'Parásitos' => 'bg-amber-50 text-amber-900',
            default => 'bg-gray-50 text-gray-900',
        };
    }

    /** Fondo placeholder sin imagen. */
    public function placeholderBgClass(): string
    {
        return match ($this->nombre ?? '') {
            'Virus' => 'bg-red-600',
            'Bacterias' => 'bg-blue-600',
            'Hongos' => 'bg-green-600',
            'Parásitos' => 'bg-amber-600',
            default => 'bg-gray-500',
        };
    }

    /** Clase de texto para etiqueta (pie de tarjeta). */
    public function labelClass(): string
    {
        return match ($this->nombre ?? '') {
            'Virus' => 'text-red-600 font-medium',
            'Bacterias' => 'text-blue-600 font-medium',
            'Hongos' => 'text-green-600 font-medium',
            'Parásitos' => 'text-amber-600 font-medium',
            default => 'text-gray-600 font-medium',
        };
    }
}