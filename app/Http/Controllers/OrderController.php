<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return OrderResource::collection($orders);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'postal_code' => 'required|string|max:20',
                'terms' => 'required|accepted',
                'total_amount' => 'required|numeric|min:0',
                'cart_items' => 'required|json'
            ]);

            $cartItems = json_decode($validated['cart_items'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid cart_items format'
                ], 422);
            }

            // Reassign decoded cart items to the validated data
            $validated['cart_items'] = $cartItems;
            $validated['status'] = 'pending';

            $order = Order::create($validated);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'redirect_url' => route('payment', $order->id)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET /api/orders/{id}
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return new OrderResource($order);
    }

    // PUT /api/orders/{id}
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:pending,processing,shipped,delivered,cancelled',
            'total_amount' => 'sometimes|numeric|min:0',
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:500',
            'postal_code' => 'sometimes|string|max:20',
            'city' => 'sometimes|string|max:100',
            'province' => 'sometimes|string|max:100',
            'product_details' => 'sometimes|json',
        ]);

        $validated['update_date'] = now();

        $order->update($validated);
        return new OrderResource($order);
    }

    // DELETE /api/orders/{id}
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
            'deleted_order' => new OrderResource($order)
        ]);
    }

    // Frontend methods
    public function prepareCheckout(Request $request)
    {
        $cartItems = json_decode($request->cart, true);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        session(['checkout_cart' => $cartItems]);
        return redirect()->route('customer.orders.create');
    }

    public function create()
    {
        $cartItems = session('checkout_cart', []);

        $subtotal = array_reduce($cartItems, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $shipping = 300;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        return view('customer.orders.create', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    // Payment methods
    public function showPayment($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('customer.payment', [
            'order' => $order,
            'total' => $order->total_amount
        ]);
    }

    public function processPayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,cod',
            'card_number' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card'
        ]);

        // Here you would typically integrate with a payment gateway
        // For demo purposes, we'll just update the order status

        $order->update([
            'status' => 'processing',
            'payment_method' => $request->payment_method,
            'payment_status' => 'completed'
        ]);

        return redirect()->route('orders.confirmation', $order->id);
    }

    // In OrderController.php
public function confirmation(Order $order)
{
    return view('customer.orders.confirmation', [
        'order' => $order
    ]);
}
}
