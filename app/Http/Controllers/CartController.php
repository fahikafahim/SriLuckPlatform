<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class CartController extends Controller
{
    // Handle cart after login
    public function handlePostLoginCart(Request $request)
    {
        $user = Auth::user();

        // Get guest cart from cookie
        $guestCart = json_decode($request->cookie('guest_cart'), true) ?? [];

        // Get pre-login cart from session
        $preLoginCart = session()->get('pre_login_cart', []);

        // Merge carts (implement your merge logic)
        $mergedCart = $this->mergeCarts($guestCart, $preLoginCart);

        // Save to database or persistent storage
        $this->saveUserCart($user->id, $mergedCart);

        // Clear guest data
        Cookie::queue(Cookie::forget('guest_cart'));
        session()->forget('pre_login_cart');

        return response()->json(['success' => true]);
    }

    // Handle cart before logout
    public function handlePreLogoutCart(Request $request)
    {
        $user = Auth::user();

        // Get current cart from database
        $userCart = $this->getUserCart($user->id);

        // Save to session for possible future login
        session()->put('pre_logout_cart', $userCart);

        return response()->json(['success' => true]);
    }

    protected function mergeCarts($cart1, $cart2)
    {
        // Implement your cart merging logic
        // Example: Combine items, sum quantities for duplicates
        $merged = [];

        // Add your merging algorithm here
        return array_merge($cart1, $cart2);
    }

    protected function saveUserCart($userId, $cart)
    {
        // Save to database or other persistent storage
        // Example:
        $user = User::find($userId);
        $user->cart = json_encode($cart);
        $user->save();
    }

    protected function getUserCart($userId)
    {
        // Retrieve from database
        $user = User::find($userId);
        return json_decode($user->cart, true) ?? [];
    }
}
