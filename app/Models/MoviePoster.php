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

    // RELATIONSHIPS
    /**
     * Get the movie that owns the MoviePoster
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
