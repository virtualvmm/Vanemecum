<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatogenoImage extends Model
{
    use HasFactory;

    protected $table = 'patogeno_images';

    protected $fillable = [
        'patogeno_id',
        'path',
        'caption',
        'is_primary',
    ];

    public function patogeno(): BelongsTo
    {
        return $this->belongsTo(Patogeno::class, 'patogeno_id');
    }
}


