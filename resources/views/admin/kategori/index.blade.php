@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Manajemen Kategori</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Kategori</button>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body">
        @if($kategoris->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $k)
                            <tr>
                                <td>{{ $k->nama }}</td>
                                <td><code>{{ $k->kode }}</code></td>
                                <td>{{ $k->deskripsi ?? '-' }}</td>
                                <td>{{ $k->buku_count }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}">Edit</button>
                                        <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit{{ $k->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.kategori.update', $k) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h6 class="modal-title">Edit Kategori</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kategori</label>
                                                    <input type="text" class="form-control" name="nama" value="{{ $k->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kode</label>
                                                    <input type="text" class="form-control" name="kode" value="{{ $k->kode }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" name="deskripsi" rows="2">{{ $k->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p class="mb-0">Belum ada kategori</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title">Tambah Kategori</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
