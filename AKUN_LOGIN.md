# 🔐 Daftar Akun Login SPMB

## Akun Default Sistem

### 1. Admin Panitia
```
Email    : admin@spmb.com
Password : password
Role     : admin
```
**Akses:**
- Dashboard operasional dengan statistik
- Master data (jurusan, gelombang, biaya)
- Monitoring kelengkapan berkas
- Peta sebaran pendaftar
- Laporan

---

### 2. Verifikator Administrasi
```
Email    : verifikator@spmb.com
Password : password
Role     : verifikator_adm
```
**Akses:**
- Verifikasi data pendaftar
- Verifikasi berkas dokumen
- Approve/Reject pendaftaran
- Tambah catatan verifikasi

---

### 3. Staff Keuangan
```
Email    : keuangan@spmb.com
Password : password
Role     : keuangan
```
**Akses:**
- Verifikasi bukti pembayaran
- Approve/Reject pembayaran
- Rekap laporan keuangan
- Export laporan Excel/PDF

---

### 4. Kepala Sekolah/Yayasan
```
Email    : kepsek@spmb.com
Password : password
Role     : kepsek
```
**Akses:**
- Dashboard eksekutif dengan KPI
- Laporan komprehensif
- Statistik pendaftar vs kuota
- Tren dan analisis

---

## Akun Pendaftar/Calon Siswa

**Pendaftar harus registrasi akun baru:**

1. Buka halaman: `http://localhost:8000/register`
2. Isi form registrasi:
   - Nama Lengkap
   - Email (akan jadi username)
   - No. HP
   - Password (minimal 6 karakter)
3. Klik "Daftar Sekarang"
4. Login dengan email dan password yang dibuat
5. Role otomatis: `pendaftar`

**Akses Pendaftar:**
- Isi formulir pendaftaran
- Upload berkas persyaratan
- Upload bukti pembayaran
- Tracking status pendaftaran
- Cetak kartu pendaftaran

---

## Tabel Ringkas

| Role | Email | Password | Fungsi Utama |
|------|-------|----------|--------------|
| Admin | admin@spmb.com | password | Kelola master data & monitoring |
| Verifikator | verifikator@spmb.com | password | Verifikasi administrasi |
| Keuangan | keuangan@spmb.com | password | Verifikasi pembayaran |
| Kepala Sekolah | kepsek@spmb.com | password | Dashboard eksekutif |
| Pendaftar | *registrasi sendiri* | *buat sendiri* | Daftar sebagai calon siswa |

---

## Catatan Penting

- ✅ Semua password default adalah: **password**
- ✅ Untuk testing, gunakan akun sesuai role yang ingin dicoba
- ✅ Pendaftar baru harus registrasi terlebih dahulu
- ✅ Email harus unique (tidak boleh sama)
- ✅ Password minimal 6 karakter

---

## Cara Login

1. Buka: `http://localhost:8000/login`
2. Masukkan email dan password
3. Klik tombol "Login"
4. Akan diarahkan ke dashboard sesuai role

---

## Troubleshooting

**Error: Email atau password salah**
- Pastikan email dan password benar
- Cek caps lock
- Pastikan database sudah di-import

**Error: Akun tidak ditemukan**
- Pastikan sudah menjalankan seeder: `php artisan db:seed`
- Atau import file SQL: `spmb_phpmyadmin.sql`

**Lupa Password**
- Untuk akun default, password selalu: `password`
- Untuk akun pendaftar, reset manual di database atau buat akun baru

---

Selamat menggunakan! 🎉
