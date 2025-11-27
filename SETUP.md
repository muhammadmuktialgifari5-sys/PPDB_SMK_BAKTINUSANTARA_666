# Setup Aplikasi SPMB

## Instalasi

1. Clone repository dan masuk ke direktori:
```bash
cd spmb-app
```

2. Install dependencies:
```bash
composer install
```

3. Copy file .env:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Konfigurasi database di file .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spmb_db
DB_USERNAME=root
DB_PASSWORD=
```

6. Buat database:
```bash
mysql -u root -p -e "CREATE DATABASE spmb_db"
```

7. Jalankan migration:
```bash
php artisan migrate
```

8. Buat storage link:
```bash
php artisan storage:link
```

9. Jalankan aplikasi:
```bash
php artisan serve
```

10. Akses aplikasi di browser: http://localhost:8000

## Fitur Aplikasi

### 1. Pendaftar/Calon Siswa
- Registrasi akun (email + password)
- Formulir pendaftaran (data siswa, orang tua, asal sekolah)
- Upload berkas (ijazah, rapor, KIP, KKS, akta, KK)
- Lihat status pendaftaran
- Upload bukti pembayaran
- Cetak kartu pendaftaran

### 2. Admin Panitia
- Dashboard operasional (statistik pendaftar)
- Master data (jurusan, gelombang, biaya)
- Monitoring berkas
- Peta sebaran pendaftar

### 3. Verifikator Administrasi
- Verifikasi data dan berkas pendaftar
- Tandai Lulus/Tolak/Perbaikan

### 4. Keuangan
- Verifikasi pembayaran
- Rekap keuangan
- Laporan pemasukan

### 5. Kepala Sekolah/Yayasan
- Dashboard eksekutif (KPI)
- Laporan lengkap

## Role Pengguna

- `pendaftar`: Calon siswa yang mendaftar
- `admin`: Admin panitia
- `verifikator_adm`: Verifikator administrasi
- `keuangan`: Staff keuangan
- `kepsek`: Kepala sekolah/yayasan

## Status Pendaftaran

1. DRAFT - Pendaftaran masih draft
2. SUBMIT - Pendaftaran sudah dikirim
3. ADM_PASS - Lolos verifikasi administrasi
4. ADM_REJECT - Ditolak verifikasi administrasi
5. PAID - Sudah upload bukti bayar
6. PAYMENT_VERIFIED - Pembayaran terverifikasi
7. LULUS - Diterima
8. TIDAK_LULUS - Tidak diterima
9. CADANGAN - Cadangan

## Database Schema

Lihat file migration di `database/migrations/` untuk detail struktur database.

## Seeding Data (Opsional)

Untuk membuat data dummy, buat seeder:
```bash
php artisan make:seeder DatabaseSeeder
```

Contoh seeder untuk admin:
```php
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

Pengguna::create([
    'nama' => 'Admin',
    'email' => 'admin@spmb.com',
    'hp' => '081234567890',
    'password_hash' => Hash::make('password'),
    'role' => 'admin',
    'aktif' => 1
]);
```

Jalankan seeder:
```bash
php artisan db:seed
```
