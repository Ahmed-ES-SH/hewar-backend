<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CookieToAuthorization
{
    public function handle(Request $request, Closure $next)
    {
        // Check if cookie "auth_token" exists
        if ($request->hasCookie('auth_token') && !$request->bearerToken()) {
            // Add Authorization header dynamically
            $token = $request->cookie('auth_token');
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
