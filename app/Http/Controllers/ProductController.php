<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function userIndex()
    {
        $products = Product::paginate(100);
        return view('customer.product', compact('products'));
    }
    public function userShow(Product $product)
{
    return view('customer.product_show', compact('product'));
}
    // GET /api/products
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    // POST /api/products
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id'    => 'exists:users,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'required|string|max:10',
            'color'       => 'nullable|string|max:50',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = 'storage/' . $path;
        }

        $product = Product::create($validated);

        return new ProductResource($product);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'required|string|max:10',
            'color'       => 'nullable|string|max:50',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $product->image_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image_url));
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = 'storage/' . $path;
        }

        $product->update($validated);

        return new ProductResource($product);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if it exists
        if ($product->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $product->image_url))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image_url));
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
