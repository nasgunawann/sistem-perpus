<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_anggota', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nomor_identitas', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggota = $query->latest()->paginate(10);

        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function show(Anggota $anggotum)
    {
        $anggota = $anggotum;

        // Get borrowing history with pagination
        $riwayat = $anggota->peminjaman()
            ->with(['buku', 'denda'])
            ->latest()
            ->paginate(10);

        // Stats
        $totalPeminjaman = $anggota->peminjaman()->count();
        $sedangDipinjam = $anggota->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->count();
        $dendaTotal = $anggota->peminjaman()
            ->join('denda', 'peminjaman.id', '=', 'denda.peminjaman_id')
            ->whereIn('denda.status', ['belum_bayar', 'sebagian'])
            ->sum('denda.jumlah_denda');

        return view('admin.anggota.show', compact('anggota', 'riwayat', 'totalPeminjaman', 'sedangDipinjam', 'dendaTotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|unique:anggota,nomor_identitas',
            'email' => 'required|email|unique:anggota,email|unique:users,email',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'password' => 'nullable|string|min:8',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nomor_identitas.required' => 'Nomor identitas harus diisi',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'telepon.required' => 'Nomor telepon harus diisi',
            'alamat.required' => 'Alamat harus diisi',
        ]);

        // Generate Kode Anggota (Format: AGT{year}{increment})
        $year = date('Y');
        $lastAnggota = Anggota::whereYear('created_at', $year)->latest('id')->first();
        $increment = $lastAnggota ? (intval(substr($lastAnggota->kode_anggota, -4)) + 1) : 1;
        $kodeAnggota = 'AGT' . $year . str_pad($increment, 4, '0', STR_PAD_LEFT);

        // Set password: use input or default to kode_anggota
        $password = $request->filled('password') ? $request->password : $kodeAnggota;

        // Create User Account
        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'role' => 'anggota',
        ]);

        // Create Anggota Record
        $validated['kode_anggota'] = $kodeAnggota;
        $validated['tanggal_bergabung'] = now();

        Anggota::create($validated);

        $message = 'Anggota berhasil ditambahkan';
        if (!$request->filled('password')) {
            $message .= '. Password default: ' . $kodeAnggota;
        }

        return redirect()->route('admin.anggota.index')->with('success', $message);
    }

    public function edit(Anggota $anggotum)
    {
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    public function update(Request $request, Anggota $anggotum)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|unique:anggota,nomor_identitas,' . $anggotum->id,
            'email' => 'required|email|unique:anggota,email,' . $anggotum->id,
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $anggotum->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diupdate');
    }

    public function destroy(Anggota $anggotum)
    {
        // Check if anggota has loan history
        if ($anggotum->peminjaman()->count() > 0) {
            return back()->with('error', 'Anggota tidak bisa dihapus karena memiliki riwayat peminjaman');
        }

        $anggotum->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
