<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ADDED: Import Auth facade

/**
 * Middleware to check if the authenticated user is an administrator.
 */
class Admin
{
    /**
     * Handle an incoming request.
     *
     * Checks if the authenticated user is an admin. If they are, the request
     * proceeds. Otherwise, the user is redirected to the home page with
     * an unauthorized access error message.
     *
     * @param  \Illuminate\Http\Request  $request The incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next The next middleware or request handler.
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirect non-admins to home or show 403
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
