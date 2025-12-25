@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Detail Anggota</h4>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card mb-3">
            <div class="card-header bg-white">
                <h6 class="mb-0">Informasi Anggota</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="45%">Kode Anggota</td>
                        <td><strong><code>{{ $anggota->kode_anggota }}</code></strong></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><strong>{{ $anggota->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $anggota->email }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>{{ $anggota->telepon }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Identitas</td>
                        <td>{{ $anggota->nomor_identitas }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <span class="badge bg-{{ $anggota->status === 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($anggota->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Bergabung</td>
                        <td>{{ $anggota->tanggal_bergabung->format('d/m/Y') }}</td>
                    </tr>
                </table>
                
                <div class="small text-muted mb-2"><strong>Alamat:</strong></div>
                <div class="small">{{ $anggota->alamat }}</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Statistik</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <div class="text-muted small">Total Peminjaman</div>
                    <h5 class="mb-0">{{ $totalPeminjaman }}</h5>
                </div>
                <hr>
                <div class="mb-2">
                    <div class="text-muted small">Sedang Dipinjam</div>
                    <h5 class="mb-0">{{ $sedangDipinjam }}</h5>
                </div>
                <hr>
                <div>
                    <div class="text-muted small">Denda Tertunggak</div>
                    <h5 class="mb-0 text-danger">Rp {{ number_format($dendaTotal, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">Riwayat Peminjaman</h6>
            </div>
            <div class="card-body">
                @if($riwayat->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Buku</th>
                                    <th>Pinjam</th>
                                    <th>Kembali</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $r)
                                    <tr>
                                        <td><code>{{ $r->kode_peminjaman }}</code></td>
                                        <td>{{ $r->buku->judul }}</td>
                                        <td>{{ $r->tanggal_pinjam->format('d/m/Y') }}</td>
                                        <td>{{ $r->tanggal_kembali ? $r->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $r->status === 'dikembalikan' ? 'success' : ($r->status === 'terlambat' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($r->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($r->denda)
                                                <span class="badge bg-{{ $r->denda->status === 'lunas' ? 'success' : 'danger' }}">
                                                    Rp {{ number_format($r->denda->jumlah_denda, 0, ',', '.') }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <p class="mb-0">Belum ada riwayat peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-primary">Edit Anggota</a>
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
