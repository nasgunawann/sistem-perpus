@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="mb-4">
    <a href="{{ route('anggota.katalog') }}" class="btn btn-sm btn-secondary">&larr; Kembali ke Katalog</a>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        @if($buku->foto_sampul)
            <img src="{{ $buku->url_foto_sampul }}" class="img-fluid rounded" alt="{{ $buku->judul }}">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                <i class="bi bi-book" style="font-size: 5rem; color: #dee2e6;"></i>
            </div>
        @endif
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ $buku->judul }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Pengarang</strong></td>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <td><strong>Penerbit</strong></td>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <td><strong>ISBN</strong></td>
                        <td>{{ $buku->isbn }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Terbit</strong></td>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td><span class="badge bg-info">{{ $buku->kategori->nama }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Stok</strong></td>
                        <td>{{ $buku->stok }} buku</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @if($buku->tersedia > 0)
                                <span class="badge bg-success">Tersedia ({{ $buku->tersedia }} buku)</span>
                            @else
                                <span class="badge bg-secondary">Habis dipinjam</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> Untuk meminjam buku, silakan datang ke perpustakaan atau hubungi admin.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
