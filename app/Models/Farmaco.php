<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Farmaco extends Model
{
    use HasFactory;

    // Conecta este modelo con la tabla 'farmacos' definida en tu SQL.
    protected $table = 'farmacos';

    // Tu script SQL tiene los campos created_at y updated_at, por lo que los mantenemos activos.
    public $timestamps = true;

    protected $fillable = [
        'nombre', 
        'principio_activo', 
        'categoria'
    ];
    
    /**
     * Relación Muchos a Muchos con Patogenos.
     * Un fármaco puede tratar múltiples patógenos.
     * (Tabla Pivote: patogeno_farmaco)
     */
    public function patogenos(): BelongsToMany
    {
        return $this->belongsToMany(Patogeno::class, 'patogeno_farmaco', 'farmaco_id', 'patogeno_id');
    }
}