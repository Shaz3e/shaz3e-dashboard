<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Authenticate
        if (Auth::check()) {
            // Check if user is admin
            if (Auth::user() instanceof Admin) {
                return $next($request);
            } else {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        } else {
            // User not logged in
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
}
