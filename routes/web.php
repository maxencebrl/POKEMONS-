<?php

use Illuminate\Support\Facades\Route;

Route::get('/pokemons', function () {
    $pokemons = \App\Models\Pokemon::all();

    return view('pokemons', ['pokemons' => $pokemons]);
});