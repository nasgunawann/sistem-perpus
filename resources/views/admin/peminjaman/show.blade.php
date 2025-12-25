@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Detail Peminjaman</h4>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Informasi Peminjaman</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%">Kode Peminjaman</td>
                        <td><strong><code>{{ $peminjaman->kode_peminjaman }}</code></strong></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <span class="badge bg-{{ $peminjaman->status === 'dikembalikan' ? 'success' : ($peminjaman->status === 'terlambat' ? 'danger' : 'warning') }}">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Pinjam</td>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jatuh Tempo</td>
                        <td>{{ $peminjaman->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kembali</td>
                        <td>{{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @if($peminjaman->catatan)
                        <tr>
                            <td>Catatan</td>
                            <td>{{ $peminjaman->catatan }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card mb-3">
            <div class="card-header bg-white">
                <h6 class="mb-0">Anggota</h6>
            </div>
            <div class="card-body">
                <div><strong>{{ $peminjaman->anggota->nama }}</strong></div>
                <div class="small text-muted">{{ $peminjaman->anggota->kode_anggota }}</div>
                <div class="small text-muted">{{ $peminjaman->anggota->email }}</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Buku</h6>
            </div>
            <div class="card-body">
                <div><strong>{{ $peminjaman->buku->judul }}</strong></div>
                <div class="small text-muted">{{ $peminjaman->buku->pengarang }}</div>
                <div class="small text-muted">ISBN: {{ $peminjaman->buku->isbn }}</div>
            </div>
        </div>
    </div>
</div>

@if($peminjaman->denda)
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0">Informasi Denda</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <strong>Terlambat {{ $peminjaman->denda->hari_terlambat }} hari</strong><br>
                Jumlah Denda: <strong>Rp {{ number_format($peminjaman->denda->jumlah_denda, 0, ',', '.') }}</strong><br>
                Sudah Dibayar: Rp {{ number_format($peminjaman->denda->jumlah_dibayar, 0, ',', '.') }}<br>
                Sisa: Rp {{ number_format($peminjaman->denda->sisa_denda, 0, ',', '.') }}<br>
                Status: <span class="badge bg-{{ $peminjaman->denda->status === 'lunas' ? 'success' : 'danger' }}">{{ ucfirst($peminjaman->denda->status) }}</span>
            </div>
        </div>
    </div>
@endif

<div class="d-flex gap-2">
    @if(in_array($peminjaman->status, ['dipinjam', 'terlambat']))
        <form action="{{ route('admin.peminjaman.return', $peminjaman) }}" method="POST" onsubmit="return confirm('Proses pengembalian buku ini?')">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="bi bi-arrow-return-left"></i> Proses Pengembalian
            </button>
        </form>
    @endif
    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
