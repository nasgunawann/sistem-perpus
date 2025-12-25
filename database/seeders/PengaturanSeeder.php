<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaturans = [
            [
                'kunci' => 'maks_pinjam_buku',
                'nilai' => '3',
                'deskripsi' => 'Maksimal buku yang dapat dipinjam per anggota'
            ],
            [
                'kunci' => 'durasi_pinjam_hari',
                'nilai' => '7',
                'deskripsi' => 'Durasi peminjaman dalam hari'
            ],
            [
                'kunci' => 'denda_per_hari',
                'nilai' => '1000',
                'deskripsi' => 'Denda keterlambatan per hari (Rupiah)'
            ],
            [
                'kunci' => 'nama_perpustakaan',
                'nilai' => 'Perpustakaan Digital',
                'deskripsi' => 'Nama perpustakaan'
            ],
            [
                'kunci' => 'alamat_perpustakaan',
                'nilai' => 'Jl. Contoh No. 123',
                'deskripsi' => 'Alamat perpustakaan'
            ],
        ];

        foreach ($pengaturans as $pengaturan) {
            Pengaturan::create($pengaturan);
        }
    }
}
