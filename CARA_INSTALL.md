# 🚀 CARA INSTALL DATABASE SPMB

## Langkah 1: Start MySQL

### Buka XAMPP Manager:
1. Buka folder **Applications**
2. Double click **XAMPP**
3. Klik tombol **Start** pada MySQL
4. Tunggu sampai status "Running" (hijau)

## Langkah 2: Import Database

### Via phpMyAdmin (MUDAH):
1. Buka browser: `http://localhost/phpmyadmin`
2. Klik tab **"Import"**
3. Klik **"Choose File"**
4. Pilih file: `spmb_database.sql` (ada di folder spmb-app)
5. Klik **"Import"** (tunggu sampai selesai)
6. ✅ Database `spmb_db` akan muncul di sidebar kiri

### Via Terminal (ALTERNATIF):
```bash
cd /Users/pplgbn666/spmb-app
/Applications/XAMPP/xamppfiles/bin/mysql -u root < spmb_database.sql
```

## Langkah 3: Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: `http://localhost:8000/login`

## Akun Login Default

| Email | Password | Role |
|-------|----------|------|
| admin@spmb.com | password | Admin |
| verifikator@spmb.com | password | Verifikator |
| keuangan@spmb.com | password | Keuangan |
| kepsek@spmb.com | password | Kepala Sekolah |

## Troubleshooting

### Error: Connection refused
❌ MySQL belum running
✅ Buka XAMPP Manager → Start MySQL

### Error: Database tidak muncul
❌ Import belum berhasil
✅ Ulangi import via phpMyAdmin

### Error: Akun tidak bisa login
❌ Data belum ter-import
✅ Cek di phpMyAdmin apakah tabel `pengguna` ada isinya

---

**File yang dibutuhkan:**
- ✅ `spmb_database.sql` (sudah dibuat)
- ✅ `.env` (sudah dikonfigurasi)

**Selamat mencoba! 🎉**
