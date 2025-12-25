@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Manajemen Buku</h4>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">Tambah Buku</a>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.buku.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari judul/pengarang/ISBN...">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
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
        @if($buku->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Kategori</th>
                            <th>ISBN</th>
                            <th>Stok</th>
                            <th>Tersedia</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $b)
                            <tr>
                                <td>{{ $b->judul }}</td>
                                <td>{{ $b->pengarang }}</td>
                                <td>{{ $b->kategori->nama }}</td>
                                <td><code>{{ $b->isbn }}</code></td>
                                <td>{{ $b->stok }}</td>
                                <td>{{ $b->tersedia }}</td>
                                <td>
                                    <span class="badge bg-{{ $b->status === 'tersedia' ? 'success' : ($b->status === 'dipinjam' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.buku.edit', $b) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.buku.destroy', $b) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $buku->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Tidak ada data buku</p>
            </div>
        @endif
    </div>
</div>
@endsection
