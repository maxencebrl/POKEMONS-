<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Une carte possédée par un joueur (tirée dans un booster).
 */
class UserCard extends Model
{
    protected $table = 'user_cards';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'genre'       => 'boolean',
            'is_shiny'    => 'boolean',
            'obtained_at' => 'datetime',
        ];
    }

    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
