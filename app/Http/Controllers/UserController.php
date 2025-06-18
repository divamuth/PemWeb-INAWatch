<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->query('search');
        
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
            return redirect()->route('user.dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard')->with('success', 'Login successful! Welcome back!');
        }

        return back()->with('error', 'Incorrect email or password');
    }

    public function register()
    {
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

    public function custom($id = null)
    {
        if ($id) {
            $product = Product::findOrFail($id);
            return view('user.custom', compact('product'));
        } else {
            return redirect()->route('user.dashboard')->with('error', 'Product not found');
        }
    }

    public function profile(Request $request)
    {
        return view('user.profile');
    }

    public function address(Request $request)
    {
        return view('user.address');
    }

    public function order(Request $request)
    {
        return view('user.order');
    }

    public function chatuser(Request $request)
    {
        return view('user.chatuser');
    }

    public function payment()
    {
        return view('user.payment');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan ke database
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // Login langsung
        Auth::login($user);

        // Redirect ke dashboard user
        return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to Ina Watch.');
    }
}