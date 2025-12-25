<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('anggota.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|unique:anggota,nomor_identitas',
            'email' => 'required|email|unique:users,email|unique:anggota,email',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nomor_identitas.required' => 'Nomor identitas harus diisi',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'telepon.required' => 'Nomor telepon harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'anggota',
            ]);

            // Generate Kode Anggota (Format: AGT{year}{increment})
            $year = date('Y');
            $lastAnggota = Anggota::whereYear('created_at', $year)->latest('id')->first();
            $increment = $lastAnggota ? (intval(substr($lastAnggota->kode_anggota, -4)) + 1) : 1;
            $kodeAnggota = 'AGT' . $year . str_pad($increment, 4, '0', STR_PAD_LEFT);

            // Create Anggota
            Anggota::create([
                'kode_anggota' => $kodeAnggota,
                'nama' => $validated['nama'],
                'nomor_identitas' => $validated['nomor_identitas'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'alamat' => $validated['alamat'],
                'status' => 'aktif',
                'tanggal_bergabung' => now(),
            ]);

            DB::commit();

            // Auto login
            Auth::login($user);

            return redirect()->route('anggota.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di perpustakaan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'
            ])->withInput();
        }
    }
}
