<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Checks if the authenticated user has admin privileges before granting access
     * to protected admin routes. Redirects to admin login page with error message
     * if user is not authorized.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has admin privileges
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            // User is admin - allow request to proceed
            return $next($request);
        }

        // User is not admin - redirect to admin login with error message
        return redirect()->route('admin.login')->with('error', 'Unauthorized admin access');
    }
}
