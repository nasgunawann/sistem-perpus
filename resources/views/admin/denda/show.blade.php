@extends('layouts.app')

@section('title', 'Detail & Pembayaran Denda')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Detail & Pembayaran Denda</h4>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Informasi Denda</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%">Kode Peminjaman</td>
                        <td><strong><code>{{ $denda->peminjaman->kode_peminjaman }}</code></strong></td>
                    </tr>
                    <tr>
                        <td>Hari Terlambat</td>
                        <td><strong>{{ $denda->hari_terlambat }} hari</strong></td>
                    </tr>
                    <tr>
                        <td>Jumlah Denda</td>
                        <td><strong>Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Sudah Dibayar</td>
                        <td>Rp {{ number_format($denda->jumlah_dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Sisa Denda</td>
                        <td><strong class="text-danger">Rp {{ number_format($denda->sisa_denda, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge bg-{{ $denda->status === 'sudah_bayar' ? 'success' : ($denda->status === 'sebagian' ? 'warning' : 'danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $denda->status)) }}
                            </span>
                        </td>
                    </tr>
                    @if($denda->tanggal_bayar)
                        <tr>
                            <td>Tanggal Lunas</td>
                            <td>{{ $denda->tanggal_bayar->format('d/m/Y H:i') }}</td>
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
                <div><strong>{{ $denda->peminjaman->anggota->nama }}</strong></div>
                <div class="small text-muted">{{ $denda->peminjaman->anggota->kode_anggota }}</div>
                <div class="small text-muted">{{ $denda->peminjaman->anggota->email }}</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Buku</h6>
            </div>
            <div class="card-body">
                <div><strong>{{ $denda->peminjaman->buku->judul }}</strong></div>
                <div class="small text-muted">{{ $denda->peminjaman->buku->pengarang }}</div>
            </div>
        </div>
    </div>
</div>

@if($denda->status !== 'sudah_bayar')
    <div class="card mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0">Form Pembayaran</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.denda.pay', $denda) }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" class="form-control" name="jumlah_bayar" min="0" max="{{ $denda->sisa_denda }}" step="1000" required>
                        <small class="text-muted">Maksimal: Rp {{ number_format($denda->sisa_denda, 0, ',', '.') }}</small>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                    <button type="button" class="btn btn-primary" onclick="document.querySelector('input[name=jumlah_bayar]').value = {{ $denda->sisa_denda }}">
                        Bayar Penuh
                    </button>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> <strong>Denda sudah lunas</strong>
    </div>
@endif

<a href="{{ route('admin.denda.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
