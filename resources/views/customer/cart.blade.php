<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <x-top-navigation />

    <style>
        .cart-container {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .cart-item {
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .quantity-btn {
            transition: all 0.2s ease;
            width: 30px;
            height: 30px;
        }

        .quantity-btn:hover {
            background-color: #e5e7eb;
        }

        .remove-btn {
            transition: all 0.2s ease;
        }

        .remove-btn:hover {
            color: #ef4444;
            transform: scale(1.1);
        }

        .checkout-btn {
            background: linear-gradient(135deg, #969393 0%, #4a4949 100%);
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #666464 0%, #5d5b5b 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(128, 128, 128, 0.3);
        }


        .empty-cart {
            background: linear-gradient(135deg, #f9fafb 0%, #f0fdf4 100%);
        }
    </style>

    <div class="flex h-screen bg-gray-100">
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                <!-- Breadcrumb -->
                <div class="mb-6 flex items-center text-sm text-gray-600">
                    <a href="/" class="hover:text-gray-900">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium">Shopping Cart</span>
                </div>

                <!-- Cart Title -->
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Shopping Cart</h1>

                <!-- Cart Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div id="cartItemsContainer" class="space-y-4">
                            <!-- Cart items will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span id="subtotal" class="font-medium">Rs.0.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">Rs.300.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (5%)</span>
                                    <span id="tax" class="font-medium">Rs.0.00</span>
                                </div>
                                <div class="flex justify-between pt-3 border-t border-gray-200">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span id="total" class="text-lg font-bold text-purple-600">Rs.0.00</span>
                                </div>
                            </div>

                            <button id="checkoutBtn"
                                onclick="window.location.href='{{ route('customer.orders.create') }}'"
                                class="w-full py-3 px-6 rounded-md text-white font-medium checkout-btn">
                                Proceed to Checkout <i class="fas fa-arrow-right ml-2"></i>
                            </button>

                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">or</p>
                                <a href="/" class="text-purple-600 hover:underline text-sm font-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty Cart State (hidden by default) -->
                <div id="emptyCart"
                    class="empty-cart hidden flex flex-col items-center justify-center py-16 rounded-lg">
                    <i class="fas fa-shopping-cart text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-600">Your cart is empty</h3>
                    <p class="text-gray-500 mt-2 mb-6">Looks like you haven't added any items yet</p>
                    <a href="/"
                        class="bg-gray-800 hover:bg-gray-900 text-white py-2 px-6 rounded-md transition-colors duration-200">
                        Start Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Render cart items on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderCartItems();
        });

        // Function to get the current user's cart
        function getCurrentUserCart() {
            const userId = document.querySelector('meta[name="user-id"]').content;
            if (!userId) {
                // Redirect to login if not authenticated
                window.location.href = '/login';
                return [];
            }

            const userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
            return userCarts[userId] || [];
        }

        // Function to render cart items
        function renderCartItems() {
            const cart = getCurrentUserCart().map(item => ({
                ...item,
                price: Number(item.price),
            }));

            const cartItemsContainer = document.getElementById('cartItemsContainer');
            const emptyCart = document.getElementById('emptyCart');

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '';
                emptyCart.classList.remove('hidden');
                document.getElementById('checkoutBtn').disabled = true;
                updateOrderSummary(0);
                return;
            }

            emptyCart.classList.add('hidden');
            document.getElementById('checkoutBtn').disabled = false;

            let subtotal = 0;
            let html = '';

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                html += `
                <div class="cart-item bg-white rounded-lg shadow-sm p-4 flex flex-col sm:flex-row gap-4">
                    <!-- Product Image -->
                    <div class="sm:w-1/4">
                        <img src="${item.image_url || 'https://via.placeholder.com/300'}"
                             alt="${item.name}"
                             class="w-full h-40 object-cover rounded-md">
                    </div>

                    <!-- Product Info -->
                    <div class="sm:w-2/4 flex flex-col">
                        <h3 class="font-bold text-gray-800 text-lg mb-1">${item.name}</h3>
                        <p class="text-gray-600 text-sm mb-2">${item.description || 'No description available'}</p>

                        <div class="flex items-center mt-auto text-sm">
                            ${item.size ? `<span class="mr-3 text-gray-500">
                                    <i class="fas fa-ruler-combined mr-1"></i> ${item.size}
                                </span>` : ''}

                            ${item.color ? `<span class="text-gray-500">
                                    <i class="fas fa-palette mr-1"></i> ${item.color}
                                </span>` : ''}
                        </div>
                    </div>

                    <!-- Price and Quantity -->
                    <div class="sm:w-1/4 flex flex-col items-end justify-between">
                        <div class="text-right">
                            <span class="text-amber-700 font-bold">Rs.${Number(item.price).toFixed(2)}</span>
                            <p class="text-sm text-gray-500">${item.quantity} x Rs.${Number(item.price).toFixed(2)}</p>
                            <p class="text-gray-800 font-medium mt-1">Rs.${(Number(item.price) * item.quantity).toFixed(2)}</p>
                        </div>

                        <div class="flex items-center mt-2">
                            <button onclick="updateQuantity(${item.id}, -1)"
                                    class="quantity-btn flex items-center justify-center border rounded-l-md">
                                <i class="fas fa-minus"></i>
                            </button>

                            <span class="quantity-display border-t border-b px-3 py-1">
                                ${item.quantity}
                            </span>

                            <button onclick="updateQuantity(${item.id}, 1)"
                                    class="quantity-btn flex items-center justify-center border rounded-r-md">
                                <i class="fas fa-plus"></i>
                            </button>

                            <button onclick="removeItem(${item.id})"
                                    class="remove-btn ml-3 text-gray-500 hover:text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });

            cartItemsContainer.innerHTML = html;
            updateOrderSummary(subtotal);
        }

        // Function to add an item to the cart
        function updateQuantity(productId, change) {
            const userId = document.querySelector('meta[name="user-id"]').content;
            let userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
            let userCart = userCarts[userId] || [];

            const itemIndex = userCart.findIndex(item => item.id === productId);

            if (itemIndex !== -1) {
                userCart[itemIndex].quantity += change;

                // Remove item if quantity reaches 0
                if (userCart[itemIndex].quantity <= 0) {
                    userCart.splice(itemIndex, 1);
                }

                userCarts[userId] = userCart;
                localStorage.setItem('userCarts', JSON.stringify(userCarts));
                renderCartItems();
                updateCartCount();
            }
        }

        // Function to remove an item from the cart
        function removeItem(productId) {
            const userId = document.querySelector('meta[name="user-id"]').content;
            let userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
            let userCart = userCarts[userId] || [];

            userCart = userCart.filter(item => item.id !== productId);
            userCarts[userId] = userCart;
            localStorage.setItem('userCarts', JSON.stringify(userCarts));
            renderCartItems();
            updateCartCount();
        }

        // Update the updateCartCount function in your main layout
        function updateCartCount() {
            const userId = document.querySelector('meta[name="user-id"]').content;
            if (!userId) return;

            const userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
            const userCart = userCarts[userId] || [];
            const totalItems = userCart.reduce((total, item) => total + item.quantity, 0);

            // Update cart count in navbar
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = totalItems;
                cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
            }
        }

        // Function to update order summary
        function updateOrderSummary(subtotal) {
            const shipping = 300;
            const tax = subtotal * 0.05;
            const total = subtotal + shipping + tax;

            document.getElementById('subtotal').textContent = `Rs.${subtotal.toFixed(2)}`;
            document.getElementById('tax').textContent = `Rs.${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `Rs.${total.toFixed(2)}`;
        }

        // Handle checkout button
        document.getElementById('checkoutBtn').addEventListener('click', function() {

        });

        // Handle checkout button
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const userId = document.querySelector('meta[name="user-id"]').content;
            if (!userId) {
                window.location.href = '/login';
                return;
            }

            const userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
            const userCart = userCarts[userId] || [];

            if (userCart.length === 0) {
                alert('Your cart is empty!');
                return;
            }


            // Create a form to submit the cart data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/checkout/prepare'; 
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Add cart data
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart';
            cartInput.value = JSON.stringify(userCart);
            form.appendChild(cartInput);

            document.body.appendChild(form);
            form.submit();
        });
    </script>
</x-app-layout>
