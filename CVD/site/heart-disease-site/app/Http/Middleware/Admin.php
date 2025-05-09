<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ADDED: Import Auth facade

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
