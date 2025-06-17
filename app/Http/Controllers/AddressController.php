<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;


class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'address_detail' => 'string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'post' => 'required|string',
        ]);

        Address::create([
            'user_id' => Auth::id(), 
            ...$validated
        ]);

        return redirect()->back()->with('success', 'Address berhasil ditambahkan!');
    }

    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('user.address', compact('addresses'));
    }
}
