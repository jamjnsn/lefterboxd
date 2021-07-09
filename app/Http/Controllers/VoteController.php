<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieRatings;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function get($id) {
        $vote = MovieRatings::where([
            'user_id' => Auth::user()->id,
            'movie_id' => $id
        ])->first();

        return $vote;
    }

    function vote($id, Request $request) {
        $movie = Movie::find_or_fetch($id);

        $vote = MovieRatings::firstOrNew([
            'user_id' => Auth::user()->id,
            'movie_id' => $id
        ]);

        $vote->score = $request->post('score');
        $vote->save();

        return $movie;
    }
}
