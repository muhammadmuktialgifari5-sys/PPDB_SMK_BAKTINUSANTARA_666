<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('jurusan')->where('kode', 'TKJ')->delete();
    }

    public function down(): void
    {
        DB::table('jurusan')->insert([
            'kode' => 'TKJ',
            'nama' => 'Teknik Komputer dan Jaringan',
            'kuota' => 36,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
};
