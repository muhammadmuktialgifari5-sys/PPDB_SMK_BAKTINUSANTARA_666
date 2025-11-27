<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // SQLite doesn't support ALTER COLUMN, so we need to recreate the table
        DB::statement("
            CREATE TABLE pendaftar_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                tanggal_daftar DATETIME NOT NULL,
                no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
                gelombang_id INTEGER NOT NULL,
                jurusan_id INTEGER NOT NULL,
                status VARCHAR(50) CHECK(status IN ('SUBMIT', 'BERKAS_VALID', 'LUNAS', 'LULUS', 'TIDAK_LULUS')) DEFAULT 'SUBMIT',
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
        ");

        // Copy data from old table to new table, mapping old statuses to new ones
        DB::statement("
            INSERT INTO pendaftar_new 
            SELECT 
                id, user_id, tanggal_daftar, no_pendaftaran, gelombang_id, jurusan_id,
                CASE 
                    WHEN status IN ('DRAFT', 'SUBMIT') THEN 'SUBMIT'
                    WHEN status IN ('ADM_PASS', 'PAID') THEN 'BERKAS_VALID'
                    WHEN status = 'PAYMENT_VERIFIED' THEN 'LUNAS'
                    WHEN status = 'LULUS' THEN 'LULUS'
                    WHEN status IN ('ADM_REJECT', 'TIDAK_LULUS', 'CADANGAN') THEN 'TIDAK_LULUS'
                    ELSE 'SUBMIT'
                END as status,
                user_verifikasi_adm, tgl_verifikasi_adm, NULL as catatan_verifikasi_adm, user_verifikasi_payment, tgl_verifikasi_payment,
                created_at, updated_at
            FROM pendaftar
        ");

        // Drop old table
        DB::statement("DROP TABLE pendaftar");

        // Rename new table
        DB::statement("ALTER TABLE pendaftar_new RENAME TO pendaftar");

        // Recreate index
        DB::statement("CREATE INDEX pendaftar_status_index ON pendaftar(status)");
    }

    public function down()
    {
        // Reverse migration
        DB::statement("
            CREATE TABLE pendaftar_old (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                tanggal_daftar DATETIME NOT NULL,
                no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
                gelombang_id INTEGER NOT NULL,
                jurusan_id INTEGER NOT NULL,
                status VARCHAR(50) CHECK(status IN ('DRAFT', 'SUBMIT', 'ADM_PASS', 'ADM_REJECT', 'PAID', 'PAYMENT_VERIFIED', 'LULUS', 'TIDAK_LULUS', 'CADANGAN')) DEFAULT 'DRAFT',
                user_verifikasi_adm VARCHAR(100),
                tgl_verifikasi_adm DATETIME,
                user_verifikasi_payment VARCHAR(100),
                tgl_verifikasi_payment DATETIME,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (user_id) REFERENCES pengguna(id) ON DELETE CASCADE,
                FOREIGN KEY (gelombang_id) REFERENCES gelombang(id),
                FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
            )
        ");

        DB::statement("
            INSERT INTO pendaftar_old 
            SELECT * FROM pendaftar
        ");

        DB::statement("DROP TABLE pendaftar");
        DB::statement("ALTER TABLE pendaftar_old RENAME TO pendaftar");
        DB::statement("CREATE INDEX pendaftar_status_index ON pendaftar(status)");
    }
};
