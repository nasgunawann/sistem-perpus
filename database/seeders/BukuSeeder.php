<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::all();

        $bukuData = [
            'Fiksi' => [
                ['judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'isbn' => '9789793062792', 'tahun_terbit' => 2005],
                ['judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'isbn' => '9789799731234', 'tahun_terbit' => 1980],
                ['judul' => 'Ronggeng Dukuh Paruk', 'pengarang' => 'Ahmad Tohari', 'penerbit' => 'Gramedia', 'isbn' => '9789792202991', 'tahun_terbit' => 1982],
                ['judul' => 'Perahu Kertas', 'pengarang' => 'Dee Lestari', 'penerbit' => 'Bentang Pustaka', 'isbn' => '9786029189445', 'tahun_terbit' => 2009],
                ['judul' => 'Negeri 5 Menara', 'pengarang' => 'Ahmad Fuadi', 'penerbit' => 'Gramedia', 'isbn' => '9789792248074', 'tahun_terbit' => 2009],
            ],
            'Non-Fiksi' => [
                ['judul' => 'Indonesia Mengajar', 'pengarang' => 'Anies Baswedan', 'penerbit' => 'Bentang Pustaka', 'isbn' => '9786028811965', 'tahun_terbit' => 2012],
                ['judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'isbn' => '9786024246945', 'tahun_terbit' => 2018],
                ['judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Gramedia', 'isbn' => '9786020633176', 'tahun_terbit' => 2019],
                ['judul' => 'Sejarah Indonesia Modern', 'pengarang' => 'M.C. Ricklefs', 'penerbit' => 'Serambi', 'isbn' => '9789792270792', 'tahun_terbit' => 2008],
                ['judul' => 'Indonesia, Etc', 'pengarang' => 'Elizabeth Pisani', 'penerbit' => 'Gramedia', 'isbn' => '9786020318066', 'tahun_terbit' => 2014],
            ],
            'Ilmu Pengetahuan' => [
                ['judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'isbn' => '9786024810115', 'tahun_terbit' => 2017],
                ['judul' => 'Brief History of Time', 'pengarang' => 'Stephen Hawking', 'penerbit' => 'Gramedia', 'isbn' => '9789792296266', 'tahun_terbit' => 2010],
                ['judul' => 'Cosmos', 'pengarang' => 'Carl Sagan', 'penerbit' => 'Mizan', 'isbn' => '9786022914938', 'tahun_terbit' => 2015],
                ['judul' => 'The Origin of Species', 'pengarang' => 'Charles Darwin', 'penerbit' => 'Bentang Pustaka', 'isbn' => '9786028811293', 'tahun_terbit' => 2013],
                ['judul' => 'Pengantar Fisika Kuantum', 'pengarang' => 'Yohanes Surya', 'penerbit' => 'Erlangga', 'isbn' => '9789790334465', 'tahun_terbit' => 2016],
            ],
            'Teknologi' => [
                ['judul' => 'Pemrograman Python', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'isbn' => '9786025522345', 'tahun_terbit' => 2020],
                ['judul' => 'Artificial Intelligence', 'pengarang' => 'Stuart Russell', 'penerbit' => 'Andi', 'isbn' => '9789792958867', 'tahun_terbit' => 2019],
                ['judul' => 'Machine Learning Praktis', 'pengarang' => 'Andri Kristanto', 'penerbit' => 'Elex Media', 'isbn' => '9786230011234', 'tahun_terbit' => 2021],
                ['judul' => 'Blockchain Revolution', 'pengarang' => 'Don Tapscott', 'penerbit' => 'Bentang Pustaka', 'isbn' => '9786028811874', 'tahun_terbit' => 2018],
                ['judul' => 'Internet of Things', 'pengarang' => 'Samuel Greengard', 'penerbit' => 'Informatika', 'isbn' => '9786025522567', 'tahun_terbit' => 2020],
            ],
            'Sejarah' => [
                ['judul' => 'Jejak-jejak Peradaban', 'pengarang' => 'Taufik Abdullah', 'penerbit' => 'Gramedia', 'isbn' => '9789792289879', 'tahun_terbit' => 2011],
                ['judul' => 'Sejarah Perang Dunia II', 'pengarang' => 'Antony Beevor', 'penerbit' => 'Mizan', 'isbn' => '9786022914567', 'tahun_terbit' => 2016],
                ['judul' => '1945: Proklamasi Kemerdekaan', 'pengarang' => 'Nugroho Notosusanto', 'penerbit' => 'Balai Pustaka', 'isbn' => '9789794074565', 'tahun_terbit' => 2005],
                ['judul' => 'Kerajaan Majapahit', 'pengarang' => 'Slamet Mulyana', 'penerbit' => 'Kompas', 'isbn' => '9789797095234', 'tahun_terbit' => 2009],
                ['judul' => 'Revolusi Industri 4.0', 'pengarang' => 'Klaus Schwab', 'penerbit' => 'Gramedia', 'isbn' => '9786020486772', 'tahun_terbit' => 2019],
            ],
        ];

        foreach ($kategori as $kat) {
            if (isset($bukuData[$kat->nama])) {
                foreach ($bukuData[$kat->nama] as $buku) {
                    Buku::create([
                        'kategori_id' => $kat->id,
                        'judul' => $buku['judul'],
                        'pengarang' => $buku['pengarang'],
                        'penerbit' => $buku['penerbit'],
                        'isbn' => $buku['isbn'],
                        'tahun_terbit' => $buku['tahun_terbit'],
                        'stok' => rand(3, 8),
                        'tersedia' => rand(2, 7),
                        'status' => 'tersedia',
                    ]);
                }
            }
        }
    }
}
