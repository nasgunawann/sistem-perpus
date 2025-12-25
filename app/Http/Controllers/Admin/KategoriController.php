<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('buku')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama',
            'kode' => 'required|string|max:10|unique:kategori,kode',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'kode.required' => 'Kode kategori harus diisi',
            'kode.unique' => 'Kode kategori sudah ada',
        ]);

        Kategori::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $kategori->id,
            'kode' => 'required|string|max:10|unique:kategori,kode,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori)
    {
        // Check if kategori has books
        if ($kategori->buku()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih ada buku');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
