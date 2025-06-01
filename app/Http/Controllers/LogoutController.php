<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Make API call to invalidate the token on the server
        $response = Http::withToken(session('api_token'))->post(config('app.url').'/api/logout');

        // If API call was successful, clear local session
        if ($response->successful()) {
            // Remove API token from session
            session()->forget('api_token');
            // Logout the user
            Auth::logout();
            // Invalidate the session
            $request->session()->invalidate();
            // Regenerate CSRF token
            $request->session()->regenerateToken();
            // Redirect to home page
            return redirect('/');
        }

        // If logout failed, redirect back with error message
        return redirect()->back()->with('error', 'Failed to log out');
    }
}
