<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    function show($id)
    {
        return view("movies/show", ['id' => $id]);
    }

    function get($id) {
        $movie = Movie::find_or_fetch($id);
        return $movie;
    }
}
