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

        if (!$user->profil()->exists()) {
        $user->profil()->create([
            'user_id'=> $user->id,
            'name' => '',
            'phone' => '',
            'gender' => '',
            'birthdate' => null,
            'image' => null,
        ]);
    }

        $profil = $user->profil;

        return view('user.profile', compact('user', 'profil'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        // Tangani upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profiles'), $imageName);
        } else {
            // GUNAKAN optional() di sini
            $imageName = optional($user->profil)->image;
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

        // Update tabel users
        $user->update([
            'name' => $request->username,
            'email' => $request->email,
        ]);

        // Update atau buat profil (kalau belum ada)
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
