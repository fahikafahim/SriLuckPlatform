<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display paginated products list for users (frontend)
     * @return \Illuminate\View\View Rendered product listing view
     */
    public function userIndex()
    {
        $products = Product::paginate(100);
        return view('customer.product', compact('products'));
    }

    /**
     * Display single product details for users (frontend)
     * @param Product $product Product model instance
     * @return \Illuminate\View\View Rendered product detail view
     */
    public function userShow(Product $product)
    {
        return view('customer.product_show', compact('product'));
    }

    /**
     * Get all products (API endpoint)
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of all products
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Create a new product (API endpoint)
     * @param Request $request Contains product data
     * @return ProductResource Newly created product resource
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'admin_id'    => 'exists:users,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'required|string|max:10',
            'color'       => 'nullable|string|max:50',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = 'storage/' . $path;
        }

        // Create and return new product
        $product = Product::create($validated);
        return new ProductResource($product);
    }

    /**
     * Get specific product details (API endpoint)
     * @param int $id Product ID
     * @return ProductResource Requested product resource
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    /**
     * Update existing product (API endpoint)
     * @param Request $request Updated product data
     * @param int $id Product ID
     * @return ProductResource Updated product resource
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate incoming request data
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'required|string|max:10',
            'color'       => 'nullable|string|max:50',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        // Handle image update if new image provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $product->image_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image_url));
            }

            // Store new image
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = 'storage/' . $path;
        }

        // Update and return product
        $product->update($validated);
        return new ProductResource($product);
    }

    /**
     * Delete a product (API endpoint)
     * @param int $id Product ID
     * @return \Illuminate\Http\JsonResponse Deletion confirmation response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated image if exists
        if ($product->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $product->image_url))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image_url));
        }

        // Delete product record
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
