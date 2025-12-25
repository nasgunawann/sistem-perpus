<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Fiksi', 'kode' => 'FIK', 'deskripsi' => 'Buku-buku fiksi dan novel'],
            ['nama' => 'Non-Fiksi', 'kode' => 'NON', 'deskripsi' => 'Buku-buku non-fiksi'],
            ['nama' => 'Ilmu Pengetahuan', 'kode' => 'IPA', 'deskripsi' => 'Buku sains dan ilmu pengetahuan'],
            ['nama' => 'Teknologi', 'kode' => 'TEK', 'deskripsi' => 'Buku teknologi dan komputer'],
            ['nama' => 'Sejarah', 'kode' => 'SEJ', 'deskripsi' => 'Buku sejarah dan biografi'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
