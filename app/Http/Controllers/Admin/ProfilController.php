<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profil.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $admin->update($validated);

        return back()->with('success', 'Profil berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama harus diisi',
            'password_baru.required' => 'Password baru harus diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $admin = auth()->user();

        // Check old password
        if (!Hash::check($validated['password_lama'], $admin->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        $admin->password = Hash::make($validated['password_baru']);
        $admin->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
