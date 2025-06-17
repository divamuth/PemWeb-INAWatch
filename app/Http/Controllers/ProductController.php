<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('seller.stock', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'variation' => 'required|string|max:255',
            'sale' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'variation' => $request->variation,
            'sale' => $request->sale,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath ?? 'images/contoh2.png'
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'variation' => 'required|string|max:255',
            'sale' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && $product->image !== 'images/contoh2.png') {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'product_name' => $request->product_name,
            'variation' => $request->variation,
            'sale' => $request->sale,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && $product->image !== 'images/contoh2.png') {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}