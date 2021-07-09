<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tmdb\Laravel\Facades\Tmdb;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Tmdb::getMoviesApi()->getTopRated()['results'];
        return view('home', [ 'movies' => $movies ]);
    }
}
