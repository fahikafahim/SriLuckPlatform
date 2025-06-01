<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request
     *
     * Validates user authentication and authorization before proceeding.
     * Only allows access to users with 'user' type, redirects all others.
     *   Implicitly throws authentication exception if user not logged in
     */
    public function handle(Request $request, Closure $next)
    {
        // Verify user is authenticated and has standard user privileges
        if (Auth::check() && Auth::user()->user_type === 'user') {
            // Authorization passed - continue request processing
            return $next($request);
        }

        // Authorization failed - redirect to login with error message
        return redirect()
            ->route('user.login')
            ->with('error', 'Unauthorized user access. Please login as a registered user.');
    }
}
