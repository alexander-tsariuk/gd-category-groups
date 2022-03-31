<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BackendSecurity {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->hasHeader('site_key') || !$request->hasHeader('site_id') || !$request->hasHeader('user_id')) {
            return response()->json([
                'message' => "Unauthorized request"
            ], 401);
        }

        return $next($request);
    }
}
