<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
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

Route::group([ 'prefix' => 'v1'], function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login',       [ AuthController::class, 'login'    ]);
        Route::post('/register',    [ AuthController::class, 'register' ]);
        Route::post('/logout',      [ AuthController::class, 'logout'   ]);
    });

    Route::middleware(['api_jwt_auth', 'admin_access'])->group(function () {
        
        Route::prefix('admin')->group(function () {
            Route::prefix('movies')->group(function () {
                Route::get('/',                     [ MovieController::class, 'getAllMovies'        ]);
                Route::get('/{movie_id}',           [ MovieController::class, 'getMovieByID'        ]);
                Route::post('/',                    [ MovieController::class, 'storeNewMovie'       ]);
                Route::put('/{movie_id}',           [ MovieController::class, 'updateMovie'         ]);
                Route::put('/remove/{movie_id}',    [ MovieController::class, 'removeMovie'         ]);
                Route::delete('/{movie_id}',        [ MovieController::class, 'deleteMovie'         ]);

                Route::prefix('posters')->group(function () {
                    Route::get('/{poster_id}',          [ MoviePosterController::class, 'getMoviePoster']);
                    Route::post('/',                    [ MoviePosterController::class, 'storeMoviePoster']);
                    Route::delete('/{poster_id}',       [ MoviePosterController::class, 'deleteMoviePoster']);
                });
            });
        });

    });
});