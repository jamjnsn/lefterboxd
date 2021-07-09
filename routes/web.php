<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/movie/{id}',[App\Http\Controllers\MovieController::class, 'show'] )->name("movie");

Route::middleware('auth')->group(function() {
    Route::get('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'get']);
    Route::post('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'vote']);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
