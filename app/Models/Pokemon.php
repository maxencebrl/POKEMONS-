<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Catalogue : un Pokémon du Pokédex (importé depuis PokéAPI).
 */
class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $guarded = [];

    public function cards(): HasMany
    {
        return $this->hasMany(UserCard::class);
    }
}
