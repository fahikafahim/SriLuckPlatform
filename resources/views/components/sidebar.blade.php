@livewireStyles
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-gray-900 border-r border-gray-800">
        <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
            <h1 class="text-white font-bold text-xl">Admin Dashboard</h1>
        </div>
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <nav class="flex-1 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.product') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-boxes mr-3"></i>
                    Products
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="{{ route('admin.order') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-shopping-bag mr-3"></i>
                    Orders
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
            </nav>
        </div>
        <div class="px-4 py-4 border-t border-gray-800">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-300">Admin User</p>
                    <p class="text-xs font-medium text-gray-500">admin@example.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('content')
@livewireScripts
