@extends('layouts.app')

@section('title', 'Denda Saya')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Denda Saya</h4>
</div>

@if($denda->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Terlambat</th>
                            <th>Jumlah Denda</th>
                            <th>Dibayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denda as $d)
                            <tr>
                                <td>
                                    <div><strong>{{ $d->peminjaman->buku->judul }}</strong></div>
                                    <small class="text-muted">Kode: {{ $d->peminjaman->kode_peminjaman }}</small>
                                </td>
                                <td>{{ $d->hari_terlambat }} hari</td>
                                <td>Rp {{ number_format($d->jumlah_denda, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($d->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td><strong class="text-danger">Rp {{ number_format($d->sisa_denda, 0, ',', '.') }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $d->status === 'lunas' ? 'success' : ($d->status === 'sebagian' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $d->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $denda->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i> <strong>Info:</strong> Untuk pembayaran denda, silakan hubungi admin perpustakaan.
    </div>
@else
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-check-circle" style="font-size: 3rem;"></i>
            <p class="mb-0 mt-2">Tidak ada denda</p>
        </div>
    </div>
@endif
@endsection
