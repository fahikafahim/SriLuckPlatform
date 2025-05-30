<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sriluck Footwear - Premium Footwear Collection</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

            /* Custom animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.8s ease-out forwards;
            }

            .product-card {
                transition: all 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            .image-overlay {
                position: relative;
                overflow: hidden;
            }

            .image-overlay::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.3);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .image-overlay:hover::after {
                opacity: 1;
            }

            .image-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 1.5rem;
                font-weight: 600;
                opacity: 0;
                transition: all 0.3s ease;
                z-index: 2;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            }

            .image-overlay:hover .image-text {
                opacity: 1;
                transform: translate(-50%, -60%);
            }

            .btn-gold {
                background: linear-gradient(to right, #d4a76a, #e8c887);
                color: #222;
                font-weight: 600;
            }

            .btn-gold:hover {
                background: linear-gradient(to right, #e8c887, #d4a76a);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }

            .btn-outline:hover {
                background: #222;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
        </style>
         <!-- Tailwind CSS Script -->
         <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-[Montserrat] bg-white text-[#333] min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="w-full py-6 px-8 flex justify-between items-center border-b border-gray-100 bg-white sticky top-0 z-50">
            <div class="text-2xl font-bold text-[#222] tracking-wider">SRILUCK FOOTWEAR</div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center p-6 lg:p-8 animate-fadeInUp">
            <div class="max-w-6xl w-full">
                <!-- Auth Section -->
                <div class="text-center max-w-2xl mx-auto">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 text-[#222]">Discover Premium Footwear</h1>
                    <p class="text-gray-600 mb-8 text-lg">
                        Step into luxury with our handcrafted collection designed for comfort and style.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="px-8 py-3 btn-gold text-white font-medium rounded-sm transition-all duration-300"
                            >
                                Explore Collection
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="px-8 py-3 btn-gold font-medium rounded-sm transition-all duration-300"
                            >
                                Member Login
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="px-8 py-3 border border-[#222] text-[#222] hover:bg-[#222] hover:text-white font-medium rounded-sm transition-all duration-300 btn-outline"
                                >
                                    Join Now
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </main>

         <!-- Product Showcase -->
         <div class="max-w-7xl mx-auto px-6 py-12">
            <h2 class="text-3xl font-bold text-center mb-12">Our Signature Collections</h2>
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Product 1 -->
                <div class="group product-card">
                    <div class="h-96 mb-4 overflow-hidden image-overlay rounded-lg shadow-md">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/casual2.jpg')">
                            <span class="image-text">URBAN CASUAL</span>
                        </div>
                    </div>
                    <div class="text-center px-4">
                        <h3 class="font-semibold text-xl mb-2">Urban Walkers</h3>
                        <p class="text-gray-600">Perfect blend of comfort and style for everyday wear</p>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="group product-card">
                    <div class="h-96 mb-4 overflow-hidden image-overlay rounded-lg shadow-md">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/heals.jpg')">
                            <span class="image-text">ELEGANT HEELS</span>
                        </div>
                    </div>
                    <div class="text-center px-4">
                        <h3 class="font-semibold text-xl mb-2">Evening Elegance</h3>
                        <p class="text-gray-600">Sophisticated designs for your special occasions</p>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="group product-card">
                    <div class="h-96 mb-4 overflow-hidden image-overlay rounded-lg shadow-md">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center bg-cover bg-center" style="background-image: url('/images/casual.jpg')">
                            <span class="image-text">CLASSIC LOAFERS</span>
                        </div>
                    </div>
                    <div class="text-center px-4">
                        <h3 class="font-semibold text-xl mb-2">Timeless Classics</h3>
                        <p class="text-gray-600">Refined craftsmanship for the modern gentleman</p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Footer -->
        <footer class="text-center p-8 text-sm text-gray-500 border-t border-gray-100 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <span class="text-2xl font-bold text-[#222] tracking-wider">SRILUCK</span>
                </div>
                <div class="mb-6">
                    <a href="#" class="mx-3 hover:text-[#d4a76a] transition-colors">About Us</a>
                    <a href="#" class="mx-3 hover:text-[#d4a76a] transition-colors">Collections</a>
                    <a href="#" class="mx-3 hover:text-[#d4a76a] transition-colors">Contact</a>
                    <a href="#" class="mx-3 hover:text-[#d4a76a] transition-colors">Privacy Policy</a>
                </div>
                <div>&copy; {{ date('Y') }} Sriluck Footwear. All rights reserved.</div>
            </div>
        </footer>
    </body>
</html>
