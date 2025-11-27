# Daftar Fitur Aplikasi SPMB

## 1. Pendaftar/Calon Siswa

### ✅ Registrasi Akun
- Buat akun dengan email dan password
- Validasi email unique
- Password di-hash dengan bcrypt
- Auto-set role sebagai 'pendaftar'
- Status aktif otomatis

### ✅ Formulir Pendaftaran
- Form lengkap: identitas siswa, data orang tua/wali, asal sekolah
- Pilihan jurusan dan gelombang
- Alamat domisili (koordinat lat/lng opsional)
- Fitur simpan draft atau langsung submit
- Generate nomor pendaftaran otomatis (REG+YYYYMMDD+0001)

### ✅ Upload Berkas
- Upload multiple berkas: IJAZAH, RAPOR, KIP, KKS, AKTA, KK, LAINNYA
- Format: PDF/JPG/JPEG/PNG
- Ukuran maksimal: 2MB per file
- Tracking status validasi berkas
- Catatan dari verifikator

### ✅ Status Pendaftaran
- Timeline status lengkap:
  - DRAFT → SUBMIT → ADM_PASS/ADM_REJECT → PAID → PAYMENT_VERIFIED → LULUS/TIDAK_LULUS/CADANGAN
- Real-time tracking status
- Informasi verifikator dan tanggal verifikasi

### ✅ Pembayaran
- Tampilan nominal biaya sesuai gelombang
- Upload bukti pembayaran
- Status pembayaran: PENDING, VERIFIED, REJECTED
- Catatan dari staff keuangan

### ✅ Cetak Kartu/Resume
- Cetak kartu pendaftaran (PDF-ready)
- Cetak bukti pembayaran
- Format print-friendly

## 2. Admin Panitia

### ✅ Dashboard Operasional
- Statistik real-time:
  - Total pendaftar
  - Terverifikasi
  - Terbayar
  - Lulus
- Breakdown per jurusan
- Breakdown per gelombang
- Grafik dan tabel ringkas

### ✅ Master Data
- Kelola Jurusan (kode, nama, kuota)
- Kelola Gelombang (nama, tahun, periode, biaya)
- Validasi data unique
- Audit log setiap perubahan

### ✅ Monitoring Berkas
- Lihat daftar pendaftar
- Kelengkapan berkas per pendaftar
- Filter dan sort
- Export data (siap dikembangkan)

### ✅ Peta Sebaran
- Peta interaktif menggunakan Leaflet
- Marker lokasi domisili pendaftar
- Info popup: nama dan jurusan
- Agregasi per wilayah

## 3. Verifikator Administrasi

### ✅ Verifikasi Administrasi
- List pendaftar yang perlu diverifikasi
- Cek data dan berkas lengkap
- Approve (ADM_PASS) atau Reject (ADM_REJECT)
- Tambah catatan verifikasi
- Log verifikator dan timestamp

### ✅ Verifikasi Berkas
- Validasi setiap berkas
- Tandai valid/tidak valid
- Berikan catatan perbaikan
- Tracking history verifikasi

## 4. Keuangan

### ✅ Verifikasi Pembayaran
- List pembayaran pending
- Lihat bukti pembayaran
- Approve (VERIFIED) atau Reject (REJECTED)
- Tambah catatan/alasan
- Update status pendaftar otomatis

### ✅ Rekap Keuangan
- Laporan pemasukan per gelombang
- Laporan per jurusan
- Laporan per periode
- Total pemasukan
- Export Excel/PDF (siap dikembangkan)

## 5. Kepala Sekolah/Yayasan

### ✅ Dashboard Eksekutif
- KPI ringkas:
  - Pendaftar vs kuota
  - Rasio terverifikasi
  - Tren harian
- Komposisi per jurusan
- Komposisi per gelombang
- Grafik dan indikator visual

## 6. Semua Peran

### ✅ Laporan (PDF/Excel)
- Export data pendaftar
- Filter per jurusan/gelombang/periode
- Filter per status
- Format Excel dan PDF (siap dikembangkan)

## 7. Sistem (Otomatis)

### ✅ Notifikasi
- Email/WhatsApp/SMS (siap dikembangkan):
  - Aktivasi akun
  - Permintaan perbaikan berkas
  - Instruksi pembayaran
  - Hasil verifikasi
- Log notifikasi terkirim

### ✅ Audit Log
- Mencatat semua aksi penting:
  - Siapa (user_id)
  - Kapan (timestamp)
  - Apa (aksi dan deskripsi)
  - Dari mana (IP address)
- Jejak audit lengkap untuk compliance

## Fitur Keamanan

- ✅ Authentication dengan Laravel Auth
- ✅ Role-based Access Control (RBAC)
- ✅ Password hashing dengan bcrypt
- ✅ CSRF Protection
- ✅ SQL Injection prevention (Eloquent ORM)
- ✅ File upload validation
- ✅ Audit logging

## Teknologi

- Laravel 11
- MySQL Database
- Tailwind CSS
- Leaflet Maps
- Laravel Eloquent ORM
- Blade Templating

## Status Implementasi

✅ = Sudah diimplementasi
🔄 = Dalam pengembangan
📋 = Belum diimplementasi

Semua fitur utama sudah diimplementasi dan siap digunakan!
