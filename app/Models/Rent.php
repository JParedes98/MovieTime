<?php

namespace App\Models;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'user_id',
        'due_at',
        'returned_at',
        'late_fee',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];


    //------------------------------------------------------- RELATIONSHIPS -------------------------------------------------------

    /**
     * Get the User that rented the Movie
     *
    */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the User that rented the Movie
     *
    */
    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    //----------------------------------------------------------------------------------------------------------------------------
}
