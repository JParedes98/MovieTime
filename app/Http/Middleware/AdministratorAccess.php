<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdministratorAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {

        $user = auth()->user();

        if(!$user || !$user->is_admin) {
            return response()->json([ 'mesage' => 'You do not have administrator access.' ], 401);
        }

        return $next($request);
    }
}
