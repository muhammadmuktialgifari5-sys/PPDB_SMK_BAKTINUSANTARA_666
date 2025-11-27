<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users for each role
        Pengguna::create([
            'nama' => 'Admin SPMB',
            'email' => 'admin@spmb.com',
            'hp' => '081234567890',
            'password_hash' => Hash::make('password'),
            'role' => 'admin',
            'aktif' => 1
        ]);

        Pengguna::create([
            'nama' => 'Verifikator',
            'email' => 'verifikator@spmb.com',
            'hp' => '081234567891',
            'password_hash' => Hash::make('password'),
            'role' => 'verifikator_adm',
            'aktif' => 1
        ]);

        Pengguna::create([
            'nama' => 'Staff Keuangan',
            'email' => 'keuangan@spmb.com',
            'hp' => '081234567892',
            'password_hash' => Hash::make('password'),
            'role' => 'keuangan',
            'aktif' => 1
        ]);

        Pengguna::create([
            'nama' => 'Kepala Sekolah',
            'email' => 'kepsek@spmb.com',
            'hp' => '081234567893',
            'password_hash' => Hash::make('password'),
            'role' => 'kepsek',
            'aktif' => 1
        ]);

        // Create sample jurusan
        Jurusan::create(['kode' => 'PPLG', 'nama' => 'Pengembangan Perangkat Lunak dan Gim', 'gambar' => 'images/pplg.jpeg', 'kuota' => 36]);
        Jurusan::create(['kode' => 'ANM', 'nama' => 'Animasi', 'gambar' => 'images/animasi.jpeg', 'kuota' => 36]);
        Jurusan::create(['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'gambar' => 'images/dkv.jpeg', 'kuota' => 36]);
        Jurusan::create(['kode' => 'BDP', 'nama' => 'Broadcasting dan Perfilman', 'gambar' => 'images/bdp.jpeg', 'kuota' => 36]);

        // Create sample gelombang
        Gelombang::create([
            'nama' => 'Gelombang 1',
            'tahun' => 2024,
            'tgl_mulai' => '2024-01-01',
            'tgl_selesai' => '2024-03-31',
            'biaya_daftar' => 250000
        ]);

        Gelombang::create([
            'nama' => 'Gelombang 2',
            'tahun' => 2024,
            'tgl_mulai' => '2024-04-01',
            'tgl_selesai' => '2024-06-30',
            'biaya_daftar' => 300000
        ]);
    }
}
