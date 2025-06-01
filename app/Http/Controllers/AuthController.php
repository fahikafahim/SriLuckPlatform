<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login and issue a new API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Return error if authentication fails
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Get the authenticated user
        /** @var \App\Models\UserModel $user **/
        $user = Auth::user();

        // Create a new API token for the user
        $token = $user->createToken('api_token')->plainTextToken;

        // Return success response with token and user info
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Logout the user by deleting their current access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke (delete) the current access token
        $request->user()->currentAccessToken()->delete();

        // Return success response
        return response()->json(['message' => 'Logged out successfully']);
    }
}



/*----------------This is i will try to add cookie
 but it is not working so i will comment it out for now---------------*/

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;

// class AuthController extends Controller
// {
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required'
//         ]);

//         if (!Auth::attempt($request->only('email', 'password'))) {
//             return response()->json([
//                 'message' => 'Invalid login credentials'
//             ], 401);
//         }

//         $user = Auth::user();
//         $token = $user->createToken('mobile_token')->plainTextToken;

//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'user' => $user
//         ]);
//     }


//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json(['message' => 'Logged out']);
//     }
// }
