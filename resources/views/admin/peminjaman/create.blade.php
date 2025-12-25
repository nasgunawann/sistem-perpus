@extends('layouts.app')

@section('title', 'Proses Peminjaman')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Proses Peminjaman Buku</h4>
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
        
        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Anggota</label>
                    <select class="form-select" name="anggota_id" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggota as $a)
                            <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->kode_anggota }} - {{ $a->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hanya anggota aktif</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Buku</label>
                    <select class="form-select" name="buku_id" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->judul }} ({{ $b->pengarang }}) - Tersedia: {{ $b->tersedia }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hanya buku yang tersedia</small>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea class="form-control" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                </div>
            </div>
            
            <div class="alert alert-info">
                <small><i class="bi bi-info-circle"></i> <strong>Info Otomatis:</strong></small><br>
                <small>• Tanggal pinjam: Hari ini ({{ now()->format('d/m/Y') }})</small><br>
                <small>• Jatuh tempo: +{{ $lamaPinjam }} hari ({{ now()->addDays($lamaPinjam)->format('d/m/Y') }})</small><br>
                <small>• Kode peminjaman akan di-generate otomatis</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Proses Peminjaman</button>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
