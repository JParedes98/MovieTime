<?php

namespace App\Http\Controllers\General;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller {
    /**
     * Create a new LikeController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('api_jwt_auth', [ 'except' => [''] ]);
    }

    /**
     * Like the movie with the specified ID.
    */
    public function likeMovie(Request $request, $movie_id) {
        $movie = Movie::findOrFail($movie_id);
        $user = auth()->user();

        $user->likedMovies()->attach($movie);

        return response()->json([ 'message' => 'Like added successfully.'], 200);
    }


    /**
     * Unlike the movie with the specified ID.
    */
    public function unlikeMovie(Request $request, $movie_id) {
        $movie = Movie::findOrFail($movie_id);
        $user = auth()->user();

        $attach = $user->likedMovies()->detach($movie);

        return response()->json([ 'message' => 'Like removed successfully.'], 200);
    }
}
