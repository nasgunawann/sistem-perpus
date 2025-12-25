<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Denda;

class DendaController extends Controller
{
    public function index()
    {
        // Get anggota data
        $anggota = Anggota::where('email', auth()->user()->email)->firstOrFail();

        // Get all denda for this anggota
        $denda = Denda::whereHas('peminjaman', function ($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
            ->with(['peminjaman.buku'])
            ->latest()
            ->paginate(10);

        return view('anggota.denda.index', compact('denda'));
    }
}
