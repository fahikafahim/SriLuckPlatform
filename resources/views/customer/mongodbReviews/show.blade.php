{{--
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    CURRENT REVIEW
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold">Your Review for Order #{{ $review->order_id }}</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('customer.mongodbReviews.edit', $review->_id) }}"
                                class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 transition-colors text-sm">
                                Edit
                            </a>
                            <form action="{{ route('customer.mongodbReviews.show', $review->_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition-colors text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center mb-2">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        class="text-2xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">Posted on
                                {{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-gray-800">{{ $review->comment }}</p>
                    </div>

                    @if (!empty($review->images))
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Images</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($review->images as $image)
                                    <div class="border rounded-md overflow-hidden">
                                        <img src="{{ Storage::url($image) }}" alt="Review image"
                                            class="w-full h-48 object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    Continue Shopping Button
                    <div class="border-t pt-6">
                        <a href="{{ route('customer.product') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            OTHER REVIEWS BY USER
            <div class="mt-12 bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-xl font-semibold mb-6">Your Other Reviews</h2>

                @php
                    $otherReviews = \App\Models\mongodbReview::where('user_id', auth()->id())
                        ->where('_id', '!=', $review->_id)
                        ->latest()
                        ->get();
                @endphp

                @if ($otherReviews->isEmpty())
                    <p class="text-gray-600">You have not posted any other reviews yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($otherReviews as $other)
                            <div class="border p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    class="text-lg {{ $i <= $other->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <p class="text-gray-700">{{ $other->comment }}</p>
                                        <small class="text-gray-500">Order #{{ $other->order_id }} •
                                            {{ $other->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('customer.mongodbReviews.show', $other->_id) }}"
                                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition-colors text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('customer.mongodbReviews.edit', $other->_id) }}"
                                            class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 transition-colors text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('customer.mongodbReviews.destroy', $other->_id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition-colors text-sm">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> --}}
