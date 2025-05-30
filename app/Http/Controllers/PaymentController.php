<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function index()
    {
        return PaymentResource::collection(Payment::all());
    }

   public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'order_id'       => 'required|exists:orders,id',
            'payment_method' => 'required|in:credit_card,cod',
            'amount'         => 'required|numeric|min:0',
            'card_number'    => 'required_if:payment_method,credit_card|nullable|string',
            'card_name'      => 'required_if:payment_method,credit_card|nullable|string',
            'expiry_date'    => 'required_if:payment_method,credit_card|nullable|string',
            'cvv'            => 'required_if:payment_method,credit_card|nullable|string',
        ]);

        $validated['status'] = $request->payment_method === 'cod' ? 'pending' : 'paid';
        $validated['payment_date'] = now();

        if ($request->payment_method === 'credit_card') {
            $validated['card_number'] = '**** **** **** ' . substr($validated['card_number'], -4);
            $validated['cvv'] = '***';
        } else {
            $validated['card_number'] = null;
            $validated['card_name'] = null;
            $validated['expiry_date'] = null;
            $validated['cvv'] = null;
        }

        $payment = Payment::create($validated);

        $order = Order::find($validated['order_id']);
        $order->status = 'processing';
        $order->save();

        return redirect()->route('orders.confirmation', ['order' => $order->id])
               ->with('success', 'Payment processed successfully!');

    } catch (\Exception $e) {
        return back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}

   public function show($orderId)
{
    $order = Order::findOrFail($orderId);

    // Get the most recent 'paid' payment for the order or fallback to latest one
    $payment = Payment::where('order_id', $orderId)
        ->orderByRaw("FIELD(status, 'paid', 'pending')") // prioritize paid
        ->latest()
        ->first();

    return view('customer.payment', [
        'order' => $order,
        'total' => $order->total_amount,
        'payment' => $payment, // pass to Blade
    ]);
}

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id'       => 'sometimes|exists:orders,id',
            'payment_method' => 'sometimes|in:credit_card,paypal,cash',
            'amount'         => 'sometimes|numeric|min:0',
            'status'         => 'sometimes|in:paid,unpaid,failed',
            'payment_date'   => 'sometimes|date',
        ]);

        $payment->update($validated);
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
