<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Only available products, grouped by category
        $products = Product::where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $categories    = Product::$categories;
        $grouped       = $products->groupBy('category');
        $activeCategory = $request->get('category', 'all');

        return view('menu', compact('products', 'categories', 'grouped', 'activeCategory'));
    }
}
