<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Untuk SQLite, kita perlu recreate table karena tidak support ALTER ENUM
        if (DB::getDriverName() === 'sqlite') {
            // Backup data
            $data = DB::table('pendaftar_berkas')->get();
            
            // Drop table
            Schema::dropIfExists('pendaftar_berkas');
            
            // Recreate with new enum values
            Schema::create('pendaftar_berkas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
                $table->enum('jenis', ['PAS_FOTO', 'IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA']);
                $table->string('nama_file', 255);
                $table->string('url', 255);
                $table->integer('ukuran_kb');
                $table->tinyInteger('valid')->default(0);
                $table->string('catatan', 255)->nullable();
                $table->timestamps();
                $table->index(['pendaftar_id', 'jenis']);
            });
            
            // Restore data
            foreach ($data as $row) {
                DB::table('pendaftar_berkas')->insert((array) $row);
            }
        } else {
            // Untuk MySQL
            DB::statement("ALTER TABLE pendaftar_berkas MODIFY COLUMN jenis ENUM('PAS_FOTO', 'IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA')");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // Backup data (exclude PAS_FOTO)
            $data = DB::table('pendaftar_berkas')->where('jenis', '!=', 'PAS_FOTO')->get();
            
            // Drop table
            Schema::dropIfExists('pendaftar_berkas');
            
            // Recreate with original enum values
            Schema::create('pendaftar_berkas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
                $table->enum('jenis', ['IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA']);
                $table->string('nama_file', 255);
                $table->string('url', 255);
                $table->integer('ukuran_kb');
                $table->tinyInteger('valid')->default(0);
                $table->string('catatan', 255)->nullable();
                $table->timestamps();
                $table->index(['pendaftar_id', 'jenis']);
            });
            
            // Restore data
            foreach ($data as $row) {
                DB::table('pendaftar_berkas')->insert((array) $row);
            }
        } else {
            DB::statement("ALTER TABLE pendaftar_berkas MODIFY COLUMN jenis ENUM('IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA')");
        }
    }
};