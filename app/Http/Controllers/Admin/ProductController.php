<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = Product::$categories;

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Product::$categories;
        $badges     = Product::$badges;
        return view('admin.products.form', compact('categories', 'badges'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'calories'     => 'nullable|integer|min:0',
            'badge'        => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_available'] = $request->boolean('is_available', true);

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Product::$categories;
        $badges     = Product::$badges;
        return view('admin.products.form', compact('product', 'categories', 'badges'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'calories'     => 'nullable|integer|min:0',
            'badge'        => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_available'] = $request->boolean('is_available');

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted.');
    }

    public function toggleAvailable(Product $product)
    {
        $product->update(['is_available' => !$product->is_available]);
        return response()->json([
            'is_available' => $product->is_available,
            'message'      => $product->is_available ? 'Product is now available.' : 'Product hidden from menu.',
        ]);
    }
}
