<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use Laravel\Ui\Presets\React;

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

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function register() {
        return view('register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function cart(Request $request)
    {
        return view('user.cart');
    }

    public function profile (Request $request) {
        return view('user.profile');
    }

    public function address (Request $request) {
        return view('user.address');
    }

    public function order (Request $request) {
        return view('user.order');
    }
}