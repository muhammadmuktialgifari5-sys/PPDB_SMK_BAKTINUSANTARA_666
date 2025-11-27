<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('jurusan')->truncate();
        
        DB::table('jurusan')->insert([
            ['kode' => 'PPLG', 'nama' => 'Pengembangan Perangkat Lunak dan Gim', 'gambar' => 'images/pplg.jpeg', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'ANM', 'nama' => 'Animasi', 'gambar' => 'images/animasi.jpeg', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'gambar' => 'images/dkv.jpeg', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'BDP', 'nama' => 'Broadcasting dan Perfilman', 'gambar' => 'images/bdp.jpeg', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('jurusan')->truncate();
        
        DB::table('jurusan')->insert([
            ['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'MM', 'nama' => 'Multimedia', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'AKL', 'nama' => 'Akuntansi dan Keuangan Lembaga', 'kuota' => 36, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
};
