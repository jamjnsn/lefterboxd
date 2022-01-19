<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

$baseUrl = Config::get('app.base_url');

if($baseUrl) {
    URL::forceRootUrl($baseUrl);
}

Route::middleware('auth')->group(function() {
    Route::get('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'get']);
    Route::post('/movie/{id}/vote', [App\Http\Controllers\VoteController::class, 'vote']);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
