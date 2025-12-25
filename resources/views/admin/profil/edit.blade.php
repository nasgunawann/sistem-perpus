@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Profil Admin</h4>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Profil</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               name="nama" value="{{ old('nama', $admin->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email', $admin->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($admin->role) }}" disabled>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profil</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Ubah Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror" 
                               name="password_lama" required>
                        @error('password_lama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password_baru') is-invalid @enderror" 
                               name="password_baru" required>
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
