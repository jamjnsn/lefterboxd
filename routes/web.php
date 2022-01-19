<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

if(Config::get('app.base_url')) {
    URL::forceRootUrl(Config::get('app.base_url'));
}

if(Config::get('app.base_scheme')) {
    URL::forceScheme(Config::get('app.base_scheme'));
}

Route::middleware('auth')->group(function() {
    Route::get('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'get']);
    Route::post('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'vote']);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
