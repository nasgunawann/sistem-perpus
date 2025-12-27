@extends('layouts.app')

@section('title', 'Manajemen Denda')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Manajemen Denda</h4>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.denda.index') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari anggota...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="sebagian" {{ request('status') == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                    <option value="sudah_bayar" {{ request('status') == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body">
        @if($denda->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode Pinjam</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Terlambat</th>
                            <th>Jumlah</th>
                            <th>Dibayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denda as $d)
                            <tr>
                                <td><code>{{ $d->peminjaman->kode_peminjaman }}</code></td>
                                <td>{{ $d->peminjaman->anggota->nama }}</td>
                                <td>{{ $d->peminjaman->buku->judul }}</td>
                                <td>{{ $d->hari_terlambat }} hari</td>
                                <td>Rp {{ number_format($d->jumlah_denda, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($d->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($d->sisa_denda, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $d->status === 'sudah_bayar' ? 'success' : ($d->status === 'sebagian' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $d->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.denda.show', $d) }}" class="btn btn-sm btn-info">Detail</a>
                                        @if($d->status !== 'sudah_bayar')
                                            <a href="{{ route('admin.denda.show', $d) }}" class="btn btn-sm btn-success">Bayar</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $denda->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Tidak ada data denda</p>
            </div>
        @endif
    </div>
</div>
@endsection
