<div class="overflow-x-auto animate-fade-in">
    <table id="products-table" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-900">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Size</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Color</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-amber-50 uppercase tracking-wider">Image</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->size }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->color }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <span class="text-gray-400">No image</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-sm text-gray-600">No products found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-500">
            Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of
            <span class="font-medium">{{ $products->count() }}</span> results
        </div>
        <a href="{{ route('admin.product') }}" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            View All Products
        </a>
    </div>
</div>
