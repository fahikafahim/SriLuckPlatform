<!-- Top Navigation Bar -->
<style>
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-gradient-flow {
        animation: gradientFlow 8s ease infinite;
    }
</style>
 <!-- Top Navigation Bar with Animated Gradient -->
 <div class="relative overflow-hidden">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-600 to-gray-900 bg-[length:200%_100%] animate-gradient-flow"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center py-3">
            <!-- Product Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white hover:text-brown-300 transition-colors">Home</a>
                <a href="{{ route('customer.product') }}" class="text-sm font-medium text-white hover:text-brown-300 transition-colors">Our Products</a>
                <a href="#" class="text-sm font-medium text-white hover:text-brown-300 transition-colors">My Orders</a>
                <a href="#" class="text-sm font-medium text-white hover:text-brown-300 transition-colors">About Us</a>

            </nav>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-6">
                <!-- Search Icon with Expandable Input -->
                <div class="relative group">
                    <button class="p-1 focus:outline-none text-white hover:text-brown-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10 hidden group-focus-within:block">
                        <input type="text" placeholder="Search products..." class="w-full px-4 py-2 text-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-brown-500">
                    </div>
                </div>

                <!-- My Orders -->
                <a href="#" class="p-1 text-white hover:text-brown-300 transition-colors" title="My Orders">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </a>

                <!-- Cart with Counter -->
                <a href="{{ route('customer.cart') }}" class="p-1 relative text-white hover:text-brown-300 transition-colors" title="Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-brown-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </a>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-1 text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@yield('content')
@livewireScripts
