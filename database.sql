-- Database SPMB
-- Sistem Penerimaan Mahasiswa Baru

CREATE DATABASE IF NOT EXISTS spmb_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE spmb_db;

-- Tabel Wilayah
CREATE TABLE wilayah (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    provinsi VARCHAR(100) NOT NULL,
    kabupaten VARCHAR(100) NOT NULL,
    kecamatan VARCHAR(100) NOT NULL,
    kelurahan VARCHAR(100) NOT NULL,
    kodepos VARCHAR(10) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_kecamatan_kelurahan (kecamatan, kelurahan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Jurusan
CREATE TABLE jurusan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kuota INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Gelombang
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

-- Tabel Pengguna
CREATE TABLE pengguna (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    hp VARCHAR(20) NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('pendaftar', 'admin', 'verifikator_adm', 'keuangan', 'kepsek') NOT NULL,
    aktif TINYINT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pendaftar
CREATE TABLE pendaftar (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    tanggal_daftar DATETIME NOT NULL,
    no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
    gelombang_id BIGINT UNSIGNED NOT NULL,
    jurusan_id BIGINT UNSIGNED NOT NULL,
    status ENUM('DRAFT', 'SUBMIT', 'ADM_PASS', 'ADM_REJECT', 'PAID', 'PAYMENT_VERIFIED', 'LULUS', 'TIDAK_LULUS', 'CADANGAN') NOT NULL DEFAULT 'DRAFT',
    user_verifikasi_adm VARCHAR(100) NULL,
    tgl_verifikasi_adm DATETIME NULL,
    user_verifikasi_payment VARCHAR(100) NULL,
    tgl_verifikasi_payment DATETIME NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_status (status),
    FOREIGN KEY (user_id) REFERENCES pengguna(id) ON DELETE CASCADE,
    FOREIGN KEY (gelombang_id) REFERENCES gelombang(id),
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pendaftar Data Siswa
CREATE TABLE pendaftar_data_siswa (
    pendaftar_id BIGINT UNSIGNED PRIMARY KEY,
    nik VARCHAR(20) NULL,
    nisn VARCHAR(20) NULL,
    nama VARCHAR(120) NOT NULL,
    jk ENUM('L', 'P') NOT NULL,
    tmp_lahir VARCHAR(60) NOT NULL,
    tgl_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    wilayah_id BIGINT UNSIGNED NULL,
    lat DECIMAL(10,7) NULL,
    lng DECIMAL(10,7) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE,
    FOREIGN KEY (wilayah_id) REFERENCES wilayah(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pendaftar Data Orang Tua
CREATE TABLE pendaftar_data_ortu (
    pendaftar_id BIGINT UNSIGNED PRIMARY KEY,
    nama_ayah VARCHAR(120) NULL,
    pekerjaan_ayah VARCHAR(100) NULL,
    hp_ayah VARCHAR(20) NULL,
    nama_ibu VARCHAR(120) NULL,
    pekerjaan_ibu VARCHAR(100) NULL,
    hp_ibu VARCHAR(20) NULL,
    wali_nama VARCHAR(120) NULL,
    wali_hp VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pendaftar Asal Sekolah
CREATE TABLE pendaftar_asal_sekolah (
    pendaftar_id BIGINT UNSIGNED PRIMARY KEY,
    npsn VARCHAR(20) NULL,
    nama_sekolah VARCHAR(150) NOT NULL,
    kabupaten VARCHAR(100) NULL,
    nilai_rata DECIMAL(5,2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pendaftar Berkas
CREATE TABLE pendaftar_berkas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    jenis ENUM('IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA') NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    ukuran_kb INT NOT NULL,
    valid TINYINT NOT NULL DEFAULT 0,
    catatan VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_pendaftar_jenis (pendaftar_id, jenis),
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pembayaran
CREATE TABLE pembayaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftar_id BIGINT UNSIGNED NOT NULL,
    nominal DECIMAL(12,2) NOT NULL,
    bukti_bayar VARCHAR(255) NULL,
    status ENUM('PENDING', 'VERIFIED', 'REJECTED') NOT NULL DEFAULT 'PENDING',
    catatan VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Audit Log
CREATE TABLE audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    aksi VARCHAR(100) NOT NULL,
    deskripsi TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES pengguna(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Data Awal Pengguna
INSERT INTO pengguna (nama, email, hp, password_hash, role, aktif, created_at, updated_at) VALUES
('Admin SPMB', 'admin@spmb.com', '081234567890', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NOW(), NOW()),
('Verifikator', 'verifikator@spmb.com', '081234567891', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'verifikator_adm', 1, NOW(), NOW()),
('Staff Keuangan', 'keuangan@spmb.com', '081234567892', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'keuangan', 1, NOW(), NOW()),
('Kepala Sekolah', 'kepsek@spmb.com', '081234567893', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek', 1, NOW(), NOW());

-- Insert Data Jurusan
INSERT INTO jurusan (kode, nama, kuota, created_at, updated_at) VALUES
('TKJ', 'Teknik Komputer dan Jaringan', 36, NOW(), NOW()),
('RPL', 'Rekayasa Perangkat Lunak', 36, NOW(), NOW()),
('MM', 'Multimedia', 36, NOW(), NOW()),
('AKL', 'Akuntansi dan Keuangan Lembaga', 36, NOW(), NOW());

-- Insert Data Gelombang
INSERT INTO gelombang (nama, tahun, tgl_mulai, tgl_selesai, biaya_daftar, created_at, updated_at) VALUES
('Gelombang 1', 2024, '2024-01-01', '2024-03-31', 250000.00, NOW(), NOW()),
('Gelombang 2', 2024, '2024-04-01', '2024-06-30', 300000.00, NOW(), NOW());

-- Insert Data Wilayah Contoh
INSERT INTO wilayah (provinsi, kabupaten, kecamatan, kelurahan, kodepos, created_at, updated_at) VALUES
('DKI Jakarta', 'Jakarta Pusat', 'Menteng', 'Menteng', '10310', NOW(), NOW()),
('DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', 'Senayan', '12190', NOW(), NOW()),
('Jawa Barat', 'Bandung', 'Bandung Wetan', 'Citarum', '40115', NOW(), NOW()),
('Jawa Timur', 'Surabaya', 'Gubeng', 'Airlangga', '60286', NOW(), NOW());

-- Catatan: Password untuk semua user adalah "password"
-- Hash: $2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
