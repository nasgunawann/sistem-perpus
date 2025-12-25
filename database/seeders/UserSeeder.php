<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@perpus.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Anggota Users with corresponding Anggota records
        $anggotaData = [
            [
                'nama' => 'Cindy Anggriani',
                'email' => 'cindy@perpus.test',
                'nomor_identitas' => '3201012001950001',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Medan',
            ],
            [
                'nama' => 'Rizal Ritonga',
                'email' => 'rizal@perpus.test',
                'nomor_identitas' => '3201012002960002',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 456, Medan',
            ],
            [
                'nama' => 'Amira Salsabila',
                'email' => 'amira@perpus.test',
                'nomor_identitas' => '3201012003970003',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Thamrin No. 789, Medan',
            ],
        ];

        $year = date('Y');
        foreach ($anggotaData as $index => $data) {
            // Create User
            User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'anggota',
            ]);

            // Create Anggota
            Anggota::create([
                'kode_anggota' => 'AGT' . $year . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nama' => $data['nama'],
                'nomor_identitas' => $data['nomor_identitas'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'alamat' => $data['alamat'],
                'status' => 'aktif',
                'tanggal_bergabung' => now(),
            ]);
        }
    }
}
