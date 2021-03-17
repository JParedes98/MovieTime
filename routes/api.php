<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// General Controllers
use App\Http\Controllers\General\MovieController;
use App\Http\Controllers\General\LikeController;


// Admin Controllers
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\MovieAdminController;
use App\Http\Controllers\Admin\MoviePosterAdminController;

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

    // AUTHENTICATION ROUTES
    Route::prefix('auth')->group(function () {
        Route::post('/login',                       [ AuthController::class, 'login'                         ]);
        Route::post('/register',                    [ AuthController::class, 'register'                      ]);
        Route::post('/logout',                      [ AuthController::class, 'logout'                        ]);
        Route::post('/email-verification',          [ AuthController::class, 'emailVerification'             ]);
        
        Route::post('/forgot-password',             [ AuthController::class, 'forgotPassword'                ]);
        Route::post('/reset-password',              [ AuthController::class, 'resetPassword'                 ]);
    });


    // GENERAL ROUTES
    Route::group([], function () {
        Route::get('/movies',                       [ MovieController::class, 'getMoviesForRentOrBuy'        ]);
        Route::get('/movies/{movie_id?}',           [ MovieController::class, 'getMovieDetails'              ]);
        Route::get('/movies/posters/{poster_id}',   [ MoviePosterAdminController::class, 'getMoviePoster'    ]);

        Route::group([ 'prefix' => 'movies', 'middleware' => ['api_jwt_auth', 'account_verification']], function () {
            Route::post('/rent',                    [ MovieController::class, 'rentMovie'                    ]);
            Route::post('/returnRentedMovie',       [ MovieController::class, 'returnRentedMovie'            ]);
            Route::post('/purchase',                [ MovieController::class, 'purchaseMovie'                ]);
            Route::post('/like/{movie_id}',         [ LikeController::class, 'likeMovie'                     ]);
            Route::post('/unlike/{movie_id}',       [ LikeController::class, 'unlikeMovie'                   ]);
        });        
    });


    // ADMIN ROUTES
    Route::group([ 'prefix' => 'admin', 'middleware' => ['api_jwt_auth', 'admin_access', 'account_verification']], function () {
        Route::prefix('users')->group(function () {
            Route::get('/',                         [ UserAdminController::class, 'getAllUsers'              ]);
            Route::put('/{user_id}',                [ UserAdminController::class, 'updateUserRol'            ]);
            Route::delete('/{user_id}',             [ UserAdminController::class, 'deleteUser'               ]);
        });

        Route::prefix('movies')->group(function () {
            Route::get('/{movie_id}',               [ MovieAdminController::class, 'getMovieByID'            ]);
            Route::get('/',                         [ MovieAdminController::class, 'getAllMovies'            ]);
            Route::post('/',                        [ MovieAdminController::class, 'storeNewMovie'           ]);
            Route::put('/{movie_id}',               [ MovieAdminController::class, 'updateMovie'             ]);
            Route::put('/remove/{movie_id}',        [ MovieAdminController::class, 'removeMovie'             ]);
            Route::delete('/{movie_id}',            [ MovieAdminController::class, 'deleteMovie'             ]);

            Route::prefix('posters')->group(function () {
                Route::post('/',                    [ MoviePosterAdminController::class, 'storeMoviePoster'  ]);
                Route::delete('/{poster_id}',       [ MoviePosterAdminController::class, 'deleteMoviePoster' ]);
            });
        });
    });
});