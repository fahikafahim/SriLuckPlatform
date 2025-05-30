<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 font-[Montserrat] relative overflow-hidden"
     style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('/images/footwear-display.jpg') no-repeat center center; background-size: cover;">
        <div class="max-w-md w-full px-6 py-12 z-10">
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100">
                <div class="text-center mb-8">
                    <div class="text-2xl font-bold text-[#222] tracking-wider mb-2">SRILUCK FOOTWEAR</div>
                    <h2 class="text-3xl font-semibold text-[#222]">Admin Portal</h2>
                    <p class="text-gray-600 mt-2">Sign in to manage your store</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 p-4 rounded-sm border-l-4 border-red-500 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#080a22] focus:border-[#0b0f32] transition-all"
                               type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#080a22] focus:border-[#0b0f32] transition-all"
                               type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex flex-col space-y-4">
                        <button type="submit" class="text-gray-100 w-full btn-gold px-4 py-3 font-medium rounded-sm transition-all duration-300">
                            Admin Login
                        </button>

                        <div class="text-center text-sm text-gray-600">
                            Regular user?
                            <a href="{{ route('login') }}" class="font-medium text-gray-800 hover:text-[#414146] transition-colors">
                                Customer Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .btn-gold {
            background: linear-gradient(to right, #080a22, #686b76);

            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background: linear-gradient(to right, #51535c, #080a22);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
    </style>
</x-guest-layout>
