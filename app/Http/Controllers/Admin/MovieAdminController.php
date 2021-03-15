<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Movie;
use App\Models\MoviePoster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieAdminController extends Controller {
     /**
     * Create a new MovieAdminController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin_access', [ 'except' => [] ]);
        $this->middleware('api_jwt_auth', [ 'except' => [] ]);
    }

    /**
     * Send a listing of all movies.
     */
    public function getAllMovies(Request $request) {

        try {
            if ($request->has('availability')) {
                $movies = Movie::where('availability', $request->availability)
                                ->orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                                ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

                return response()->json($movies, 200);
            } else {
                $movies = Movie::orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                                ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

                return response()->json($movies, 200);
            }

        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * Send movie with specified ID.
     */
    public function getMovieByID($movie_id) {
        $movie = Movie::findOrFail($movie_id);

        return response()->json($movie, 200);
    }

    /**
     * Store a newly created movie.
     */
    public function storeNewMovie(Request $request) {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:250',
            'description'   => 'required|string|max:1000',
            'stock'         => 'required|integer|min:0',
            'rental_price'  => 'required|numeric',
            'sale_price'    => 'required|numeric',
            'availability'  => 'required|boolean',
            'posters.*'       => 'sometimes|mimes:jpg,png|max:10240'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $movie = Movie::create([
            'title'         =>$request->title,
            'description'   => $request->description,
            'stock'         => $request->stock,
            'rental_price'  => $request->rental_price,
            'sale_price'    => $request->sale_price,
            'availability'  => $request->availability
        ]);

        if($request->posters) {
            foreach ($request->posters as $poster) {
                $file = MoviePoster::create([
                    'movie_id' => $movie->id,
                    'name'      => $poster->getClientOriginalName(),
                    'extension' => $poster->getMimeType(),
                    'object'    => file_get_contents($poster),
                ]);
            }
        }

        return response()->json($movie, 200);
    }

    /**
     * Update the movie with specified ID.
    */
    public function updateMovie(Request $request, $movie_id) {
        $validator = Validator::make($request->all(), [
            'title'         => 'sometimes|string|max:250',
            'description'   => 'sometimes|string|max:1000',
            'stock'         => 'sometimes|integer|min:0',
            'rental_price'  => 'sometimes|numeric',
            'sale_price'    => 'sometimes|numeric',
            'availability'  => 'sometimes|boolean',
            'posters.*'       => 'sometimes|mimes:jpg,png|max:10240'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }


        $movie = Movie::findOrFail($movie_id);
            if( $request->has('title'))          { $movie->title         = $request->title;         }
            if( $request->has('description'))    { $movie->description   = $request->description;   }
            if( $request->has('stock'))          { $movie->stock         = $request->stock;         }
            if( $request->has('rental_price'))   { $movie->rental_price  = $request->rental_price;  }
            if( $request->has('sale_price'))     { $movie->sale_price    = $request->sale_price;    }
            if( $request->has('availability'))   { $movie->availability  = $request->availability;  }
        $movie->save();

        return response()->json($movie, 200);
    }

    /**
     * Update the availability of the movie with specified ID.
    */
    public function removeMovie(Request $request, $movie_id) {
        $movie = Movie::findOrFail($movie_id);
            $movie->availability = !$movie->availability;
        $movie->save();

        return response()->json($movie, 200);
    }

    /**
     * Delete the movie with the specified ID.
     */
    public function deleteMovie(Request $request, $movie_id) {
        $movie = Movie::findOrFail($movie_id)->delete();

        return response()->json($movie_id, 200);
    }
}
