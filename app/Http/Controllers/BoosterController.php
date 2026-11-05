<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\UserCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoosterController extends Controller
{
    public const SIZE = 5;       // cartes par booster
    public const MIN_LEVEL = 5;
    public const MAX_LEVEL = 60;

    /**
     * Ouvre un booster : le TIRAGE se fait ici, côté serveur (impossible de tricher depuis le navigateur).
     * Cartes 1 à 4 : jamais shiny. Carte 5 : toujours shiny. Espèces toutes différentes dans un booster.
     */
    public function open(Request $request): JsonResponse
    {
        $user = $request->user();
        $catalog = Pokemon::all();

        if ($catalog->count() < self::SIZE) {
            return response()->json([
                'message' => 'Le catalogue est vide. Lance « php artisan pokemon:import » puis réessaie.',
            ], 503);
        }

        // Espèces déjà possédées avant ce booster (pour le badge « Nouveau »)
        $ownedIds = UserCard::where('user_id', $user->id)->pluck('pokemon_id')->unique()->flip();

        $normals = $catalog->shuffle()->take(self::SIZE - 1)->values();
        $shinyPick = $catalog
            ->reject(fn (Pokemon $p) => $normals->contains('id', $p->id))
            ->random();

        $slots = $normals
            ->map(fn (Pokemon $p) => ['pokemon' => $p, 'shiny' => false])
            ->push(['pokemon' => $shinyPick, 'shiny' => true]);

        $cards = DB::transaction(function () use ($slots, $user, $ownedIds) {
            return $slots->map(function (array $slot) use ($user, $ownedIds) {
                /** @var Pokemon $p */
                $p = $slot['pokemon'];
                $shiny = $slot['shiny'];

                $level = random_int(self::MIN_LEVEL, self::MAX_LEVEL);
                $genre = random_int(0, 1) === 1;
                $life = $p->base_hp + $level;

                $card = UserCard::create([
                    'user_id'     => $user->id,
                    'pokemon_id'  => $p->id,
                    'level'       => $level,
                    'genre'       => $genre,
                    'life'        => $life,
                    'is_shiny'    => $shiny,
                    'obtained_at' => now(),
                ]);

                return [
                    'id'          => $card->id,
                    'number'      => $p->number,
                    'name'        => $p->name,
                    'image'       => ($shiny && $p->shiny_image) ? $p->shiny_image : $p->image,
                    'level'       => $level,
                    'genre'       => $genre,
                    'life'        => $life,
                    'height'      => $p->height,
                    'weight'      => $p->weight,
                    'is_shiny'    => $shiny,
                    'obtained_at' => $card->obtained_at->format('d/m/Y'),
                    'is_new'      => ! $ownedIds->has($p->id),
                ];
            })->all();
        });

        return response()->json(['cards' => $cards]);
    }
}
