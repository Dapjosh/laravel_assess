<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Invitations;

class HasInvitation
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
        $email = $request->email;
        $invitations = Invitations::where('email',$email)->first();
        if ($invitations == null ) {
            return response()->json(['data' => 'Access Forbidden, you dont have an invitation link'], 403);
        }
        return $next($request);
    }
}
