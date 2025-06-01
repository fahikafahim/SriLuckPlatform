<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate using provided credentials
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Check if authenticated user is an admin
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If not an admin, logout and show unauthorized error
            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized login attempt.']);
        }

        // If authentication fails, return error
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Log the admin out and invalidate the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the admin login page
        return redirect('/admin/login');
    }
}


/*----------------This is i will try to add cookie and session for admin
 login but it is not working so i will comment it out for now---------------*/



// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Facades\Hash;


// class AdminLoginController extends Controller
// {
//     // public function create()
//     // {
//     //     return view('auth.admin-login');
//     // }

//     // public function store(Request $request)
//     // {
//     //     $request->validate([
//     //         'email' => 'required|email',
//     //         'password' => 'required|string',
//     //     ]);

//     //     if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
//     //         /** @var \App\Models\User $user */
//     //         $user = Auth::user();
//     //         if ($user->user_type === 'admin') {
//     //             return redirect()->route('admin.dashboard');
//     //         }

//     //         Auth::logout();
//     //         return back()->withErrors(['email' => 'Unauthorized login attempt.']);
//     //     }

//     //     return back()->withErrors(['email' => 'Invalid credentials.']);
//     // }

//     // public function destroy(Request $request)
//     // {
//     //     Auth::logout();
//     //     $request->session()->invalidate();
//     //     $request->session()->regenerateToken();
//     //     return redirect('/admin/login');
//     // }

//      public function create(){
//         return view('auth.admin-login'); // blade view for admin login
//     }
//      public function store(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required|string',
//     ]);

//     // Check if the user exists
//     $user = \App\Models\User::where('email', $request->email)->first();

//     if (!$user) {
//         return back()->withErrors(['email' => 'This email is not registered.'])->withInput();
//     }

//     // Check if user is admin
//     if ($user->user_type !== 'admin') {
//         return back()->withErrors(['email' => 'Unauthorized login attempt.'])->withInput();
//     }

//     // Now check password
//     if (!\Hash::check($request->password, $user->password)) {
//         return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
//     }

//    // Everything is valid, log the user in
//     Auth::login($user, $request->filled('remember'));

//     // Generate Sanctum token
//     $token = $user->createToken('admin-api-token')->plainTextToken;

//     // Store token in session and cookie
//     session(['admin_api_token' => $token]);
//     Cookie::queue('admin_token', $token, 60 * 24 * 30); // 30 days expiration

//     return redirect()
//         ->route('admin.dashboard')
//         ->with('token', $token) // This makes $token available to the view
//         ->withCookie(cookie('admin_token', $token, 60 * 24 * 30)); // 30 days expiration
// }
//  public function destroy(Request $request)
//     {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         $request->session()->forget('admin_api_token');

//         return redirect()
//             ->route('admin.login')
//             ->withCookie(cookie('admin_api_token', '', -1));
//     }

// }
// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Facades\Hash; // Added Hash facade
// use App\Models\User; // Added User model import

// class AdminLoginController extends Controller
// {
//     public function create()
//     {
//         return view('auth.admin-login');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required|string',
//         ]);

//         // Check if the user exists
//         $user = User::where('email', $request->email)->first();

//         if (!$user) {
//             return back()->withErrors(['email' => 'This email is not registered.'])->withInput();
//         }

//         // Check if user is admin
//         if ($user->user_type !== 'admin') {
//             return back()->withErrors(['email' => 'Unauthorized login attempt.'])->withInput();
//         }

//         // Now check password
//         if (!Hash::check($request->password, $user->password)) {
//             return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
//         }

//         // Everything is valid, log the user in
//         Auth::login($user, $request->filled('remember'));

//         // Generate Sanctum token
//         $token = $user->createToken('admin-api-token')->plainTextToken;

//         // Store token in session and cookie
//         session(['admin_api_token' => $token]);
//         Cookie::queue('admin_token', $token, 60 * 24 * 30); // 30 days expiration

//         return redirect()
//             ->route('admin.dashboard')
//             ->with('token', $token)
//             ->withCookie(cookie('admin_token', $token, 60 * 24 * 30));
//     }

//     public function destroy(Request $request)
//     {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         $request->session()->forget('admin_api_token');

//         return redirect()
//             ->route('admin.login')
//             ->withCookie(cookie('admin_api_token', '', -1));
//
