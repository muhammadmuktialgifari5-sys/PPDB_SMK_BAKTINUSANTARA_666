-- =============================================
-- DATABASE SPMB - IMPORT KE PHPMYADMIN
-- =============================================

CREATE DATABASE IF NOT EXISTS spmb_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE spmb_db;

-- Table: migrations
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: jurusan
CREATE TABLE jurusan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    kuota INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: gelombang
CREATE TABLE gelombang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL,
    tahun INT NOT NULL,
    tgl_mulai DATE NOT NULL,
    tgl_selesai DATE NOT NULL,
    biaya_daftar DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: wilayah
CREATE TABLE wilayah (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tingkat ENUM('provinsi', 'kabupaten', 'kecamatan', 'kelurahan') NOT NULL,
    parent_kode VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_parent (parent_kode),
    INDEX idx_tingkat (tingkat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pengguna
CREATE TABLE pengguna (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    hp VARCHAR(20) NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('pendaftar', 'admin', 'verifikator_adm', 'keuangan', 'kepsek') NOT NULL,
    aktif TINYINT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pendaftar
CREATE TABLE pendaftar (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengguna_id BIGINT UNSIGNED NOT NULL,
    jurusan_id BIGINT UNSIGNED NOT NULL,
    gelombang_id BIGINT UNSIGNED NOT NULL,
    no_pendaftaran VARCHAR(50) UNIQUE NULL,
    status ENUM('DRAFT', 'SUBMIT', 'ADM_PASS', 'ADM_REJECT', 'PAID', 'PAYMENT_VERIFIED', 'LULUS', 'TIDAK_LULUS', 'CADANGAN') DEFAULT 'DRAFT',
    catatan_verifikasi TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pengguna_id) REFERENCES pengguna(id) ON DELETE CASCADE,
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id),
    FOREIGN KEY (gelombang_id) REFERENCES gelombang(id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pendaftar_data_siswa
CREATE TABLE pendaftar_data_siswa (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    nik VARCHAR(20) NULL,
    nisn VARCHAR(20) NULL,
    tempat_lahir VARCHAR(50) NULL,
    tanggal_lahir DATE NULL,
    jenis_kelamin ENUM('L', 'P') NULL,
    agama VARCHAR(20) NULL,
    alamat TEXT NULL,
    kelurahan_kode VARCHAR(20) NULL,
    rt VARCHAR(5) NULL,
    rw VARCHAR(5) NULL,
    kode_pos VARCHAR(10) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pendaftar_data_ortu
CREATE TABLE pendaftar_data_ortu (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    nama_ayah VARCHAR(100) NULL,
    pekerjaan_ayah VARCHAR(50) NULL,
    penghasilan_ayah DECIMAL(12,2) NULL,
    nama_ibu VARCHAR(100) NULL,
    pekerjaan_ibu VARCHAR(50) NULL,
    penghasilan_ibu DECIMAL(12,2) NULL,
    nama_wali VARCHAR(100) NULL,
    pekerjaan_wali VARCHAR(50) NULL,
    hp_wali VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pendaftar_asal_sekolah
CREATE TABLE pendaftar_asal_sekolah (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    npsn VARCHAR(20) NULL,
    nama_sekolah VARCHAR(100) NULL,
    alamat_sekolah TEXT NULL,
    tahun_lulus INT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pendaftar_berkas
CREATE TABLE pendaftar_berkas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    jenis_berkas ENUM('ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk') NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    path_file VARCHAR(500) NOT NULL,
    status_verifikasi ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    catatan VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE,
    INDEX idx_jenis (jenis_berkas),
    INDEX idx_status_verifikasi (status_verifikasi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pembayaran
CREATE TABLE pembayaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    jumlah DECIMAL(12,2) NOT NULL,
    tanggal_bayar DATE NULL,
    bukti_bayar VARCHAR(500) NULL,
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    catatan VARCHAR(255) NULL,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES pengguna(id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: audit_log
CREATE TABLE audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengguna_id BIGINT UNSIGNED NULL,
    aksi VARCHAR(100) NOT NULL,
    tabel VARCHAR(50) NULL,
    record_id BIGINT UNSIGNED NULL,
    data_lama TEXT NULL,
    data_baru TEXT NULL,
    ip_address VARCHAR(50) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (pengguna_id) REFERENCES pengguna(id) ON DELETE SET NULL,
    INDEX idx_aksi (aksi),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: sessions
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_user (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: jobs
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- INSERT DATA AKUN DEFAULT
-- =============================================

-- Password: password (hashed dengan bcrypt)
INSERT INTO pengguna (nama, email, hp, password_hash, role, aktif, created_at, updated_at) VALUES
('Admin SPMB', 'admin@spmb.com', '081234567890', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh2u8j/cxC', 'admin', 1, NOW(), NOW()),
('Verifikator Administrasi', 'verifikator@spmb.com', '081234567891', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh2u8j/cxC', 'verifikator_adm', 1, NOW(), NOW()),
('Staff Keuangan', 'keuangan@spmb.com', '081234567892', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh2u8j/cxC', 'keuangan', 1, NOW(), NOW()),
('Kepala Sekolah', 'kepsek@spmb.com', '081234567893', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh2u8j/cxC', 'kepsek', 1, NOW(), NOW());

-- Data Jurusan
INSERT INTO jurusan (kode, nama, kuota, created_at, updated_at) VALUES
('TKJ', 'Teknik Komputer dan Jaringan', 72, NOW(), NOW()),
('RPL', 'Rekayasa Perangkat Lunak', 72, NOW(), NOW()),
('MM', 'Multimedia', 36, NOW(), NOW()),
('AKL', 'Akuntansi dan Keuangan Lembaga', 36, NOW(), NOW()),
('OTKP', 'Otomatisasi dan Tata Kelola Perkantoran', 36, NOW(), NOW());

-- Data Gelombang
INSERT INTO gelombang (nama, tahun, tgl_mulai, tgl_selesai, biaya_daftar, created_at, updated_at) VALUES
('Gelombang 1', 2025, '2025-01-01', '2025-03-31', 200000.00, NOW(), NOW()),
('Gelombang 2', 2025, '2025-04-01', '2025-06-30', 250000.00, NOW(), NOW());

-- =============================================
-- SELESAI
-- =============================================
