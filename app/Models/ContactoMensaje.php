<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactoMensaje extends Model
{
    use HasFactory;

    protected $table = 'contacto_mensajes';

    protected $fillable = [
        'nombre',
        'email',
        'asunto',
        'mensaje',
        'leido',
        'user_id',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    /**
     * Relación opcional con User (si el mensaje viene de un usuario autenticado)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

