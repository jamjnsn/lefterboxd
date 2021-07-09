<?php

namespace App\Http\Controllers;

use App\Models\CachedMovie;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function get($id) {
        $vote = Vote::where([
            'user_id' => Auth::user()->id,
            'movie_id' => $id
        ])->first();

        return $vote;
    }

    function vote($id, Request $request) {
        $movie = CachedMovie::findOrFetch($id);
        $option = $request->post('option');

        if($option == Vote::YES || $option == Vote::NO) {
            $vote = Vote::firstOrNew([
                'user_id' => Auth::user()->id,
                'movie_id' => $id
            ]);

            $vote->option = $request->post('option');
            $vote->save();
        }

        return $movie;
    }
}
