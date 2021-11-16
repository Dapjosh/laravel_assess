<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *  @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {

        if (!auth()->check() && auth()->user()->user_role==0 ) {
            return response()->json(['data' => 'Access Forbidden'], 403);
        }

        return $next($request);
    }
}
