<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    /**
     * Get all payments (API endpoint)
     * @return PaymentResource collection of all payments
     */
    public function index()
    {
        return PaymentResource::collection(Payment::all());
    }

    /**
     * Process and store a new payment
     * @param Request $request Payment data including order details
     * @return Redirect to order confirmation page or back with error
     */
    public function store(Request $request)
    {
        try {
            // Validate payment data
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

            // Set payment status and date
            $validated['status'] = $request->payment_method === 'cod' ? 'pending' : 'paid';
            $validated['payment_date'] = now();

            // Mask sensitive credit card information
            if ($request->payment_method === 'credit_card') {
                $validated['card_number'] = '**** **** **** ' . substr($validated['card_number'], -4);
                $validated['cvv'] = '***';
            } else {
                // Clear card details for non-credit-card payments
                $validated['card_number'] = null;
                $validated['card_name'] = null;
                $validated['expiry_date'] = null;
                $validated['cvv'] = null;
            }

            // Create payment record
            $payment = Payment::create($validated);

            // Update order status
            $order = Order::find($validated['order_id']);
            $order->status = 'processing';
            $order->save();

            return redirect()->route('orders.confirmation', ['order' => $order->id])
                   ->with('success', 'Payment processed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Show payment details for an order
     * @param int $orderId ID of the order
     * @return View with order and payment information
     */
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Get the most recent payment, prioritizing 'paid' status
        $payment = Payment::where('order_id', $orderId)
            ->orderByRaw("FIELD(status, 'paid', 'pending')") // prioritize paid
            ->latest()
            ->first();

        return view('customer.payment', [
            'order' => $order,
            'total' => $order->total_amount,
            'payment' => $payment,
        ]);
    }

    /**
     * Update payment details (API endpoint)
     * @param Request $request Updated payment data
     * @param Payment $payment Payment to update
     * @return PaymentResource Updated payment record
     */
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

    /**
     * Delete a payment record (API endpoint)
     * @param Payment $payment Payment to delete
     * @return JSON response with deletion confirmation
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
