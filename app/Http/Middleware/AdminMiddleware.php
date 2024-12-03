<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {

        if (!Auth::check()) {
            return response()->json([
                'error' => 'Please login first',
            ], 401); // 401 Unauthorized
        }

        if (in_array(Auth::user()->role, $role)) {
            return $next($request);
        }

        // Return a response if the role does not match
        return response()->json([
            'error' => 'Unauthorized access',
        ], 403); // 403 Forbidden
    }
}
