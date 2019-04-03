<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!\Auth::guard('api')->check()){
        return response()->json(
            [
                'status' => false,
                'message' => 'Unauthorised user.',
                'data' => (object)[]
            ], UNAUTHORIZED);
        }
        return $next($request);
    }
}
