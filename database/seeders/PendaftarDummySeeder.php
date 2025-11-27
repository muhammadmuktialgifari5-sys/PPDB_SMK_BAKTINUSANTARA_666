<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarAsalSekolah;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Facades\Hash;

class PendaftarDummySeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = Jurusan::all();
        $gelombang = Gelombang::first();
        
        // Data dummy siswa
        $siswaData = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@siswa.com'],
            ['nama' => 'Siti Nurhaliza', 'email' => 'siti@siswa.com'],
            ['nama' => 'Ahmad Fauzi', 'email' => 'ahmad@siswa.com'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi@siswa.com'],
            ['nama' => 'Rizki Pratama', 'email' => 'rizki@siswa.com'],
        ];
        
        foreach ($siswaData as $index => $data) {
            // Cek atau buat user
            $user = Pengguna::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'hp' => '0812345678' . ($index + 10),
                    'password_hash' => Hash::make('password'),
                    'role' => 'pendaftar',
                    'aktif' => 1,
                    'email_verified_at' => now()
                ]
            );
            
            // Skip jika sudah punya pendaftaran
            if (Pendaftar::where('user_id', $user->id)->exists()) {
                continue;
            }
            
            // Buat pendaftaran
            $pendaftar = Pendaftar::create([
                'user_id' => $user->id,
                'jurusan_id' => $jurusan->random()->id,
                'gelombang_id' => $gelombang->id,
                'no_pendaftaran' => 'REG' . now()->format('Ymd') . str_pad($index + 2, 4, '0', STR_PAD_LEFT),
                'tanggal_daftar' => now(),
                'status' => ['SUBMIT', 'ADM_PASS', 'PAID'][array_rand(['SUBMIT', 'ADM_PASS', 'PAID'])]
            ]);
            
            // Buat data siswa
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => '327' . str_pad($index + 1, 13, rand(0, 9), STR_PAD_LEFT),
                'nisn' => '00' . str_pad($index + 1, 8, rand(0, 9), STR_PAD_LEFT),
                'nama' => $data['nama'],
                'jk' => ['L', 'P'][array_rand(['L', 'P'])],
                'tmp_lahir' => ['Bandung', 'Jakarta', 'Surabaya'][array_rand(['Bandung', 'Jakarta', 'Surabaya'])],
                'tgl_lahir' => now()->subYears(16)->subDays(rand(0, 365)),
                'alamat' => 'Jl. Contoh No. ' . ($index + 1) . ', Bandung',
                'kota' => 'Bandung',
                'lat' => -6.9175 + (rand(-100, 100) / 1000),
                'lng' => 107.6191 + (rand(-100, 100) / 1000)
            ]);
            
            // Buat data orang tua
            PendaftarDataOrtu::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_ayah' => 'Ayah ' . $data['nama'],
                'pekerjaan_ayah' => ['Wiraswasta', 'PNS', 'Karyawan Swasta'][array_rand(['Wiraswasta', 'PNS', 'Karyawan Swasta'])],
                'nama_ibu' => 'Ibu ' . $data['nama'],
                'pekerjaan_ibu' => ['Ibu Rumah Tangga', 'Guru', 'Karyawan'][array_rand(['Ibu Rumah Tangga', 'Guru', 'Karyawan'])]
            ]);
            
            // Buat data asal sekolah
            PendaftarAsalSekolah::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_sekolah' => 'SMP Negeri ' . ($index + 1) . ' Bandung'
            ]);
        }
    }
}
