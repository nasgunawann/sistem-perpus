<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $anggota = Anggota::where('email', auth()->user()->email)->firstOrFail();
        return view('anggota.profil.edit', compact('anggota'));
    }

    public function update(Request $request)
    {
        $anggota = Anggota::where('email', auth()->user()->email)->firstOrFail();
        $user = auth()->user();

        $validated = $request->validate([
            'email' => 'required|email|unique:anggota,email,' . $anggota->id . '|unique:users,email,' . $user->id,
            'telepon' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Update anggota
        $anggota->update($validated);

        // Update user email if changed
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->save();
        }

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

        $user = auth()->user();

        // Check old password
        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        $user->password = Hash::make($validated['password_baru']);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
