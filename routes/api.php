<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\MoviePosterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    
    Route::prefix('admin')->group(function () {
        Route::get('/movies',                        [ MovieController::class, 'getAllMovies'        ]);
        Route::get('/movies/{movie_id}',             [ MovieController::class, 'getMovieByID'        ]);
        Route::post('/movies',                       [ MovieController::class, 'storeNewMovie'       ]);
        Route::put('/movies/{movie_id}',             [ MovieController::class, 'updateMovie'         ]);
        Route::put('/movies/availability/{movie_id}',[ MovieController::class, 'updateavailability'  ]);
        Route::delete('/movies/{movie_id}',          [ MovieController::class, 'deleteMovie'         ]);

        Route::prefix('movies/posters')->group(function () {
            Route::get('/{poster_id}',      [ MoviePosterController::class, 'getMoviePoster']);
            Route::post('/',                [ MoviePosterController::class, 'storeMoviePoster']);
            Route::delete('/{poster_id}',   [ MoviePosterController::class, 'deleteMoviePoster']);
        });
    });

});
