<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Pengaturan;

class DashboardController extends Controller
{
    public function index()
    {
        // Get anggota data from authenticated user's email
        $anggota = Anggota::where('email', auth()->user()->email)->firstOrFail();

        // Statistics
        $bukuDipinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $totalPeminjaman = Peminjaman::where('anggota_id', $anggota->id)->count();

        // Fix: Correct denda status enum values
        $dendaTertunggak = Denda::whereHas('peminjaman', function ($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
            ->whereIn('status', ['belum_bayar', 'sebagian'])
            ->sum('jumlah_denda');

        // Subtract what's been paid for partial payments
        $dendaDibayar = Denda::whereHas('peminjaman', function ($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
            ->whereIn('status', ['belum_bayar', 'sebagian'])
            ->sum('jumlah_dibayar');

        $dendaTertunggak = $dendaTertunggak - $dendaDibayar;

        $maksPinjam = Pengaturan::ambil('maks_pinjam_buku', 3);

        // Currently borrowed books
        $peminjamanAktif = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->get();

        // Loan history with pagination
        $riwayatPeminjaman = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->paginate(10);

        return view('anggota.dashboard', compact(
            'anggota',
            'bukuDipinjam',
            'totalPeminjaman',
            'dendaTertunggak',
            'maksPinjam',
            'peminjamanAktif',
            'riwayatPeminjaman'
        ));
    }
}
