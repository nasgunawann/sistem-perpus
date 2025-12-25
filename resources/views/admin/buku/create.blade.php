@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Tambah Buku</h4>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" class="form-control" name="pengarang" value="{{ old('pengarang') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" value="{{ old('penerbit') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">ISBN</label>
                    <input type="text" class="form-control" name="isbn" value="{{ old('isbn') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" value="{{ old('stok', 0) }}" min="0" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cover Buku (Opsional)</label>
                    <input type="file" class="form-control" name="foto_sampul" accept="image/*">
                    <small class="text-muted">Max 2MB (JPG, PNG)</small>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
