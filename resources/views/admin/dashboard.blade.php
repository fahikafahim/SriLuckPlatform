<x-app-layout>
    <style>
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

        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in forwards;
        }

        tr {
            transition: all 0.2s ease;
        }

        tr:hover {
            background-color: rgba(146, 64, 14, 0.05);
            transform: translateX(2px);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link.active {
            background-color: rgba(146, 64, 14, 0.1);
            border-left: 4px solid #92400e;
        }

        .product-image,
        .user-avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">

            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">

                <!-- Products Section -->
                <div class="bg-white rounded-lg shadow-lg border border-gray-200 animate-fade-in mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Product List</h3>
                        </div>
                        @livewire('admin-product-table')
                    </div>
                </div>

                <!-- Users Section  -->

                <!-- Users Section -->
                <div class="bg-white rounded-lg shadow-lg border border-gray-200 animate-fade-in">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">User List</h3>
                            <button class="bg-navy-600 text-white px-4 py-2 rounded-md hover:bg-navy-700 transition">Add
                                User</button>
                        </div>
                        @livewire('admin-user-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('hidden');
        });
    </script>
</x-app-layout>
