<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * La table "pokemons" devient le CATALOGUE (les 151 Pokémon importés depuis PokéAPI).
 * Les cartes que possède chaque joueur sont dans la table "user_cards".
 *
 * ATTENTION : cette migration supprime l'ancienne table "pokemons" (tes 33 Pokémon de test).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('user_cards');
        Schema::dropIfExists('pokemons');

        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('number')->unique(); // numéro dans le Pokédex (1 à 151)
            $table->string('name');                            // nom français
            $table->string('image');                           // image normale
            $table->string('shiny_image')->nullable();         // image shiny
            $table->float('height');                           // taille en mètres
            $table->float('weight');                           // poids en kg
            $table->unsignedSmallInteger('base_hp');           // points de vie de base
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
