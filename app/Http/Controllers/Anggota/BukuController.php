<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $buku = $query->latest()->paginate(12);
        $kategori = Kategori::all();

        return view('anggota.buku.index', compact('buku', 'kategori'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('anggota.buku.show', compact('buku'));
    }
}
