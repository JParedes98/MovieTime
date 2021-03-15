<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
        'quantity',
        'sub_total',
        'taxes',
        'total',
        'purchased_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'purchased_at' => 'datetime',
    ];


    //------------------------------------------------------- RELATIONSHIPS -------------------------------------------------------

    /**
     * Get the User that purchased the Movie
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
