<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="order-id" content="{{ $order->id }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <x-top-navigation />

    <style>
        .payment-section {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .payment-method {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            cursor: pointer;
        }

        .payment-method:hover {
            border-color: #8b5cf6;
        }

        .payment-method.selected {
            border-color: #8b5cf6;
            background-color: #f5f3ff;
        }

        .payment-form {
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: linear-gradient(135deg, #545354 0%, #211d2a 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(139, 92, 246, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(139, 92, 246, 0.4);
            background: linear-gradient(135deg, #211d2a 0%, #545354 100%);
        }

        .order-summary-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="flex h-screen bg-gray-100">
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                <!-- Progress Steps -->
                <div class="max-w-6xl mx-auto mb-8">
                    <div class="flex justify-center items-center space-x-8">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
                                1</div>
                            <span class="ml-2 font-medium text-gray-600">Order Details</span>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
                                2</div>
                            <span class="ml-2 font-medium text-gray-600">Payment</span>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                3</div>
                            <span class="ml-2 font-medium text-gray-600">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Main Payment Container -->
                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Payment Form -->
                    <div class="lg:col-span-2 payment-section p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Payment Method</h2>

                        <form id="paymentForm" action="{{ route('payment.store', ['order' => $order->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="amount" value="{{ $order->total_amount }}">


                            <!-- Payment Methods -->
                            <div class="mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="payment-method p-4 rounded-md"
                                        onclick="selectPaymentMethod('credit_card')">
                                        <input type="radio" id="credit_card" name="payment_method" value="credit_card"
                                            class="hidden" checked>
                                        <div class="flex items-center">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                                                <div class="w-3 h-3 rounded-full bg-gray-600 hidden"></div>
                                            </div>
                                            <div>
                                                <label for="credit_card" class="font-medium text-gray-800">Credit
                                                    Card</label>
                                                <div class="text-gray-500 text-sm mt-1">
                                                    <i class="fas fa-info-circle text-gray-500 mr-3"></i>Pay securely
                                                    using your credit card

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="payment-method p-4 rounded-md" onclick="selectPaymentMethod('cod')">
                                        <input type="radio" id="cod" name="payment_method" value="cod"
                                            class="hidden">
                                        <div class="flex items-center">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                                                <div class="w-3 h-3 rounded-full bg-gray-600 hidden"></div>
                                            </div>
                                            <div>
                                                <label for="cod" class="font-medium text-gray-800">Cash on
                                                    Delivery</label>
                                                <div class="text-gray-500 text-sm mt-1">
                                                    <i class="fas fa-money-bill-wave mr-1"></i> Pay when you receive
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Credit Card Form (shown by default) -->
                            <div id="creditCardForm" class="payment-form">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="card_number"
                                            class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                        <input type="text" id="card_number" name="card_number"
                                            placeholder="1234 5678 9012 3456"
                                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
                                    </div>
                                    <div>
                                        <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Name
                                            on Card</label>
                                        <input type="text" id="card_name" name="card_name" placeholder="John Doe"
                                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
                                    </div>
                                    <div>
                                        <label for="expiry_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY"
                                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
                                    </div>
                                    <div>
                                        <label for="cvv"
                                            class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123"
                                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
                                    </div>
                                </div>
                            </div>

                            <!-- COD Form (hidden by default) -->
                            <div id="codForm" class="payment-form hidden">
                                <div class="bg-blue-50 p-4 rounded-md mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-gray-500 mr-3"></i>
                                        <p class="text-sm text-gray-800">Pay with cash when your order is delivered</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="submit-btn w-full py-3 px-6 rounded-md text-white font-medium text-lg">
                                Pay Rs.{{ number_format($order->total_amount, 2) }} <i class="fas fa-lock ml-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="order-summary-card p-6 sticky top-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

                            <!-- Order Details -->
                            <div class="mb-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Order Number</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Date</span>
                                    <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Status</span>
                                    <span class="font-medium capitalize">{{ $order->status }}</span>
                                </div>
                            </div>

                            <!-- Order Totals -->
                            <div class="space-y-3 mb-6 border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span
                                        class="font-medium">Rs.{{ number_format($order->total_amount - $order->total_amount * 0.05 - 300, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">Rs.300.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (5%)</span>
                                    <span
                                        class="font-medium">Rs.{{ number_format($order->total_amount * 0.05, 2) }}</span>
                                </div>
                                <div class="flex justify-between pt-3 border-t border-gray-200">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-gray-800">
                                        Rs.{{ number_format($order->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Delivery Address -->
                            <div class="bg-gray-50 p-4 rounded-md mb-6">
                                <h3 class="text-sm font-medium text-gray-800 mb-2">Delivery Address</h3>
                                <p class="text-sm text-gray-600">{{ $order->address }}, {{ $order->city }},
                                    {{ $order->province }} {{ $order->postal_code }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize with credit card selected if it exists
            if (document.getElementById('credit_card')) {
                selectPaymentMethod('credit_card');
            }
        });

        function selectPaymentMethod(method) {
            // Get the radio input element
            const radioInput = document.getElementById(method);
            if (!radioInput) return;

            // Update radio button
            radioInput.checked = true;

            // Update UI for all payment methods
            document.querySelectorAll('.payment-method').forEach(el => {
                const radioId = el.querySelector('input[type="radio"]')?.id;
                if (!radioId) return;

                el.classList.remove('selected');
                const indicator = el.querySelector('.w-3.h-3');
                if (indicator) {
                    indicator.classList.add('hidden');
                }
            });

            // Highlight selected method
            const selectedMethod = document.querySelector(`.payment-method[onclick*="${method}"]`);
            if (selectedMethod) {
                selectedMethod.classList.add('selected');
                const selectedIndicator = selectedMethod.querySelector('.w-3.h-3');
                if (selectedIndicator) {
                    selectedIndicator.classList.remove('hidden');
                }
            }

            // Show the appropriate form
            if (method === 'credit_card') {
                document.getElementById('creditCardForm').classList.remove('hidden');
                document.getElementById('codForm').classList.add('hidden');
            } else if (method === 'cod') {
                document.getElementById('creditCardForm').classList.add('hidden');
                document.getElementById('codForm').classList.remove('hidden');
            }
        }

        // Form validation
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                const method = document.querySelector('input[name="payment_method"]:checked')?.value;

                if (method === 'credit_card') {
                    const cardNumber = document.getElementById('card_number')?.value;
                    const cardName = document.getElementById('card_name')?.value;
                    const expiryDate = document.getElementById('expiry_date')?.value;
                    const cvv = document.getElementById('cvv')?.value;

                    if (!cardNumber || !cardName || !expiryDate || !cvv) {
                        e.preventDefault();
                        alert('Please fill in all credit card details');
                        return false;
                    }

                    // Simple card number validation
                    if (!/^\d{16}$/.test(cardNumber.replace(/\s/g, ''))) {
                        e.preventDefault();
                        alert('Please enter a valid 16-digit card number');
                        return false;
                    }

                    // Simple CVV validation
                    if (!/^\d{3,4}$/.test(cvv)) {
                        e.preventDefault();
                        alert('Please enter a valid CVV (3 or 4 digits)');
                        return false;
                    }
                }

                return true;
            });
        }
    </script>
</x-app-layout>
