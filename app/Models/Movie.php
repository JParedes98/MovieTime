<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rent;
use App\Models\MoviePoster;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['title', 'rental_price', 'sale_price'];


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

    //------------------------------------------------------- RELATIONSHIPS -------------------------------------------------------

    /**
     * Get all of the MoviePoster for this Movie
     *
    */
    public function posters() {
        return $this->hasMany(MoviePoster::class);
    }

    /**
     * Get the users who liked the Movie
     *
     */
    public function usersLikes() {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();;
    }

    /**
     * Get all Rentals for the Movie
     *
    */
    public function rentals() {
        return $this->hasMany(Rent::class);
    }
    //----------------------------------------------------------------------------------------------------------------------------
}
