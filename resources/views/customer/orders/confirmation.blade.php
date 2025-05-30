<x-app-layout>
    <style>
        .confirmation-container {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        .confirmation-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-badge.paid {
            background-color: #ecfdf5;
            color: #059669;
        }
        .status-badge.pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        .progress-steps {
            position: relative;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 16px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }
        .progress-step {
            position: relative;
            z-index: 1;
        }
        .progress-step.completed .step-number {
            background-color: #10b981;
            color: white;
        }
        .progress-step.active .step-number {
            background-color: #8b5cf6;
            color: white;
        }
        .step-number {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
    </style>

    <div class="py-12 confirmation-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="max-w-6xl mx-auto mb-8">
                    <div class="flex justify-center items-center space-x-8">
                        <div class="step-indicator flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">1</div>
                            <span class="ml-2 font-medium text-gray-600">Order Details</span>
                        </div>
                        <div class="step-indicator flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">2</div>
                            <span class="ml-2 font-medium text-gray-600">Payment</span>
                        </div>
                        <div class="step-indicator flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">3</div>
                            <span class="ml-2 font-medium text-gray-600">Confirmation</span>
                        </div>
                    </div>
                </div>

            <div class="confirmation-card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="mx-auto h-24 w-24 rounded-full bg-green-50 flex items-center justify-center">
                            <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Order Confirmed!</h2>
                        <p class="mt-2 text-lg text-gray-600">Thank you for your order #{{ $order->id }}</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Order Summary -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Order Number</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date</span>
                                    <span class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span class="font-medium capitalize">{{ $order->status }}</span>
                                </div>
                            </div>


                            <div class="mt-6 pt-4 border-t border-gray-200 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rs.{{ number_format($order->total_amount - $order->total_amount * 0.05 - 300, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">Rs.300.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (5%)</span>
                                    <span class="font-medium">Rs.{{ number_format($order->total_amount * 0.05, 2) }}</span>
                                </div>
                                <div class="flex justify-between pt-3 border-t border-gray-200">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-gray-800">
                                        Rs.{{ number_format($order->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div>
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Shipping Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Full Name</p>
                                        <p class="text-gray-900">{{ $order->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-gray-900">{{ $order->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone</p>
                                        <p class="text-gray-900">{{ $order->phone_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Address</p>
                                        <p class="text-gray-900">{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-lg">
                                <h3 class="text-xl font-bold text-gray-800 mb-3">What's Next?</h3>
                                @if($order->payment_status === 'paid')
                                    <p class="text-gray-700 mb-4">Your payment has been successfully processed. We're preparing your order for shipment.</p>
                                    <p class="text-gray-700">You'll receive a confirmation email with tracking information once your order ships.</p>
                                @else
                                    <p class="text-gray-700 mb-4">Your order has been received and will be processed shortly.</p>
                                    <p class="text-gray-700">Please prepare the exact amount (Rs.{{ number_format($order->total_amount, 2) }}) for the delivery person.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center space-x-4">
                        <a href="{{ route('customer.product') }}" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Continue Shopping
                        </a>
                        <a href="#" class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Review Our Platform
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
