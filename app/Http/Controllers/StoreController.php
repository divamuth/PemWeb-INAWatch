<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function edit()
    {
        $store = Store::first();
        return view('seller.profile', compact('store'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instagram' => 'nullable|string',
            'x' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $store = Store::first();
        if (!$store) {
            $store = new Store();
        }

        $store->fill($validated);
        $store->save();

        return back()->with('success', 'Profil toko berhasil diperbarui!');
    }
}