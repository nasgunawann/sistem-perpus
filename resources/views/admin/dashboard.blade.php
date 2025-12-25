@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Dashboard</h4>
</div>

<!-- Statistics -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Total Buku</div>
                <h3 class="mb-0">{{ $totalBuku }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Anggota Aktif</div>
                <h3 class="mb-0">{{ $anggotaAktif }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Sedang Dipinjam</div>
                <h3 class="mb-0">{{ $peminjamanAktif }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Denda Tertunggak</div>
                <h3 class="mb-0 text-danger">Rp {{ number_format($dendaTertunggak, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted small mb-2">Peminjaman Bulan Ini</h6>
                <h4 class="mb-0">{{ $peminjamanBulanIni }} transaksi</h4>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-4">
    <div class="card-body">
        <h6 class="mb-3">Aksi Cepat</h6>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.buku.create') }}" class="btn btn-sm btn-primary">Tambah Buku</a>
            <a href="{{ route('admin.anggota.create') }}" class="btn btn-sm btn-success">Tambah Anggota</a>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-sm btn-warning">Proses Peminjaman</a>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header bg-white">
        <h6 class="mb-0">Peminjaman Terbaru</h6>
    </div>
    <div class="card-body">
        @if($peminjamanTerbaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanTerbaru as $p)
                            <tr>
                                <td><code>{{ $p->kode_peminjaman }}</code></td>
                                <td>{{ $p->anggota->nama }}</td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $p->status === 'dipinjam' ? 'warning' : ($p->status === 'dikembalikan' ? 'success' : 'danger') }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Belum ada data</p>
            </div>
        @endif
    </div>
</div>
@endsection
