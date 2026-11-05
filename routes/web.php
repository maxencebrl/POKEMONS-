<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoosterController;
use App\Http\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;

// Anciennes adresses : on renvoie vers le Pokédex
Route::redirect('/', '/pokedex');
Route::redirect('/pokemons', '/pokedex');
Route::redirect('/pokemons/livre', '/pokedex');

// Pages réservées aux visiteurs non connectés
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
});

// Pages réservées aux joueurs connectés
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/pokedex', [PokedexController::class, 'index'])->name('pokedex');
    Route::post('/boosters/open', [BoosterController::class, 'open'])->name('boosters.open');
});
