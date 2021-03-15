<?php

namespace App\Models;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoviePoster extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'name',
        'extension',
        'object',
    ];

    //------------------------------------------------------- RELATIONSHIPS -------------------------------------------------------

    /**
     * Get the movie that owns the MoviePoster
     *
    */
    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    //----------------------------------------------------------------------------------------------------------------------------
}
