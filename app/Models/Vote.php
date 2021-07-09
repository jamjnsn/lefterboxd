<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public const YES = 'yes';
    public const NO = 'no';

    protected $fillable = [
        'movie_id', 'user_id', 'option'
    ];
}
