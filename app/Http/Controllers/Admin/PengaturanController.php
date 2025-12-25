<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = [
            'lama_peminjaman' => Pengaturan::ambil('lama_peminjaman', 7),
            'maks_pinjam_buku' => Pengaturan::ambil('maks_pinjam_buku', 3),
            'tarif_denda' => Pengaturan::ambil('tarif_denda', 1000),
        ];

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'lama_peminjaman' => 'required|integer|min:1|max:30',
            'maks_pinjam_buku' => 'required|integer|min:1|max:10',
            'tarif_denda' => 'required|integer|min:0',
        ], [
            'lama_peminjaman.required' => 'Lama peminjaman harus diisi',
            'lama_peminjaman.min' => 'Lama peminjaman minimal 1 hari',
            'lama_peminjaman.max' => 'Lama peminjaman maksimal 30 hari',
            'maks_pinjam_buku.required' => 'Maksimal pinjam buku harus diisi',
            'maks_pinjam_buku.min' => 'Maksimal pinjam minimal 1 buku',
            'maks_pinjam_buku.max' => 'Maksimal pinjam maksimal 10 buku',
            'tarif_denda.required' => 'Tarif denda harus diisi',
            'tarif_denda.min' => 'Tarif denda minimal 0',
        ]);

        foreach ($validated as $key => $value) {
            Pengaturan::atur($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil diupdate');
    }
}
