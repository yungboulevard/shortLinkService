<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-Token');

        if (!$token) {
            return response()->json(['error' => 'Token required.'], Response::HTTP_UNAUTHORIZED);
        }

        if ($token !== config('redirect.xApiToken')) { 
            return response()->json(['error' => 'Invalid token.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
