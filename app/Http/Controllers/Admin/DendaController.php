<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Denda::with(['peminjaman.anggota', 'peminjaman.buku']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by anggota
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peminjaman.anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_anggota', 'like', "%{$search}%");
            });
        }

        $denda = $query->latest()->paginate(10);

        return view('admin.denda.index', compact('denda'));
    }

    public function show(Denda $denda)
    {
        $denda->load(['peminjaman.anggota', 'peminjaman.buku']);
        return view('admin.denda.show', compact('denda'));
    }

    public function pay(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar harus diisi',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka',
            'jumlah_bayar.min' => 'Jumlah bayar minimal 0',
        ]);

        $jumlahBayar = $validated['jumlah_bayar'];
        $sisaDenda = $denda->sisa_denda;

        // Validasi
        if ($jumlahBayar <= 0) {
            return back()->with('error', 'Jumlah bayar harus lebih dari 0');
        }

        if ($jumlahBayar > $sisaDenda) {
            return back()->with('error', "Jumlah bayar tidak boleh melebihi sisa denda (Rp " . number_format($sisaDenda, 0, ',', '.') . ")");
        }

        if ($denda->status === 'lunas') {
            return back()->with('error', 'Denda sudah lunas');
        }

        DB::beginTransaction();

        try {
            // Update jumlah dibayar
            $denda->jumlah_dibayar += $jumlahBayar;

            // Check if lunas
            if ($denda->jumlah_dibayar >= $denda->jumlah_denda) {
                $denda->status = 'lunas';
                $denda->tanggal_bayar = now();
                $message = 'Pembayaran berhasil. Denda telah lunas.';
            } else {
                $denda->status = 'sebagian';
                $message = 'Pembayaran berhasil. Sisa denda: Rp ' . number_format($denda->sisa_denda, 0, ',', '.');
            }

            $denda->save();

            DB::commit();

            return redirect()->route('admin.denda.show', $denda)->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses pembayaran');
        }
    }
}
