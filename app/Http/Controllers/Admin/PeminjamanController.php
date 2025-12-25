<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('anggota', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $peminjaman = $query->latest()->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku = Buku::where('tersedia', '>', 0)->get();
        $lamaPinjam = Pengaturan::ambil('lama_peminjaman', 7);

        return view('admin.peminjaman.create', compact('anggota', 'buku', 'lamaPinjam'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:buku,id',
            'catatan' => 'nullable|string',
        ], [
            'anggota_id.required' => 'Anggota harus dipilih',
            'buku_id.required' => 'Buku harus dipilih',
        ]);

        $anggota = Anggota::findOrFail($validated['anggota_id']);
        $buku = Buku::findOrFail($validated['buku_id']);

        // Validasi anggota aktif
        if ($anggota->status !== 'aktif') {
            return back()->with('error', 'Anggota tidak aktif, silakan aktifkan terlebih dahulu')->withInput();
        }

        // Validasi buku tersedia
        if ($buku->tersedia < 1) {
            return back()->with('error', 'Buku tidak tersedia')->withInput();
        }

        // Validasi maksimal peminjaman
        $maksPinjam = Pengaturan::ambil('maks_pinjam_buku', 3);
        $currentLoans = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        if ($currentLoans >= $maksPinjam) {
            return back()->with('error', "Anggota sudah mencapai batas maksimal peminjaman ({$maksPinjam} buku)")->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate Kode Peminjaman (Format: PJM{year}{increment})
            $year = date('Y');
            $lastPeminjaman = Peminjaman::whereYear('created_at', $year)->latest('id')->first();
            $increment = $lastPeminjaman ? (intval(substr($lastPeminjaman->kode_peminjaman, -4)) + 1) : 1;
            $kodePeminjaman = 'PJM' . $year . str_pad($increment, 4, '0', STR_PAD_LEFT);

            // Calculate tanggal jatuh tempo
            $lamaPinjam = Pengaturan::ambil('lama_peminjaman', 7);
            $tanggalPinjam = now();
            $tanggalJatuhTempo = now()->addDays($lamaPinjam);

            // Create peminjaman
            Peminjaman::create([
                'kode_peminjaman' => $kodePeminjaman,
                'anggota_id' => $validated['anggota_id'],
                'buku_id' => $validated['buku_id'],
                'user_id' => auth()->id(),
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'status' => 'dipinjam',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // Update stok buku
            $buku->tersedia--;
            $buku->save();

            DB::commit();

            return redirect()->route('admin.peminjaman.index')->with('success', "Peminjaman berhasil. Kode: {$kodePeminjaman}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses peminjaman')->withInput();
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'buku', 'denda']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function return(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya');
        }

        DB::beginTransaction();

        try {
            $tanggalKembali = now();

            // Update peminjaman
            $peminjaman->tanggal_kembali = $tanggalKembali;
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            // Update stok buku
            $buku = $peminjaman->buku;
            $buku->tersedia++;
            $buku->save();

            // Cek dan create denda jika terlambat
            if ($tanggalKembali > $peminjaman->tanggal_jatuh_tempo) {
                $hariTerlambat = $tanggalKembali->diffInDays($peminjaman->tanggal_jatuh_tempo);
                $tarifDenda = Pengaturan::ambil('tarif_denda', 1000);
                $jumlahDenda = $hariTerlambat * $tarifDenda;

                Denda::create([
                    'peminjaman_id' => $peminjaman->id,
                    'user_id' => auth()->id(),
                    'hari_terlambat' => $hariTerlambat,
                    'jumlah_denda' => $jumlahDenda,
                    'jumlah_dibayar' => 0,
                    'status' => 'belum_bayar',
                ]);

                $message = "Pengembalian berhasil. Terlambat {$hariTerlambat} hari. Denda: Rp " . number_format($jumlahDenda, 0, ',', '.');
            } else {
                $message = 'Pengembalian berhasil. Tepat waktu, tidak ada denda.';
            }

            DB::commit();

            return redirect()->route('admin.peminjaman.show', $peminjaman)->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses pengembalian');
        }
    }
}
