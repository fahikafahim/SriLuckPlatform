<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <x-top-navigation />

    <style>
        .product-image-main {
            transition: all 0.3s ease;
            height: 400px;
            object-fit: cover;
        }

        .order-now-btn {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #2e2e2e 0%, #6e6d6d 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .order-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            background: linear-gradient(135deg, #d3d3d3 0%, #2e2e2e 100%);
        }


        .order-now-btn:active {
            transform: translateY(0);
        }

        .order-now-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .order-now-btn:hover::after {
            left: 100%;
        }

        .add-to-cart-btn {
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.05);
            color: #9c4221;
        }

        /* New cart message styles */
        .cart-message-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        .cart-message {
            background-color: #060220;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 250px;
            transform: translateX(0);
            transition: all 0.3s ease;
        }

        .cart-message.hiding {
            transform: translateX(100%);
            opacity: 0;
        }

        .cart-message i {
            margin-right: 10px;
        }

        .cart-message .close-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            margin-left: 15px;
            font-size: 16px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <div class="flex h-screen bg-gray-100">
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Products
                    </a>
                </div>
                <!-- Product Detail Section -->
                <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="md:flex">
                        <!-- Product Images -->
                        <div class="md:w-1/2 p-6">
                            <div class="mb-4">
                                <img src="{{ $product->image_url ?? 'https://via.placeholder.com/600' }}"
                                    alt="{{ $product->name }}" class="product-image-main w-full rounded-lg">
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <!-- Thumbnails would go here -->
                                <div class="border rounded-md p-1 cursor-pointer">
                                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/150' }}"
                                        class="h-20 w-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="md:w-1/2 p-6">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                           <!-- Price -->
                            <div class="mb-4">
                                <span
                                    class="text-2xl font-bold text-amber-700">Rs.{{ number_format($product->price, 2) }}</span>
                                @if ($product->compare_at_price)
                                    <span
                                        class="ml-2 text-gray-500 line-through">Rs.{{ number_format($product->compare_at_price, 2) }}</span>
                                @endif
                            </div>
                            <!-- Rating -->
                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-gray-600 ml-2">(24 reviews)</span>
                            </div>
                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                                <p class="text-gray-600">{{ $product->description }}</p>
                            </div>
                            <!-- Size & Color -->
                            <div class="mb-6">
                                <div class="flex space-x-8">
                                    @if ($product->size)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Size</h4>
                                            <div class="flex space-x-2">
                                                <span
                                                    class="px-3 py-1 bg-gray-100 rounded-md">{{ $product->size }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($product->color)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Color</h4>
                                            <div class="flex items-center">
                                                <span class="w-6 h-6 rounded-full mr-2"
                                                    style="background-color: {{ $product->color }}"></span>
                                                <span>{{ $product->color }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Quantity</h4>
                                <div class="flex items-center">
                                    <button class="px-3 py-1 bg-gray-200 rounded-l-md hover:bg-gray-300"
                                        onclick="decrementQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1"
                                        class="w-16 text-center border-t border-b border-gray-200 py-1">
                                    <button class="px-3 py-1 bg-gray-200 rounded-r-md hover:bg-gray-300"
                                        onclick="incrementQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex space-x-4">
                                <a onclick="addToCart({{ json_encode($product) }})"
                                    class="order-now-btn flex-1 text-white py-3 px-6 rounded-md font-medium text-center">
                                    Add to Cart <i class="fas fa-arrow-right ml-2"></i>
                                </a>

                            </div>
                            <!-- Additional Info -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-truck mr-2"></i> Delivery
                                        </h4>
                                        <p class="text-sm text-gray-600">Free shipping on orders over Rs.10,000</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-undo mr-2"></i> Returns
                                        </h4>
                                        <p class="text-sm text-gray-600">30-day return policy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
    // Quantity control functions
    function incrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
    // Add product to cart in localStorage
    function addToCart(product) {
        // Check if user is logged in
        const userId = document.querySelector('meta[name="user-id"]').content;
        if (!userId) {
            showCartMessage('Please login to add items to cart', 'error');
            return;
        }
        const quantity = parseInt(document.getElementById('quantity').value);
        // Get existing cart data or initialize
        let userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
        let userCart = userCarts[userId] || [];

        // Check if product already exists in cart
        const existingItem = userCart.find(item => item.id === product.id);

        if (existingItem) {
            // Update quantity if product exists
            existingItem.quantity += quantity;
        } else {
            // Add new product to cart
            product.quantity = quantity;
            userCart.push(product);
        }

        // Save updated cart to localStorage
        userCarts[userId] = userCart;
        localStorage.setItem('userCarts', JSON.stringify(userCarts));

        // Show success message and update cart count
        showCartMessage('Product added to cart!');
        updateCartCount();
    }
    // Show temporary notification message
    function showCartMessage(message, type = 'success') {
        // Remove any existing messages first
        const existingContainer = document.getElementById('cartMessageContainer');
        if (existingContainer) {
            existingContainer.remove();
        }
        // Create and display new message
        const container = document.createElement('div');
        container.id = 'cartMessageContainer';
        container.className = 'cart-message-container';

        const messageElement = document.createElement('div');
        messageElement.className = `cart-message ${type === 'error' ? 'bg-red-500' : 'bg-green-500'}`;
        messageElement.innerHTML = `
            <div>
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i>
                ${message}
            </div>
            <button class="close-btn" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(messageElement);
        document.body.appendChild(container);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            messageElement.classList.add('hiding');
            setTimeout(() => {
                container.remove();
            }, 300);
        }, 3000);
    }
    // Update cart item count in navbar
    function updateCartCount() {
        const userId = document.querySelector('meta[name="user-id"]').content;
        if (!userId) return;

        // Calculate total items in cart
        const userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
        const userCart = userCarts[userId] || [];
        const totalItems = userCart.reduce((total, item) => total + item.quantity, 0);

        // Update cart count display
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
        }
    }
    // Initialize cart count when page loads
    document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
</x-app-layout>
