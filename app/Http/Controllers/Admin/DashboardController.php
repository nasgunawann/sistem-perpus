<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalBuku = Buku::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $peminjamanAktif = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();

        // Financial stats
        $dendaTertunggak = Denda::whereIn('status', ['belum_bayar', 'sebagian'])->sum('jumlah_denda')
            - Denda::whereIn('status', ['belum_bayar', 'sebagian'])->sum('jumlah_dibayar');

        // Monthly stats
        $peminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Recent transactions
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'anggotaAktif',
            'peminjamanAktif',
            'dendaTertunggak',
            'peminjamanBulanIni',
            'peminjamanTerbaru'
        ));
    }
}
