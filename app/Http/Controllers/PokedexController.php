<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PokedexController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $catalog = Pokemon::orderBy('number')->get();
        $cards = UserCard::where('user_id', $user->id)->get()->groupBy('pokemon_id');

        // Une entrée par place du Pokédex : carte possédée (la meilleure) ou case vide
        $entries = $catalog->map(function (Pokemon $p) use ($cards) {
            $owned = $cards->get($p->id);

            if (! $owned || $owned->isEmpty()) {
                return [
                    'owned'  => false,
                    'number' => $p->number,
                    'name'   => $p->name,
                    'image'  => $p->image,
                ];
            }

            // La meilleure carte : shiny d'abord, puis le niveau le plus haut
            $best = $owned->sortByDesc(fn ($c) => ($c->is_shiny ? 1000 : 0) + $c->level)->first();

            return [
                'owned'       => true,
                'number'      => $p->number,
                'name'        => $p->name,
                'image'       => ($best->is_shiny && $p->shiny_image) ? $p->shiny_image : $p->image,
                'level'       => $best->level,
                'genre'       => (bool) $best->genre,
                'life'        => $best->life,
                'height'      => $p->height,
                'weight'      => $p->weight,
                'is_shiny'    => (bool) $best->is_shiny,
                'obtained_at' => $best->obtained_at?->format('d/m/Y'),
                'count'       => $owned->count(),
            ];
        })->values();

        return view('pokemons-livre', [
            'user'       => $user,
            'entries'    => $entries,
            'ownedCount' => $entries->where('owned', true)->count(),
            'total'      => $entries->count(),
            'maxLife'    => max(100, (int) $catalog->max('base_hp') + BoosterController::MAX_LEVEL),
            'packArt'    => $catalog->pluck('image')->values(),
        ]);
    }
}
