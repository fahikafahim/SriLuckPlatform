<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <x-top-navigation />

    <style>
        .order-form-section {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .form-input:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .order-summary-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .order-summary-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .submit-btn {
            background: linear-gradient(135deg, #808080 0%, #2e2e2e 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(26, 25, 39, 0.4);
            background: linear-gradient(135deg, #171123 0%, #42414d 100%);
        }

        .payment-method {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .payment-method:hover {
            border-color: #171123;
        }

        .payment-method.selected {
            border-color: #171123;
            background-color: #f5f3ff;
        }

        .step-indicator {
            position: relative;
        }

        .step-indicator:not(:last-child):after {
            content: '';
            position: absolute;
            right: -1.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1px;
            background-color: #d1d5db;
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
                        <div class="step-indicator flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
                                1</div>
                            <span class="ml-2 font-medium text-gray-600">Order Details</span>
                        </div>
                        <div class="step-indicator flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                2</div>
                            <span class="ml-2 font-medium text-gray-600">Payment</span>
                        </div>
                        <div class="step-indicator flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                3</div>
                            <span class="ml-2 font-medium text-gray-600">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Main Form Container -->
                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Order Form -->
                    <div class="lg:col-span-2 order-form-section p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Information</h2>

                        <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
                            @csrf

                            <!-- Customer Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-gray-600"></i> Customer Details
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                            Name</label>
                                        <input type="text" id="full_name" name="full_name"
                                            class="form-input w-full px-4 py-2 rounded-md"
                                            value="{{ old('full_name', auth()->user()->name ?? '') }}" required>
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-input w-full px-4 py-2 rounded-md"
                                            value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                    </div>
                                    <div>
                                        <label for="phone_number"
                                            class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" id="phone_number" name="phone_number"
                                            class="form-input w-full px-4 py-2 rounded-md"
                                            value="{{ old('phone_number') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-truck mr-2 text-gray-600"></i> Shipping Address
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                        <textarea id="address" name="address" rows="3" class="form-input w-full px-4 py-2 rounded-md" required>{{ old('address') }}</textarea>
                                    </div>
                                    <div>
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" id="city" name="city"
                                            class="form-input w-full px-4 py-2 rounded-md" value="{{ old('city') }}"
                                            required>
                                    </div>
                                    <div>
                                        <label for="province"
                                            class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                        <input type="text" id="province" name="province"
                                            class="form-input w-full px-4 py-2 rounded-md" value="{{ old('province') }}"
                                            required>
                                    </div>
                                    <div>
                                        <label for="postal_code"
                                            class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code</label>
                                        <input type="text" id="postal_code" name="postal_code"
                                            class="form-input w-full px-4 py-2 rounded-md"
                                            value="{{ old('postal_code') }}" required>
                                    </div>
                                </div>
                            </div>


                            <!-- Hidden Fields -->
                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="status" value="pending">
                            <input type="hidden" name="total_amount" id="total_amount" value="{{ $total }}">
                            <input type="hidden" name="cart_items" id="cart_items" value="">

                            <!-- Terms and Conditions -->
                            <div class="flex items-start mb-6">
                                <input type="checkbox" id="terms" name="terms" class="mt-1 mr-2" required>
                                <label for="terms" class="text-sm text-gray-600">
                                    I agree to the <a href="#" class="text-gray-600 hover:underline">Terms and
                                        Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="submit-btn w-full py-3 px-6 rounded-md text-white font-medium text-lg">
                                Complete Order <i class="fas fa-lock ml-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="order-summary-card p-6 sticky top-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

                            <!-- Cart Items List -->
                            <div class="max-h-96 overflow-y-auto mb-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex items-start mb-4 pb-4 border-b border-gray-200">
                                        <div class="w-16 h-16 rounded-md overflow-hidden mr-3">
                                            <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/300' }}"
                                                alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-800 text-sm">{{ $item['name'] }}</h3>
                                            <p class="text-xs text-gray-600 mb-1">Qty: {{ $item['quantity'] }}</p>
                                            <p class="text-amber-700 font-bold text-sm">
                                                Rs.{{ number_format($item['price'], 2) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-800 font-medium text-sm">
                                                Rs.{{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Totals -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rs.{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">Rs.{{ number_format($shipping, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (5%)</span>
                                    <span class="font-medium">Rs.{{ number_format($tax, 2) }}</span>
                                </div>
                                <div class="flex justify-between pt-3 border-t border-gray-200">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-gray-600">
                                        Rs.{{ number_format($total, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Delivery Estimate -->
                            <div class="bg-blue-50 p-4 rounded-md mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-shipping-fast text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Estimated Delivery</p>
                                        <p class="text-sm text-gray-600">3-5 business days</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Need Help? -->
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Need help with your order?</p>
                                <a href="#" class="text-gray-600 hover:underline text-sm font-medium">
                                    Contact our support team
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format the cart items as expected by the backend
            const cartItems = @json($cartItems);
            const formattedCartItems = cartItems.map(item => ({
                product_id: item.id || item.product_id,
                product_name: item.name,
                price: parseFloat(item.price),
                quantity: parseInt(item.quantity)
            }));

            document.getElementById('cart_items').value = JSON.stringify(formattedCartItems);

            // Form submission handler
            const form = document.getElementById('orderForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Validate terms checkbox
                if (!document.getElementById('terms').checked) {
                    alert('Please agree to the terms and conditions');
                    return;
                }

                // Collect all form data
                const formData = {
                    user_id: document.getElementById('user_id').value,
                    full_name: document.getElementById('full_name').value,
                    email: document.getElementById('email').value,
                    phone_number: document.getElementById('phone_number').value,
                    address: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    province: document.getElementById('province').value,
                    postal_code: document.getElementById('postal_code').value,
                    terms: document.getElementById('terms').checked ? 'on' : '',
                    total_amount: document.getElementById('total_amount').value,
                    cart_items: document.getElementById('cart_items').value,
                    status: 'pending'
                };

                // Disable submit button
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Processing... <i class="fas fa-spinner fa-spin ml-2"></i>';

                try {
                    const response = await fetch('/api/orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': 'Bearer 2|z4Yyuo5aI95QvgPNQJ4fcrPhPrTLvgl6nWyjnCy09e40676f'
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Success - redirect to payment page
                        window.location.href = data.redirect_url;
                    } else {
                        // Show error message
                        alert(data.message || 'Failed to create order');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Complete Order <i class="fas fa-lock ml-2"></i>';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while processing your order');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Complete Order <i class="fas fa-lock ml-2"></i>';
                }
            });
        });
    </script>
</x-app-layout>
