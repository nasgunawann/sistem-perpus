@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Manajemen Anggota</h4>
    <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.anggota.index') }}" method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama/kode/email/nomor identitas...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
        @if($anggota->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $a)
                            <tr>
                                <td><code>{{ $a->kode_anggota }}</code></td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->telepon }}</td>
                                <td>
                                    <span class="badge bg-{{ $a->status === 'aktif' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td>{{ $a->tanggal_bergabung->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.anggota.show', $a) }}" class="btn btn-sm btn-info">Detail</a>
                                        <a href="{{ route('admin.anggota.edit', $a) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.anggota.destroy', $a) }}" method="POST" onsubmit="return confirm('Yakin hapus anggota ini?')">
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
                {{ $anggota->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Tidak ada data anggota</p>
            </div>
        @endif
    </div>
</div>
@endsection
