@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Login</h4>
            <p class="text-muted small">Sistem Perpustakaan</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
            
            <div class="text-center">
                <small class="text-muted">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </small>
            </div>
        </form>
    </div>
</div>

<div class="text-center mt-3">
    <a href="/" class="text-muted small text-decoration-none">← Kembali</a>
</div>
@endsection
