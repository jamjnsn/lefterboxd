<?php

namespace App\Http\Controllers;

use App\Models\CachedMovie;
use Exception;
use Illuminate\Http\Request;
use Tmdb\Laravel\Facades\Tmdb;

class MovieController extends Controller
{
    function show($id)
    {
        return view("movies/show", ['id' => $id]);
    }

    function get($id) {
        $movie = CachedMovie::findOrFetch($id);
        return $movie;
    }

    function list(Request $request) {
        $search = $request->get('search', null);
        $page = $request->get('page', 1);

        $movies = [];

        if($search == null) {
            $results = Tmdb::getMoviesApi()->getTopRated([
                'region' => 'ca',
                'page' => $page
                ])['results'];
            $movies = CachedMovie::cacheAll($results);
        } else {
            $results = Tmdb::getSearchApi()->searchMovies($search)['results'];
            $movies = CachedMovie::cacheAll($results);
        }

        return $movies;
    }
}
