<?php

namespace App\Models;

use App\Models\MoviePoster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'stock',
        'rental_price',
        'sale_price',
        'availability'
    ];

    // RELATIONSHIPS
    /**
     * Get all of the MoviePoster for this Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function posters(): HasMany
    {
        return $this->hasMany(MoviePoster::class);
    }
}
