<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarAsalSekolah;
use Illuminate\Support\Facades\Hash;

class PetaSeeder extends Seeder
{
    public function run(): void
    {
        // Data dummy dengan koordinat Jakarta dan sekitarnya
        $dummyData = [
            ['nama' => 'Ahmad Rizki', 'lat' => -6.2088, 'lng' => 106.8456, 'jurusan_id' => 1, 'alamat' => 'Jakarta Pusat'],
            ['nama' => 'Siti Nurhaliza', 'lat' => -6.1751, 'lng' => 106.8650, 'jurusan_id' => 2, 'alamat' => 'Jakarta Utara'],
            ['nama' => 'Budi Santoso', 'lat' => -6.2615, 'lng' => 106.7810, 'jurusan_id' => 3, 'alamat' => 'Jakarta Barat'],
            ['nama' => 'Dewi Sartika', 'lat' => -6.2297, 'lng' => 106.9756, 'jurusan_id' => 4, 'alamat' => 'Jakarta Timur'],
            ['nama' => 'Andi Wijaya', 'lat' => -6.3402, 'lng' => 106.8317, 'jurusan_id' => 1, 'alamat' => 'Jakarta Selatan'],
            ['nama' => 'Maya Sari', 'lat' => -6.5971, 'lng' => 106.8060, 'jurusan_id' => 2, 'alamat' => 'Depok'],
            ['nama' => 'Rudi Hartono', 'lat' => -6.4025, 'lng' => 106.7942, 'jurusan_id' => 3, 'alamat' => 'Tangerang'],
            ['nama' => 'Lina Marlina', 'lat' => -6.2441, 'lng' => 107.0030, 'jurusan_id' => 4, 'alamat' => 'Bekasi'],
        ];

        foreach ($dummyData as $index => $data) {
            // Buat user
            $user = Pengguna::create([
                'nama' => $data['nama'],
                'email' => 'peta' . time() . ($index + 1) . '@test.com',
                'hp' => '0812345678' . ($index + 100),
                'password_hash' => Hash::make('password'),
                'role' => 'pendaftar',
                'aktif' => 1
            ]);

            // Buat pendaftar
            $pendaftar = Pendaftar::create([
                'user_id' => $user->id,
                'tanggal_daftar' => now(),
                'no_pendaftaran' => 'PETA' . time() . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'gelombang_id' => rand(1, 2),
                'jurusan_id' => $data['jurusan_id'],
                'status' => ['SUBMIT', 'ADM_PASS', 'PAID'][rand(0, 2)]
            ]);

            // Buat data siswa dengan koordinat
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => '3171' . str_pad($index + 1, 12, '0', STR_PAD_LEFT),
                'nisn' => '0012345' . ($index + 1),
                'nama' => $data['nama'],
                'jk' => rand(0, 1) ? 'L' : 'P',
                'tmp_lahir' => 'Jakarta',
                'tgl_lahir' => '2006-01-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'alamat' => $data['alamat'],
                'lat' => $data['lat'],
                'lng' => $data['lng']
            ]);

            // Buat data orang tua
            PendaftarDataOrtu::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_ayah' => 'Ayah ' . $data['nama'],
                'pekerjaan_ayah' => 'Wiraswasta',
                'nama_ibu' => 'Ibu ' . $data['nama'],
                'pekerjaan_ibu' => 'Ibu Rumah Tangga'
            ]);

            // Buat data asal sekolah
            PendaftarAsalSekolah::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_sekolah' => 'SMP Negeri ' . ($index + 1),
                'kabupaten' => 'Jakarta'
            ]);
        }
    }
}