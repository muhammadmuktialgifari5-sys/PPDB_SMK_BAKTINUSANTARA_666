-- phpMyAdmin SQL Dump
-- Database: spmb_db
-- SMK Bakti Nusantara 666

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spmb_db`
--

CREATE DATABASE IF NOT EXISTS `spmb_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `spmb_db`;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id`, `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `kodepos`, `created_at`, `updated_at`) VALUES
(1, 'DKI Jakarta', 'Jakarta Pusat', 'Menteng', 'Menteng', '10310', NOW(), NOW()),
(2, 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', 'Senayan', '12190', NOW(), NOW()),
(3, 'Jawa Barat', 'Bandung', 'Bandung Wetan', 'Citarum', '40115', NOW(), NOW()),
(4, 'Jawa Timur', 'Surabaya', 'Gubeng', 'Airlangga', '60286', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kuota` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode`, `nama`, `kuota`, `created_at`, `updated_at`) VALUES
(1, 'TKJ', 'Teknik Komputer dan Jaringan', 36, NOW(), NOW()),
(2, 'RPL', 'Rekayasa Perangkat Lunak', 36, NOW(), NOW()),
(3, 'MM', 'Multimedia', 36, NOW(), NOW()),
(4, 'AKL', 'Akuntansi dan Keuangan Lembaga', 36, NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `gelombang`
--

CREATE TABLE `gelombang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tahun` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `biaya_daftar` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gelombang`
--

INSERT INTO `gelombang` (`id`, `nama`, `tahun`, `tgl_mulai`, `tgl_selesai`, `biaya_daftar`, `created_at`, `updated_at`) VALUES
(1, 'Gelombang 1', 2024, '2024-01-01', '2024-03-31', 250000.00, NOW(), NOW()),
(2, 'Gelombang 2', 2024, '2024-04-01', '2024-06-30', 300000.00, NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('pendaftar','admin','verifikator_adm','keuangan','kepsek') NOT NULL,
  `aktif` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `hp`, `password_hash`, `role`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Admin SPMB', 'admin@spmb.com', '081234567890', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NOW(), NOW()),
(2, 'Verifikator', 'verifikator@spmb.com', '081234567891', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'verifikator_adm', 1, NOW(), NOW()),
(3, 'Staff Keuangan', 'keuangan@spmb.com', '081234567892', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'keuangan', 1, NOW(), NOW()),
(4, 'Kepala Sekolah', 'kepsek@spmb.com', '081234567893', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek', 1, NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `no_pendaftaran` varchar(20) NOT NULL,
  `gelombang_id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('DRAFT','SUBMIT','ADM_PASS','ADM_REJECT','PAID','PAYMENT_VERIFIED','LULUS','TIDAK_LULUS','CADANGAN') NOT NULL DEFAULT 'DRAFT',
  `user_verifikasi_adm` varchar(100) DEFAULT NULL,
  `tgl_verifikasi_adm` datetime DEFAULT NULL,
  `user_verifikasi_payment` varchar(100) DEFAULT NULL,
  `tgl_verifikasi_payment` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_data_siswa`
--

CREATE TABLE `pendaftar_data_siswa` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama` varchar(120) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(60) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `wilayah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_data_ortu`
--

CREATE TABLE `pendaftar_data_ortu` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `nama_ayah` varchar(120) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `hp_ayah` varchar(20) DEFAULT NULL,
  `nama_ibu` varchar(120) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `hp_ibu` varchar(20) DEFAULT NULL,
  `wali_nama` varchar(120) DEFAULT NULL,
  `wali_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_asal_sekolah`
--

CREATE TABLE `pendaftar_asal_sekolah` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `kabupaten` varchar(100) DEFAULT NULL,
  `nilai_rata` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_berkas`
--

CREATE TABLE `pendaftar_berkas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('IJAZAH','RAPOR','KIP','KKS','AKTA','KK','LAINNYA') NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ukuran_kb` int(11) NOT NULL,
  `valid` tinyint(4) NOT NULL DEFAULT 0,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` enum('PENDING','VERIFIED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `aksi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kecamatan_kelurahan` (`kecamatan`,`kelurahan`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `gelombang`
--
ALTER TABLE `gelombang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_pendaftaran` (`no_pendaftaran`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `gelombang_id` (`gelombang_id`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indexes for table `pendaftar_data_siswa`
--
ALTER TABLE `pendaftar_data_siswa`
  ADD PRIMARY KEY (`pendaftar_id`),
  ADD KEY `wilayah_id` (`wilayah_id`);

--
-- Indexes for table `pendaftar_data_ortu`
--
ALTER TABLE `pendaftar_data_ortu`
  ADD PRIMARY KEY (`pendaftar_id`);

--
-- Indexes for table `pendaftar_asal_sekolah`
--
ALTER TABLE `pendaftar_asal_sekolah`
  ADD PRIMARY KEY (`pendaftar_id`);

--
-- Indexes for table `pendaftar_berkas`
--
ALTER TABLE `pendaftar_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pendaftar_jenis` (`pendaftar_id`,`jenis`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftar_id` (`pendaftar_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `wilayah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `gelombang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `pendaftar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `pendaftar_berkas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `audit_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftar_ibfk_2` FOREIGN KEY (`gelombang_id`) REFERENCES `gelombang` (`id`),
  ADD CONSTRAINT `pendaftar_ibfk_3` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

ALTER TABLE `pendaftar_data_siswa`
  ADD CONSTRAINT `pendaftar_data_siswa_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftar_data_siswa_ibfk_2` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`);

ALTER TABLE `pendaftar_data_ortu`
  ADD CONSTRAINT `pendaftar_data_ortu_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

ALTER TABLE `pendaftar_asal_sekolah`
  ADD CONSTRAINT `pendaftar_asal_sekolah_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

ALTER TABLE `pendaftar_berkas`
  ADD CONSTRAINT `pendaftar_berkas_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pengguna` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
