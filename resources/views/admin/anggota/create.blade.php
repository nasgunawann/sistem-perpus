@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Tambah Anggota</h4>
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
        
        <form action="{{ route('admin.anggota.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Identitas (NIK/NIM)</label>
                    <input type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" name="telepon" value="{{ old('telepon') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password (Opsional)</label>
                    <input type="password" class="form-control" name="password" placeholder="Kosongkan untuk default">
                    <small class="text-muted">Default: kode anggota</small>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                </div>
            </div>
            
            <div class="alert alert-info">
                <small><i class="bi bi-info-circle"></i> Kode anggota akan di-generate otomatis (AGT{{ date('Y') }}xxxx)</small><br>
                <small><i class="bi bi-key"></i> Jika password dikosongkan, password default = kode anggota</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
