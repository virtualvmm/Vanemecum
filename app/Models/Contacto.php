<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Contacto
 * * Representa la información de una persona de contacto o punto de notificación.
 * Es una tabla auxiliar para sistemas de alerta.
 */
class Contacto extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'organizacion',
        'email',
        'telefono',
        'rol_emergencia', // Ejemplo: "Jefe de Laboratorio", "Coordinador de Bioseguridad"
    ];

    // Esta tabla puede usarse como destino en futuras relaciones (ej. belongsToMany con Patogeno),
    // pero por ahora la dejamos como una entidad de datos simple.
}