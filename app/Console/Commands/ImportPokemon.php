<?php

namespace App\Console\Commands;

use App\Models\Pokemon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportPokemon extends Command
{
    protected $signature = 'pokemon:import {--limit=151 : Nombre de Pokémon à importer, à partir du n°1}';

    protected $description = 'Importe les premiers Pokémon depuis PokéAPI dans le catalogue (peut être relancé sans risque)';

    public function handle(): int
    {
        $limit = max(1, min(1025, (int) $this->option('limit')));

        $this->info("Import de {$limit} Pokémon depuis PokéAPI (environ 2 minutes)...");
        $bar = $this->output->createProgressBar($limit);
        $bar->start();

        $imported = 0;
        $failed = [];

        for ($number = 1; $number <= $limit; $number++) {
            try {
                $pokemon = Http::retry(3, 700)->timeout(20)
                    ->get("https://pokeapi.co/api/v2/pokemon/{$number}")->throw()->json();
                $species = Http::retry(3, 700)->timeout(20)
                    ->get("https://pokeapi.co/api/v2/pokemon-species/{$number}")->throw()->json();

                $names = collect($species['names'] ?? []);
                $name = data_get($names->firstWhere('language.name', 'fr'), 'name')
                    ?? ucfirst((string) $pokemon['name']);

                $artwork = data_get($pokemon, 'sprites.other.official-artwork', []);
                $image = $artwork['front_default'] ?? data_get($pokemon, 'sprites.front_default');
                $shiny = $artwork['front_shiny'] ?? data_get($pokemon, 'sprites.front_shiny');

                if (! $image) {
                    throw new \RuntimeException('aucune image trouvée');
                }

                $hp = data_get(collect($pokemon['stats'] ?? [])->firstWhere('stat.name', 'hp'), 'base_stat', 50);

                Pokemon::updateOrCreate(
                    ['number' => $number],
                    [
                        'name'        => $name,
                        'image'       => $image,
                        'shiny_image' => $shiny,
                        'height'      => ((float) $pokemon['height']) / 10, // décimètres -> mètres
                        'weight'      => ((float) $pokemon['weight']) / 10, // hectogrammes -> kg
                        'base_hp'     => (int) $hp,
                    ]
                );

                $imported++;
            } catch (\Throwable $e) {
                $failed[$number] = $e->getMessage();
            }

            $bar->advance();
            usleep(50000); // on ménage l'API gratuite
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("{$imported} Pokémon importés.");

        if ($failed) {
            $this->error(count($failed) . ' échec(s) :');
            foreach (array_slice($failed, 0, 5, true) as $number => $message) {
                $this->line("  n°{$number} : {$message}");
            }
            $this->line('Relance la commande : les Pokémon déjà importés sont simplement mis à jour.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
