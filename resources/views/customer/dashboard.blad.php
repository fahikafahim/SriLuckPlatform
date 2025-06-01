<x-app-layout>
    <x-top-navigation />
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Artisan Footwear</span>
                            <span class="block text-brown-800">Crafted for Distinction</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-600 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Meticulously handcrafted using the finest leathers and sustainable materials. Each pair embodies our century-old tradition of excellence.
                        </p>
                        <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start space-x-4">
                            <div class="rounded-md shadow-lg hover:shadow-xl transition-shadow">
                                <a href="{{ route('customer.product') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-900 hover:bg-brown-800 transition-colors duration-300 md:py-4 md:text-lg md:px-10">
                                    Discover Collections
                                </a>
                            </div>
                            <div class="rounded-md shadow hover:shadow-md transition-shadow">
                                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 md:py-4 md:text-lg md:px-10">
                                    Craftsmanship
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="/images/heroimg.jpg" alt="Handcrafted premium footwear">
        </div>
    </div>
    <!-- Brand Promise -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white shadow-lg rounded-lg transition-all duration-300">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-brown-800 text-gray-900 mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Ethically Sourced</h3>
                    <p class="text-gray-600">Premium leathers from certified sustainable tanneries</p>
                </div>
                <div class="text-center p-6 bg-white shadow-lg rounded-lg transition-all duration-300">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-brown-800 text-gray-900 mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Artisan Crafted</h3>
                    <p class="text-gray-600">Handmade by master shoemakers with decades of experience</p>
                </div>
                <div class="text-center p-6 bg-white shadow-lg rounded-lg transition-all duration-300">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-brown-800 text-gray-900 mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Timeless Design</h3>
                    <p class="text-gray-600">Classic silhouettes that transcend seasonal trends</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Collections -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Signature Collections
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Designed for the discerning individual who values both form and function
                </p>
            </div>
            <div class="grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                <!-- Collection 1 -->
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-100 aspect-w-1 aspect-h-1 rounded-lg overflow-hidden group-hover:opacity-90 transition-opacity duration-300 lg:h-80 lg:aspect-none">
                        <img src="/images/casual2.jpg" alt="Urban casual collection" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('customer.product') }}" class="block w-full text-center bg-white text-gray-900 py-2 px-4 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                View Collection
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('customer.product') }}" class="hover:text-brown-800 transition-colors duration-200">
                                    Urban Walkers
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">Engineered for all-day comfort</p>
                        </div>
                        <p class="text-lg font-medium text-brown-800">From Rs.4999.99</p>
                    </div>
                </div>
                <!-- Collection 2 -->
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-100 aspect-w-1 aspect-h-1 rounded-lg overflow-hidden group-hover:opacity-90 transition-opacity duration-300 lg:h-80 lg:aspect-none">
                        <img src="/images/heals.jpg" alt="Elegant heels collection" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('customer.product') }}" class="block w-full text-center bg-white text-gray-900 py-2 px-4 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                View Collection
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="#" class="hover:text-brown-800 transition-colors duration-200">
                                    Evening Elegance
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">Sophisticated designs for special occasions</p>
                        </div>
                        <p class="text-lg font-medium text-brown-800">From Rs.2999.99</p>
                    </div>
                </div>
                <!-- Collection 3 -->
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-100 aspect-w-1 aspect-h-1 rounded-lg overflow-hidden group-hover:opacity-90 transition-opacity duration-300 lg:h-80 lg:aspect-none">
                        <img src="/images/casual.jpg" alt="Classic loafers collection" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('customer.product') }}" class="block w-full text-center bg-white text-gray-900 py-2 px-4 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                View Collection
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('customer.product') }}" class="hover:text-brown-800 transition-colors duration-200">
                                    Timeless Classics
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">Enduring styles that never go out of fashion</p>
                        </div>
                        <p class="text-lg font-medium text-brown-800">From Rs.3999.99</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <x-footer />
</x-app-layout>
