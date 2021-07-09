<?php

namespace App\Http\Controllers;

use App\Models\CachedMovie;
use Exception;
use Illuminate\Http\Request;

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
}
