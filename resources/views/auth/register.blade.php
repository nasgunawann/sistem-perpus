@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Daftar Anggota</h4>
            <p class="text-muted small">Sistem Perpustakaan</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div><small>{{ $error }}</small></div>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nomor Identitas</label>
                <input type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="tel" class="form-control" name="telepon" value="{{ old('telepon') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>
            
            <div class="text-center">
                <small class="text-muted">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </small>
            </div>
        </form>
    </div>
</div>

<div class="text-center mt-3">
    <a href="/" class="text-muted small text-decoration-none">← Kembali</a>
</div>
@endsection
