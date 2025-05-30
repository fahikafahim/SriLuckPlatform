<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 font-[Montserrat] relative overflow-hidden"
     style="background-image: url('./images/register-bg.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-md w-full px-6 py-12 z-10">
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100">
                <div class="text-center mb-8">
                    <div class="text-2xl font-bold text-[#222] tracking-wider mb-2">SRILUCK FOOTWEAR</div>
                    <h2 class="text-3xl font-semibold text-[#222]">Create Account</h2>
                    <p class="text-gray-600 mt-2">Join us to access your exclusive collection</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 p-4 rounded-sm border-l-4 border-red-500 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input id="name" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" class="block w-full px-4 py-3 border border-gray-300 rounded-sm focus:ring-1 focus:ring-[#d4a76a] focus:border-[#d4a76a] transition-all"
                               type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <label for="terms" class="flex items-center">
                                <input id="terms" type="checkbox" name="terms" class="rounded border-gray-300 text-[#d4a76a] focus:ring-[#d4a76a] h-4 w-4" required />
                                <span class="ms-2 text-sm text-gray-600">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-gray-600 hover:text-[#d4a76a] transition-colors">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-gray-600 hover:text-[#d4a76a] transition-colors">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </span>
                            </label>
                        </div>
                    @endif

                    <div class="flex flex-col space-y-4">
                        <button type="submit" class="w-full btn-gold px-4 py-3 font-medium rounded-sm transition-all duration-300">
                            Register
                        </button>

                        <div class="text-center text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-[#d4a76a] hover:text-[#c1924d] transition-colors">
                                Sign in
                            </a>
                        </div>
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
