@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Edit Anggota</h4>
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
        
        <form action="{{ route('admin.anggota.update', $anggota) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Anggota</label>
                    <input type="text" class="form-control" value="{{ $anggota->kode_anggota }}" disabled>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bergabung</label>
                    <input type="text" class="form-control" value="{{ $anggota->tanggal_bergabung->format('d/m/Y') }}" disabled>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama', $anggota->nama) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Identitas (NIK/NIM)</label>
                    <input type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas', $anggota->nomor_identitas) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $anggota->email) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" name="telepon" value="{{ old('telepon', $anggota->telepon) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="aktif" {{ old('status', $anggota->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $anggota->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
