<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Une ligne = une carte tirée dans un booster par un joueur.
 * Si le joueur tire deux fois le même Pokémon, il y a deux lignes (le Pokédex affiche ×2).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pokemon_id')->constrained('pokemons')->cascadeOnDelete();
            $table->unsignedSmallInteger('level');
            $table->boolean('genre');                 // false = mâle, true = femelle
            $table->unsignedSmallInteger('life');
            $table->boolean('is_shiny')->default(false);
            $table->dateTime('obtained_at');
            $table->timestamps();

            $table->index(['user_id', 'pokemon_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
