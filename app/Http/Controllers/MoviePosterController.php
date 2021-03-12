<?php

namespace App\Http\Controllers;

use Response;
use Validator;
use App\Models\Movie;
use App\Models\MoviePoster;
use Illuminate\Http\Request;

class MoviePosterController extends Controller
{
    /**
     * Send movie poster with specified ID.
     */
    public function getMoviePoster($poster_id) {
        $poster = MoviePoster::where('id', $poster_id)->first();

        if($poster) {
            return Response::make($poster->object, 200)->header('Content-Type', $poster->extension);
        } else {
            return redirect('/no_image.png');
        }
    }

    /**
     * Store a newly created movie poster.
     */
    public function storeMoviePoster(Request $request) {
        $validator = Validator::make($request->all(), [
            'movie_id'  => 'required|integer',
            'posters.*' => 'sometimes|mimes:jpg,png|max:10240'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $movie = Movie::findOrFail($request->movie_id);
        foreach ($request->posters as $poster) {
            $file = MoviePoster::create([
                'movie_id' => $movie->id,
                'name'      => $poster->getClientOriginalName(),
                'extension' => $poster->getMimeType(),
                'object'    => file_get_contents($poster),
            ]);
        }

        return response()->json($movie, 200);
    }

    /**
     * Delete the movie with the specified ID.
    */
    public function deleteMoviePoster(Request $request, $poster_id) {
        $poster = MoviePoster::findOrFail($poster_id)->delete();

        return response()->json($poster, 200);
    }
}
