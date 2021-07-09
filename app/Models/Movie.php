<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tmdb\Laravel\Facades\Tmdb;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;


class Movie extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    protected $appends = [
        'poster_url',
        'backdrop_url',
        'release_year',
        'yes_votes',
        'no_votes',
        'total_votes'
    ];

    public function getReleaseYearAttribute() {
        $date = new \DateTime($this->data["release_date"] ?? '');
        return $date->format('Y');
    }

    public function getPosterUrlAttribute() {
        return 'https://image.tmdb.org/t/p/w500' . $this->data['poster_path'];
    }

    public function getBackdropUrlAttribute() {
        return 'https://image.tmdb.org/t/p/w1280' . $this->data['backdrop_path'];
    }

    public function getYesVotesAttribute() {
        return MovieRatings::where([
            "movie_id" => $this->id,
            "score" => 1
            ])->count();
    }

    public function getNoVotesAttribute() {
        return MovieRatings::where([
            "movie_id" => $this->id,
            "score" => -1
        ])->count();
    }

    public function getTotalVotesAttribute() {
        return MovieRatings::where([
            "movie_id" => $this->id
        ])->count();
    }

    public static function cacheAll($movies) {
        $cachedMovies = [];

        foreach($movies as $movie) {
            $cachedMovie = Movie::firstOrNew([
                'id' => $movie->id
            ]);

            $cachedMovie->data = $movie;
            $cachedMovie->save();

            array_push($cachedMovies, $cachedMovie);
        }
    }

    public static function find_or_fetch($id) {
        $movie = Movie::find($id);

        if($movie == null) {
            try {
                $movie_data = Tmdb::getMoviesApi()->getMovie($id);

                $movie = new Movie();
                $movie->id = $movie_data["id"];
                $movie->data = $movie_data;

                if($movie->save()) {
                    return $movie;
                } else {
                    return null;
                }
            } catch(\Exception $e) {
                return null;
            }
        } else {
            return $movie;
        }
    }
}
