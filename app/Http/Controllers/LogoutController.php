<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $response = Http::withToken(session('api_token'))->post(config('app.url').'/api/logout');

        if ($response->successful()) {
            session()->forget('api_token');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }

        return redirect()->back()->with('error', 'Failed to log out');
    }
}
