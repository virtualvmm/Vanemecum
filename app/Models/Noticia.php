<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Noticia
 * * Representa un artículo, alerta o publicación dentro del sistema.
 */
class Noticia extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'titulo',
        'cuerpo',
        'categoria',
        'estado', // Puede ser 'Borrador', 'Publicado', 'Archivado'
        'fecha_publicacion',
    ];

    /**
     * Define la relación: Una Noticia pertenece a un Usuario (el autor).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function autor()
    {
        // Asume que la clave foránea es 'user_id' y referencia a App\Models\User
        return $this->belongsTo(User::class, 'user_id');
    }
}
