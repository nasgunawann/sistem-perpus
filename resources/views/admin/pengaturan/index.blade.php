@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Pengaturan Sistem</h4>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Konfigurasi Perpustakaan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label">Lama Peminjaman (Hari)</label>
                        <input type="number" class="form-control @error('lama_peminjaman') is-invalid @enderror" 
                               name="lama_peminjaman" value="{{ old('lama_peminjaman', $pengaturan['lama_peminjaman']) }}" 
                               min="1" max="30" required>
                        @error('lama_peminjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Durasi peminjaman buku (1-30 hari)</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Maksimal Pinjam Buku</label>
                        <input type="number" class="form-control @error('maks_pinjam_buku') is-invalid @enderror" 
                               name="maks_pinjam_buku" value="{{ old('maks_pinjam_buku', $pengaturan['maks_pinjam_buku']) }}" 
                               min="1" max="10" required>
                        @error('maks_pinjam_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Jumlah maksimal buku yang bisa dipinjam per anggota (1-10 buku)</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Tarif Denda (Rupiah/Hari)</label>
                        <input type="number" class="form-control @error('tarif_denda') is-invalid @enderror" 
                               name="tarif_denda" value="{{ old('tarif_denda', $pengaturan['tarif_denda']) }}" 
                               min="0" step="100" required>
                        @error('tarif_denda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Denda per hari keterlambatan (dalam Rupiah)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <small><i class="bi bi-info-circle"></i> <strong>Catatan:</strong></small><br>
                    <small>Perubahan pengaturan akan langsung berpengaruh ke transaksi selanjutnya.</small>
                </div>
                
                <h6 class="small fw-bold mb-2">Preview Perhitungan:</h6>
                <div class="small">
                    <div class="mb-2">
                        <strong>Peminjaman:</strong><br>
                        Jatuh tempo = {{ $pengaturan['lama_peminjaman'] }} hari dari tanggal pinjam
                    </div>
                    <div class="mb-2">
                        <strong>Denda:</strong><br>
                        Terlambat 1 hari = Rp {{ number_format($pengaturan['tarif_denda'], 0, ',', '.') }}<br>
                        Terlambat 5 hari = Rp {{ number_format($pengaturan['tarif_denda'] * 5, 0, ',', '.') }}
                    </div>
                    <div>
                        <strong>Limit:</strong><br>
                        Maks {{ $pengaturan['maks_pinjam_buku'] }} buku per anggota
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
