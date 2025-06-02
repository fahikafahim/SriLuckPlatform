<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 font-[Montserrat] relative overflow-hidden"
     style="background-image: url('./images/login-bg.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-md w-full px-6 py-12 z-10">
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100">
                <div class="text-center mb-8">
                    <div class="text-2xl font-bold text-[#222] tracking-wider mb-2">SRILUCK FOOTWEAR</div>
                    <h2 class="text-3xl font-semibold text-[#222]">Welcome Back</h2>
                    <p class="text-gray-600 mt-2">Sign in to access your exclusive collection</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 p-4 rounded-sm border-l-4 border-red-500 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 bg-green-50 p-4 rounded-sm border-l-4 border-green-500 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="password" name="password" required autocomplete="current-password" />
                    </div>

        

                    <div class="flex flex-col space-y-4">
                        <button type="submit" class="w-full btn-gold px-4 py-3 font-medium rounded-sm transition-all duration-300">
                            Sign In
                        </button>

                        @if (Route::has('register'))
                            <div class="text-center text-sm text-gray-600">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="font-medium text-[#d4a76a] hover:text-[#c1924d] transition-colors">
                                    Register now
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Reuse the same styles from welcome page */
        .btn-gold {
            background: linear-gradient(to right, #d4a76a, #e8c887);
            color: #222;
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background: linear-gradient(to right, #e8c887, #d4a76a);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Background pattern fallback */
        body {
            background-color: #f9f9f9;
        }
    </style>
</x-guest-layout>
