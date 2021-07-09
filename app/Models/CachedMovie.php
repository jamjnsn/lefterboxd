<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tmdb\Laravel\Facades\Tmdb;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;


class CachedMovie extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    protected $appends = [
        'poster_url',
        'backdrop_url',
        'release_year',
        'counts'
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

    public function getVotesAttribute()
    {
        return Vote::where('movie_id', $this->id);
    }

    public function getCountsAttribute() {
        $yesCount = $this->votes->where('option', 'yes')->count();
        $noCount = $this->votes->where('option', 'no')->count();
        $totalCount = $this->votes->count();

        if($totalCount > 0) {
            if($yesCount > 0) {
                $yesPercent = round(($totalCount / $yesCount) * 100);
                $noPercent = 100 - $yesPercent;
            } else {
                $yesPercent = 0;
                $noPercent = 100;
            }
        } else {
            $yesPercent = 0;
            $noPercent = 0;
        }

        $counts = [
            'total' => $totalCount,
            'yes' => $yesCount,
            'no' => $noCount,
            'yesPercent' => $yesPercent,
            'noPercent' => $noPercent
        ];

        return $counts;
    }

    public static function cacheAll($movies) {
        $cachedMovies = [];

        foreach($movies as $movie) {
            $cachedMovie = CachedMovie::firstOrNew([
                'id' => $movie->id
            ]);

            $cachedMovie->data = $movie;
            $cachedMovie->save();

            array_push($cachedMovies, $cachedMovie);
        }
    }

    public static function findOrFetch($id) {
        $movie = CachedMovie::find($id);

        if($movie == null) {
            try {
                $movie_data = Tmdb::getMoviesApi()->getMovie($id);

                $movie = new CachedMovie();
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
