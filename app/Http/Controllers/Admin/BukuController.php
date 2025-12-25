<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $buku = $query->latest()->paginate(10);
        $kategoris = Kategori::all();

        return view('admin.buku.index', compact('buku', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|unique:buku,isbn',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required' => 'Judul buku harus diisi',
            'isbn.unique' => 'ISBN sudah terdaftar',
            'kategori_id.required' => 'Kategori harus dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
        ]);

        // Handle cover upload
        if ($request->hasFile('foto_sampul')) {
            $file = $request->file('foto_sampul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('covers', $filename, 'public');
            $validated['foto_sampul'] = $path;
        }

        // Set tersedia = stok for new book
        $validated['tersedia'] = $validated['stok'];
        $validated['status'] = 'tersedia';

        Buku::create($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|unique:buku,isbn,' . $buku->id,
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle cover upload
        if ($request->hasFile('foto_sampul')) {
            // Delete old cover
            if ($buku->foto_sampul) {
                Storage::disk('public')->delete($buku->foto_sampul);
            }

            $file = $request->file('foto_sampul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('covers', $filename, 'public');
            $validated['foto_sampul'] = $path;
        }

        // Update tersedia based on stok change
        $stokDiff = $validated['stok'] - $buku->stok;
        $validated['tersedia'] = $buku->tersedia + $stokDiff;

        $buku->update($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        // Check if book is currently borrowed
        if ($buku->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->exists()) {
            return back()->with('error', 'Buku tidak bisa dihapus karena sedang dipinjam');
        }

        // Delete cover if exists
        if ($buku->foto_sampul) {
            Storage::disk('public')->delete($buku->foto_sampul);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
