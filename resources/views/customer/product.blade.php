<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <x-top-navigation />
    <style>
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .price-tag {
            background-color: rgba(146, 64, 14, 0.1);
            transition: all 0.3s ease;
        }

        .product-card:hover .price-tag {
            background-color: rgba(146, 64, 14, 0.2);
        }

        .add-to-cart-btn {
            transition: all 0.2s ease;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.1);
            color: #9c4221;
        }

        .cart-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
    </style>
    <!-- Success Message -->
    @if (session('success'))
        <div id="success-popup" class="fixed top-5 right-5 bg-red-400 text-white px-4 py-2 rounded shadow-lg"
            style="z-index: 9999;">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const popup = document.getElementById('success-popup');
                if (popup) {
                    popup.style.transition = 'opacity 0.5s ease';
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 500);
                }
            }, 1000);
        </script>
    @endif
    <!-- Cart Success Message -->
    <div id="cartMessage" class="cart-message bg-[#060220] text-white"></div>

    <div class="flex h-screen bg-gray-100">
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Our Products</h1>
                    <p class="text-gray-600">Browse our collection of high-quality products</p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="product-card bg-white rounded-lg overflow-hidden shadow-md border border-gray-100">
                            <!-- Product Image -->
                            <div class="overflow-hidden relative">
                                <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}" class="product-image w-full">
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">
                                            {{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                    <span class="price-tag px-3 py-1 rounded-full text-amber-800 font-bold">
                                        Rs.{{ number_format($product->price, 2) }}
                                    </span>
                                </div>

                                <!-- Size & Color -->
                                <div class="flex items-center mt-3 text-sm">
                                    @if ($product->size)
                                        <span class="mr-3 text-gray-500">
                                            <i class="fas fa-ruler-combined mr-1"></i> {{ $product->size }}
                                        </span>
                                    @endif

                                    @if ($product->color)
                                        <span class="text-gray-500">
                                            <i class="fas fa-palette mr-1"></i> {{ $product->color }}
                                        </span>
                                    @endif
                                </div>

                                <!-- View Button -->
                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('customer.product_show', $product->id) }}"
                                        class="flex-1 text-center bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 rounded transition-colors duration-200">
                                        View Details
                                    </a>
                                    <!-- Add to Cart Button -->
                                    <button onclick="addToCart({{ json_encode($product) }})"
                                        class="add-to-cart-btn bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-3 rounded transition-colors duration-200">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-medium text-gray-600">No products available</h3>
                            <p class="text-gray-500 mt-2">Check back later for our latest products</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
<script>
 // Adds product to cart in localStorage
    function addToCart(product) {
        // Check if user is logged in
        const userId = document.querySelector('meta[name="user-id"]').content;
        if (!userId) {
            alert('Please login to add items to cart');
            return;
        }

        // Get existing cart data from localStorage
        let userCarts = JSON.parse(localStorage.getItem('userCarts')) || {};
        let userCart = userCarts[userId] || [];

        // Check if product already exists in cart
        const existingItem = userCart.find(item => item.id === product.id);

        if (existingItem) {
            // Increase quantity if product exists
            existingItem.quantity += 1;
        } else {
            // Add new product with quantity 1
            product.quantity = 1;
            userCart.push(product);
        }

        // Save updated cart to localStorage
        userCarts[userId] = userCart;
        localStorage.setItem('userCarts', JSON.stringify(userCarts));

        // Show confirmation and update cart count
        showCartMessage('Product added to cart!');
        updateCartCount();
    }

    // Shows temporary cart notification message
    function showCartMessage(message) {
        const cartMessage = document.getElementById('cartMessage');
        cartMessage.textContent = message;
        cartMessage.style.display = 'block';

        // Hide message after 3 seconds
        setTimeout(() => {
            cartMessage.style.display = 'none';
        }, 3000);
    }

    // Updates cart item count in navbar
    function updateCartCount() {
        // Get cart from localStorage
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Calculate total items in cart
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);

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
