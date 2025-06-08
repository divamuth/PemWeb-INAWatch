<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->query('search');
        
        // Fetch products, filter by search if provided
        $products = Product::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();
        
        return view('user.dashboard', compact('products', 'search'));
    }
}