<?php

namespace App\Http\Controllers\General;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    /**
     * Create a new MovieAdminController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin_access', [ 'except' => ['getMoviesForRentOrBuy'] ]);
        $this->middleware('api_jwt_auth', [ 'except' => ['getMoviesForRentOrBuy'] ]);
    }

    /**
     * Listing all movies or filtered by serch viarble.
     */
    public function getMoviesForRentOrBuy(Request $request) {
        if($request->has('search')) {
            $movies = Movie::where('title', 'like', '%' . $request->search . '%')
                            ->where('availability', 1)
                            ->orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                            ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

            return response()->json($movies, 200);

        } else {
            $movies = Movie::where('availability', 1)
                            ->orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                            ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

            return response()->json($movies, 200);
        }
    }

    /**
     * Rent the movie with the specified ID.
    */
    public function rentMovie(Request $request, $movie_id) {
    }


    /**
     * Buy the movie with the specified ID.
    */
    public function buyMovie(Request $request, $movie_id) {
    }
}
