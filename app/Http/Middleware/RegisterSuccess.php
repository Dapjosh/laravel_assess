<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegisterSuccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!auth()->check() && auth()->user()->registration_status == 0) {
            return response()->json(['data' => 'You have not completed your registration'], 403);
        }
        return $next($request);
    }
}
