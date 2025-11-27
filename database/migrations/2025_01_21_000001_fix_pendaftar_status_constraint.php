<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite tidak support ALTER COLUMN, jadi kita harus recreate table
        DB::statement('PRAGMA foreign_keys=OFF');
        
        // Rename old table
        DB::statement('ALTER TABLE pendaftar RENAME TO pendaftar_old');
        
        // Create new table with updated constraint
        DB::statement('
            CREATE TABLE pendaftar (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                tanggal_daftar DATETIME NOT NULL,
                no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
                gelombang_id INTEGER NOT NULL,
                jurusan_id INTEGER NOT NULL,
                status VARCHAR(50) CHECK(status IN (
                    "DRAFT", "SUBMIT", "ADM_PASS", "ADM_REJECT", 
                    "PAID", "PAYMENT_VERIFIED", "LULUS", "TIDAK_LULUS", "CADANGAN"
                )) DEFAULT "SUBMIT",
                user_verifikasi_adm VARCHAR(100),
                tgl_verifikasi_adm DATETIME,
                catatan_verifikasi_adm TEXT,
                user_verifikasi_payment VARCHAR(100),
                tgl_verifikasi_payment DATETIME,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (user_id) REFERENCES pengguna(id) ON DELETE CASCADE,
                FOREIGN KEY (gelombang_id) REFERENCES gelombang(id),
                FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
            )
        ');
        
        // Copy data, mapping old status to new status
        DB::statement('
            INSERT INTO pendaftar SELECT 
                id, user_id, tanggal_daftar, no_pendaftaran, gelombang_id, jurusan_id,
                CASE 
                    WHEN status = "BERKAS_VALID" THEN "ADM_PASS"
                    WHEN status = "LUNAS" THEN "PAID"
                    ELSE status
                END as status,
                user_verifikasi_adm, tgl_verifikasi_adm, catatan_verifikasi_adm,
                user_verifikasi_payment, tgl_verifikasi_payment,
                created_at, updated_at
            FROM pendaftar_old
        ');
        
        // Drop old table
        DB::statement('DROP TABLE pendaftar_old');
        
        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        // Reverse migration
        DB::statement('PRAGMA foreign_keys=OFF');
        
        DB::statement('ALTER TABLE pendaftar RENAME TO pendaftar_new');
        
        DB::statement('
            CREATE TABLE pendaftar (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                tanggal_daftar DATETIME NOT NULL,
                no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
                gelombang_id INTEGER NOT NULL,
                jurusan_id INTEGER NOT NULL,
                status VARCHAR(50) CHECK(status IN ("SUBMIT", "BERKAS_VALID", "LUNAS", "LULUS", "TIDAK_LULUS")) DEFAULT "SUBMIT",
                user_verifikasi_adm VARCHAR(100),
                tgl_verifikasi_adm DATETIME,
                catatan_verifikasi_adm TEXT,
                user_verifikasi_payment VARCHAR(100),
                tgl_verifikasi_payment DATETIME,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (user_id) REFERENCES pengguna(id) ON DELETE CASCADE,
                FOREIGN KEY (gelombang_id) REFERENCES gelombang(id),
                FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
            )
        ');
        
        DB::statement('
            INSERT INTO pendaftar SELECT 
                id, user_id, tanggal_daftar, no_pendaftaran, gelombang_id, jurusan_id,
                CASE 
                    WHEN status = "ADM_PASS" THEN "BERKAS_VALID"
                    WHEN status = "PAID" THEN "LUNAS"
                    ELSE status
                END as status,
                user_verifikasi_adm, tgl_verifikasi_adm, catatan_verifikasi_adm,
                user_verifikasi_payment, tgl_verifikasi_payment,
                created_at, updated_at
            FROM pendaftar_new
        ');
        
        DB::statement('DROP TABLE pendaftar_new');
        
        DB::statement('PRAGMA foreign_keys=ON');
    }
};
