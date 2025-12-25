@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Dashboard</h4>
    <p class="text-muted">Selamat datang, {{ auth()->user()->nama }}</p>
</div>

<!-- Profile & Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3">Profil</h6>
                <div class="mb-2"><strong>{{ $anggota->nama }}</strong></div>
                <div class="small text-muted mb-1">{{ $anggota->kode_anggota }}</div>
                <div class="small text-muted mb-1">{{ $anggota->email }}</div>
                <div class="small text-muted">{{ $anggota->telepon }}</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted small">Sedang Dipinjam</div>
                        <h3 class="mb-0">{{ $bukuDipinjam }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted small">Total Peminjaman</div>
                        <h3 class="mb-0">{{ $totalPeminjaman }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted small">Denda Tertunggak</div>
                        <h3 class="mb-0 text-danger">Rp {{ number_format($dendaTertunggak, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted small">Batas Pinjam</div>
                        <h3 class="mb-0">{{ $bukuDipinjam }}/{{ $maksPinjam }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Currently Borrowed -->
@if($peminjamanAktif->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">Sedang Dipinjam</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanAktif as $p)
                            <tr>
                                <td>
                                    <div>{{ $p->buku->judul }}</div>
                                    <small class="text-muted">{{ $p->buku->pengarang }}</small>
                                </td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>{{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                <td>
                                    @if($p->isTerlambat())
                                        <span class="badge bg-danger">Terlambat {{ $p->hitungHariTerlambat() }} hari</span>
                                    @else
                                        <span class="badge bg-success">OK</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- History -->
<div class="card">
    <div class="card-header bg-white">
        <h6 class="mb-0">Riwayat Peminjaman</h6>
    </div>
    <div class="card-body">
        @if($riwayatPeminjaman->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Buku</th>
                            <th>Pinjam</th>
                            <th>Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatPeminjaman as $p)
                            <tr>
                                <td><code>{{ $p->kode_peminjaman }}</code></td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $p->status === 'dikembalikan' ? 'success' : 'warning' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $riwayatPeminjaman->links('pagination::bootstrap-5') }}
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Belum ada riwayat</p>
            </div>
        @endif
    </div>
</div>
@endsection
