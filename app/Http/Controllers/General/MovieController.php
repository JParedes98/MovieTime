<?php

namespace App\Http\Controllers\General;

use Validator;
use Carbon\Carbon;
use App\Models\Movie;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    /**
     * Create a new MovieController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('api_jwt_auth', [ 'except' => ['getMoviesForRentOrBuy', 'getMovieDetails'] ]);
    }

    /**
     * Listing all movies or filtered by serch viarble.
     */
    public function getMoviesForRentOrBuy(Request $request) {
        if($request->has('search')) {
            $movies = Movie::where('title', 'like', '%' . $request->search . '%')
                            ->where('availability', 1)
                            ->orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                            ->select('id', 'title', 'description', 'stock', 'rental_price', 'sale_price')
                            ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

            return response()->json($movies, 200);

        } else {
            $movies = Movie::where('availability', 1)
                            ->orderBy($request->has('sort_by_populatity') ? 'stock' : 'title', $request->has('sort_order') ? $request->sort_order : 'desc')
                            ->select('id', 'title', 'description', 'stock', 'rental_price', 'sale_price')
                            ->paginate($request->has('paginate_each') ? $request->paginate_each : 10);

            return response()->json($movies, 200);
        }
    }

    /**
     * Display the movie and its details with the specified ID.
     */
    public function getMovieDetails(Request $request, $movie_id) {
        $movie = Movie::where('availability', 1)
                        ->select('id', 'title', 'description', 'stock', 'rental_price', 'sale_price')
                        ->findOrFail($movie_id);

        return response()->json($movie, 200);
    }

    /**
     * Rent the movie with the specified ID.
    */
    public function rentMovie(Request $request) {
        $validator = Validator::make($request->all(), [
            'movie_id'  => 'required|integer',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $movie = Movie::findOrFail($request->movie_id);
        $user = auth()->user();

        if($movie->stock == 0) {
            return response()->json([ 'message' => 'Movie out of stock.'], 400);
        }

        if(!$movie->availability) {
            return response()->json([ 'message' => 'Movie not available.'], 400);
        }

        $rent = Rent::create([
            'movie_id' => $movie->id,
            'user_id'   => $user->id,
            'due_at'   => Carbon::now()->addDays(2),
        ]);

        $movie->stock--;
        $movie->save();

        return response()->json($rent, 200);
    }

    /**
     * Return the Rented movie with the specified ID.
    */
    public function returnRentedMovie(Request $request) {
        $validator = Validator::make($request->all(), [
            'rent_id'  => 'required|integer',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $rent = Rent::findOrFail($request->rent_id);
        $movie = $rent->movie;

        $rent->returned_at = Carbon::now();
        if(Carbon::now() > $rent->due_at) {
            $rent->late_fee = 50.00;
        }
        $movie->stock++;

        $rent->save();
        $movie->save();


        return response()->json($rent, 200);
    }

    /**
     * Buy the movie with the specified ID.
    */
    public function buyMovie(Request $request) {
    }
}
