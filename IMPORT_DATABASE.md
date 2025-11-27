# Cara Import Database SPMB

## Metode 1: Menggunakan File SQL Langsung

### Via Command Line (Terminal/CMD):
```bash
# Login ke MySQL
mysql -u root -p

# Jalankan file SQL
source /Users/pplgbn666/spmb-app/database.sql

# Atau langsung dari command line
mysql -u root -p < /Users/pplgbn666/spmb-app/database.sql
```

### Via phpMyAdmin:
1. Buka phpMyAdmin di browser (http://localhost/phpmyadmin)
2. Klik tab "Import"
3. Pilih file `database.sql`
4. Klik "Go"

### Via MySQL Workbench:
1. Buka MySQL Workbench
2. File → Run SQL Script
3. Pilih file `database.sql`
4. Execute

## Metode 2: Menggunakan Laravel Migration (Recommended)

```bash
# 1. Pastikan sudah di direktori project
cd /Users/pplgbn666/spmb-app

# 2. Setup .env
cp .env.example .env

# 3. Edit .env, set database:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=spmb_db
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Generate key
php artisan key:generate

# 5. Buat database (manual via MySQL)
mysql -u root -p -e "CREATE DATABASE spmb_db"

# 6. Jalankan migration
php artisan migrate

# 7. Jalankan seeder (data awal)
php artisan db:seed

# 8. Buat storage link
php artisan storage:link

# 9. Jalankan server
php artisan serve
```

## Data Default Setelah Import

### Akun Pengguna:
| Email | Password | Role |
|-------|----------|------|
| admin@spmb.com | password | Admin |
| verifikator@spmb.com | password | Verifikator |
| keuangan@spmb.com | password | Keuangan |
| kepsek@spmb.com | password | Kepala Sekolah |

### Jurusan:
- TKJ - Teknik Komputer dan Jaringan (Kuota: 36)
- RPL - Rekayasa Perangkat Lunak (Kuota: 36)
- MM - Multimedia (Kuota: 36)
- AKL - Akuntansi dan Keuangan Lembaga (Kuota: 36)

### Gelombang:
- Gelombang 1 (2024): 01 Jan - 31 Mar, Biaya: Rp 250.000
- Gelombang 2 (2024): 01 Apr - 30 Jun, Biaya: Rp 300.000

### Wilayah (Contoh):
- DKI Jakarta - Jakarta Pusat - Menteng
- DKI Jakarta - Jakarta Selatan - Kebayoran Baru
- Jawa Barat - Bandung - Bandung Wetan
- Jawa Timur - Surabaya - Gubeng

## Struktur Database

### Tabel Utama (11 Tabel):
1. `wilayah` - Referensi wilayah Indonesia
2. `jurusan` - Master jurusan
3. `gelombang` - Master gelombang pendaftaran
4. `pengguna` - User authentication
5. `pendaftar` - Data pendaftaran utama
6. `pendaftar_data_siswa` - Data siswa lengkap
7. `pendaftar_data_ortu` - Data orang tua/wali
8. `pendaftar_asal_sekolah` - Data sekolah asal
9. `pendaftar_berkas` - Upload berkas dokumen
10. `pembayaran` - Data pembayaran
11. `audit_log` - Log aktivitas sistem

## Troubleshooting

### Error: Database already exists
```bash
# Drop database terlebih dahulu
mysql -u root -p -e "DROP DATABASE IF EXISTS spmb_db"
# Lalu import ulang
```

### Error: Access denied
```bash
# Pastikan username dan password MySQL benar
# Atau buat user baru:
mysql -u root -p
CREATE USER 'spmb_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON spmb_db.* TO 'spmb_user'@'localhost';
FLUSH PRIVILEGES;
```

### Error: Migration failed
```bash
# Reset migration
php artisan migrate:fresh --seed
```

## Verifikasi Database

```bash
# Login ke MySQL
mysql -u root -p

# Gunakan database
USE spmb_db;

# Cek tabel
SHOW TABLES;

# Cek data pengguna
SELECT * FROM pengguna;

# Cek data jurusan
SELECT * FROM jurusan;

# Cek data gelombang
SELECT * FROM gelombang;
```

## Backup Database

```bash
# Backup database
mysqldump -u root -p spmb_db > backup_spmb_$(date +%Y%m%d).sql

# Restore dari backup
mysql -u root -p spmb_db < backup_spmb_20240101.sql
```

## Rekomendasi

**Untuk Development:**
- Gunakan Laravel Migration (Metode 2)
- Lebih mudah untuk version control
- Bisa rollback jika ada masalah

**Untuk Production/Quick Setup:**
- Gunakan File SQL (Metode 1)
- Lebih cepat untuk setup awal
- Sudah include data default

Selamat menggunakan! 🚀
