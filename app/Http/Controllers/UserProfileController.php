<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profil;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profil = $user->profil;

        return view('user.profile', compact('user', 'profil'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Tangani upload gambar duluan
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profiles'), $imageName);
        } else {
            $imageName = $user->profil->image ?? null;
        }

        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        // Simpan ke tabel `users`
        $user->update([
            'name' => $request->username,
            'email' => $request->email,
        ]);

        // Simpan ke tabel `profils`
        $user->profil()->updateOrCreate([], [
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'image' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Profile updated!');
    }
}
