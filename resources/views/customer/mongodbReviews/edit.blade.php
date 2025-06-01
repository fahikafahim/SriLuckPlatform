<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Page Heading -->
                    <h1 class="text-2xl font-bold mb-6">Edit Your Review for Order #{{ $review->order_id }}</h1>

                    <!-- Review Update Form -->
                    <form method="POST" action="{{ route('customer.mongodbReviews.update', $review->_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Star Rating Selection -->
                        <div class="mb-6">
                            <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="text-3xl focus:outline-none rating-star" data-value="{{ $i }}">
                                        <span class="{{ $i <= old('rating', $review->rating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                    </button>
                                @endfor
                                <!-- Hidden input to store rating value -->
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating', $review->rating) }}">
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Review Comment Textarea -->
                        <div class="mb-6">
                            <label for="comment" class="block text-gray-700 font-medium mb-2">Review</label>
                            <textarea id="comment" name="comment" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Current Uploaded Images -->
                        @if(!empty($review->images))
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Current Images</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($review->images as $image)
                                        <div class="relative group">
                                            <!-- Image Preview -->
                                            <img src="{{ Storage::url($image) }}" alt="Review image" class="w-full h-32 object-cover rounded-md">

                                            <!-- Delete Overlay Button -->
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" class="text-white bg-red-500 hover:bg-red-600 rounded-full p-2 delete-image-btn" data-image="{{ $image }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Hidden input to store deleted image names -->
                                <input type="hidden" name="deleted_images" id="deleted_images" value="">
                            </div>
                        @endif

                        <!-- File Upload for Adding New Images -->
                        <div class="mb-6">
                            <label for="images" class="block text-gray-700 font-medium mb-2">Add More Images (Optional)</label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-gray-500 text-sm mt-1">You can upload up to 5 images (2MB each)</p>
                            @error('images.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                            <!-- Cancel Button -->
                            <a href="{{ route('customer.mongodbReviews.show', $review->_id) }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors">
                                Cancel
                            </a>
                            <!-- Submit Button -->
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Handle star rating click and update hidden input + star visuals
            document.querySelectorAll('.rating-star').forEach(star => {
                star.addEventListener('click', () => {
                    const value = parseInt(star.getAttribute('data-value'));
                    document.getElementById('rating').value = value;

                    // Update star colors based on selection
                    document.querySelectorAll('.rating-star').forEach((s, index) => {
                        const starValue = parseInt(s.getAttribute('data-value'));
                        const starSpan = s.querySelector('span');
                        starSpan.className = starValue <= value ? 'text-yellow-400' : 'text-gray-300';
                    });
                });
            });

            // Handle image deletion and update hidden input
            document.querySelectorAll('.delete-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imagePath = this.getAttribute('data-image');
                    const deletedImagesInput = document.getElementById('deleted_images');
                    let deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];

                    // Prevent duplicates and update input value
                    if (!deletedImages.includes(imagePath)) {
                        deletedImages.push(imagePath);
                        deletedImagesInput.value = deletedImages.join(',');

                        // Visually hide the image block
                        this.closest('.relative').style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
