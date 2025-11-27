<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Aplikasi SPMB

Aplikasi SPMB (Sistem Penerimaan Mahasiswa Baru) adalah sistem informasi untuk mengelola proses penerimaan siswa baru dengan fitur lengkap:

### Fitur Utama:

**Pendaftar/Calon Siswa:**
- Registrasi akun dengan email dan password
- Formulir pendaftaran online (data siswa, orang tua, asal sekolah)
- Upload berkas persyaratan (ijazah, rapor, KIP, KKS, akta, KK)
- Tracking status pendaftaran real-time
- Upload bukti pembayaran
- Cetak kartu pendaftaran

**Admin Panitia:**
- Dashboard operasional dengan statistik lengkap
- Master data (jurusan, gelombang, biaya pendaftaran)
- Monitoring kelengkapan berkas
- Peta sebaran pendaftar berdasarkan domisili

**Verifikator Administrasi:**
- Verifikasi data dan berkas pendaftar
- Approve/reject dengan catatan

**Staff Keuangan:**
- Verifikasi bukti pembayaran
- Rekap laporan keuangan
- Export laporan Excel/PDF

**Kepala Sekolah/Yayasan:**
- Dashboard eksekutif dengan KPI
- Laporan komprehensif

### Teknologi:
- Laravel 11
- MySQL Database
- Tailwind CSS
- Leaflet Maps untuk peta sebaran

## Instalasi

1. Clone repository:
```bash
git clone <repository-url>
cd spmb-app
```

2. Install dependencies:
```bash
composer install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`:
```
DB_DATABASE=spmb_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migration dan seeder:
```bash
php artisan migrate
php artisan db:seed
```

6. Buat storage link:
```bash
php artisan storage:link
```

7. Jalankan aplikasi:
```bash
php artisan serve
```

8. Akses di browser: `http://localhost:8000`

## Akun Default

Setelah seeding, gunakan akun berikut:

- Admin: admin@spmb.com / password
- Verifikator: verifikator@spmb.com / password
- Keuangan: keuangan@spmb.com / password
- Kepala Sekolah: kepsek@spmb.com / password

## Struktur Database

### Tabel Utama:
- `pengguna` - Data user dan autentikasi
- `jurusan` - Master jurusan
- `gelombang` - Master gelombang pendaftaran
- `wilayah` - Referensi wilayah Indonesia
- `pendaftar` - Data pendaftaran
- `pendaftar_data_siswa` - Data siswa
- `pendaftar_data_ortu` - Data orang tua/wali
- `pendaftar_asal_sekolah` - Data sekolah asal
- `pendaftar_berkas` - Upload berkas
- `pembayaran` - Data pembayaran
- `audit_log` - Log aktivitas sistem

### Status Pendaftaran:
1. DRAFT - Masih draft
2. SUBMIT - Sudah dikirim
3. ADM_PASS - Lolos verifikasi administrasi
4. ADM_REJECT - Ditolak administrasi
5. PAID - Sudah upload bukti bayar
6. PAYMENT_VERIFIED - Pembayaran terverifikasi
7. LULUS - Diterima
8. TIDAK_LULUS - Tidak diterima
9. CADANGAN - Cadangan

## Dokumentasi Lengkap

Lihat file-file berikut untuk dokumentasi lengkap:

- `SETUP.md` - Instalasi detail, konfigurasi, dan troubleshooting
- `ROLES.md` - Dokumentasi lengkap tentang role dan permission
- `ROLE_VERIFICATION.md` - Verifikasi konsistensi role di seluruh aplikasi

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
