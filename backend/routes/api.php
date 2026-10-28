<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\WatchlistController;

Route::get('/anime', [AnimeController::class, 'index']);
Route::post('/anime', [AnimeController::class, 'store']);
Route::get('/anime/{id}', [AnimeController::class, 'show']);
Route::put('/anime/{id}', [AnimeController::class, 'update']);
Route::delete('/anime/{id}', [AnimeController::class, 'destroy']);

Route::get('/watchlist', [WatchlistController::class, 'index']);
Route::post('/watchlist', [WatchlistController::class, 'store']);
Route::get('/watchlist/{id}', [WatchlistController::class, 'show']);
Route::delete('/watchlist/{id}', [WatchlistController::class, 'destroy']);
