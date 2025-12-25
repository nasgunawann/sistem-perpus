@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Edit Profil</h4>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Informasi Profil</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Anggota</label>
                        <input type="text" class="form-control" value="{{ $anggota->kode_anggota }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $anggota->nama }}" disabled>
                        <small class="text-muted">Nama tidak bisa diubah, hubungi admin untuk perubahan</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $anggota->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon', $anggota->telepon) }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profil</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Ubah Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror" name="password_lama" required>
                        @error('password_lama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password_baru') is-invalid @enderror" name="password_baru" required>
                        @error('password_baru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password_baru_confirmation" required>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
