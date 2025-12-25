@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Manajemen Peminjaman</h4>
    <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">Proses Peminjaman</a>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari kode/anggota...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
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
        @if($peminjaman->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $p)
                            <tr>
                                <td><code>{{ $p->kode_peminjaman }}</code></td>
                                <td>{{ $p->anggota->nama }}</td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>{{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $p->status === 'dikembalikan' ? 'success' : ($p->status === 'terlambat' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.peminjaman.show', $p) }}" class="btn btn-sm btn-info">Detail</a>
                                        @if(in_array($p->status, ['dipinjam', 'terlambat']))
                                            <form action="{{ route('admin.peminjaman.return', $p) }}" method="POST" onsubmit="return confirm('Proses pengembalian buku ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $peminjaman->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Tidak ada data peminjaman</p>
            </div>
        @endif
    </div>
</div>
@endsection
