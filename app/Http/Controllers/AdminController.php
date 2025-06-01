<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with a summary of products and users.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Check if authenticated user is an admin
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            // Fetch the latest 3 products
            $products = Product::take(3)->get();
            // Fetch all users with user_type 'user', sorted by latest
            $users = User::where('user_type', 'user')->latest()->get();
            // Return the dashboard view with products and users
            return view('admin.dashboard', compact('products', 'users'));
        }

        // Deny access if not an admin
        abort(403, 'Unauthorized access');
    }

    /**
     * Show the admin product management page.
     *
     * @return \Illuminate\View\View
     */
    public function products()
    {
        return view('admin.product');
    }

    /**
     * Display the list of all regular users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        // Retrieve all users with user_type 'user'
        $users = User::where('user_type', 'user')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Delete a specific user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        // Find the user or fail
        $user = User::findOrFail($id);
        // Delete the user
        $user->delete();

        // Redirect with success message
        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }

    /**
     * Display the list of all orders.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        // Get the latest orders
        $orders = Order::latest()->get();
        return view('admin.order', compact('orders'));
    }

    /**
     * Delete a specific order by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteOrder($id)
    {
        // Find the order or fail
        $order = Order::findOrFail($id);
        // Delete the order
        $order->delete();

        // Redirect with success message
        return redirect()->route('admin.order')->with('success', 'Order deleted successfully.');
    }
}
