<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            $products = Product::take(3)->get();
            $users = User::where('user_type', 'user')->latest()->get();
            return view('admin.dashboard', compact('products', 'users'));
        }
        abort(403, 'Unauthorized access');
    }
    public function products()
    {
        return view('admin.product');
    }
    public function users()
    {
        $users = User::where('user_type', 'user')->get();
        return view('admin.users', compact('users'));
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
    public function orders()
    {
        $orders = Order::latest()->get();
        return view('admin.order', compact('orders'));
    }
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.order')->with('success', 'Order deleted successfully.');
    }
}
