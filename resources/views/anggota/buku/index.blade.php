@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Katalog Buku</h4>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('anggota.katalog') }}" method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari judul/pengarang/penerbit...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Book Grid -->
@if($buku->count() > 0)
    <div class="row g-3 mb-3">
        @foreach($buku as $b)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100">
                    @if($b->foto_sampul)
                        <img src="{{ $b->url_foto_sampul }}" class="card-img-top" alt="{{ $b->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-book" style="font-size: 3rem; color: #dee2e6;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ \Illuminate\Support\Str::limit($b->judul, 50) }}</h6>
                        <p class="card-text small text-muted mb-2">{{ $b->pengarang }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $b->tersedia > 0 ? 'success' : 'secondary' }}">
                                {{ $b->tersedia > 0 ? 'Tersedia (' . $b->tersedia . ')' : 'Habis' }}
                            </span>
                            <a href="{{ route('anggota.katalog.show', $b) }}" class="btn btn-sm btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-3">
        {{ $buku->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <p class="mb-0">Buku tidak ditemukan</p>
        </div>
    </div>
@endif
@endsection
