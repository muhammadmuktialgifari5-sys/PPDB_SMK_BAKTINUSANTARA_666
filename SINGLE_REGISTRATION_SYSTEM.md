# Sistem Pendaftaran Tunggal (Single Registration System)

## Deskripsi
Sistem ini memastikan bahwa setiap siswa hanya dapat melakukan pendaftaran **1 kali saja**. Setelah siswa membuat pendaftaran, mereka tidak dapat membuat pendaftaran baru lagi.

## Fitur yang Ditambahkan

### 1. Database Constraint
- **File**: `database/migrations/2025_01_20_000001_add_unique_user_constraint_to_pendaftar_table.php`
- **Fungsi**: Menambahkan UNIQUE constraint pada kolom `user_id` di tabel `pendaftar`
- **Manfaat**: Mencegah duplikasi di level database

### 2. Model Validation
- **File**: `app/Models/Pendaftar.php`
- **Method**: `boot()` dengan event `creating`
- **Fungsi**: Validasi di level model sebelum menyimpan data
- **Helper Methods**:
  - `userHasRegistration($userId)` - Cek apakah user sudah punya pendaftaran
  - `getUserRegistration($userId)` - Ambil data pendaftaran user

### 3. Controller Protection
- **File**: `app/Http/Controllers/PendaftaranController.php`
- **Method**: `create()` dan `store()`
- **Fungsi**: Cek dan redirect jika user sudah punya pendaftaran

### 4. Middleware Protection
- **File**: `app/Http/Middleware/CheckExistingRegistration.php`
- **Fungsi**: Middleware untuk mengecek dan redirect user yang sudah punya pendaftaran
- **Route**: Diterapkan pada route `pendaftaran.create` dan `pendaftaran.store`

### 5. UI/UX Improvements
- **File**: `resources/views/dashboard/pendaftar.blade.php`
- **Perubahan**:
  - Menyembunyikan tombol "Buat Pendaftaran Baru" jika sudah ada pendaftaran
  - Menampilkan informasi bahwa setiap siswa hanya bisa daftar 1 kali
  - Menampilkan pesan informatif

### 6. Data Cleanup Commands
- **File**: `app/Console/Commands/CleanDuplicatePendaftar.php`
- **Command**: `php artisan clean:duplicate-pendaftar`
- **Fungsi**: Membersihkan data duplikat yang sudah ada
- **Logic**: Mempertahankan pendaftaran dengan status terbaik atau yang terbaru

## Cara Kerja Sistem

### 1. Saat User Mengakses Form Pendaftaran
```
User → Route → Middleware CheckExistingRegistration → Controller
                    ↓
            Cek apakah sudah punya pendaftaran
                    ↓
        Jika YA: Redirect ke detail pendaftaran
        Jika TIDAK: Lanjut ke form pendaftaran
```

### 2. Saat User Submit Form Pendaftaran
```
User → Controller → Cek duplikasi → Model Validation → Database Constraint
                         ↓               ↓                    ↓
                   Jika duplikat:   Event creating:    UNIQUE constraint:
                   Return error     Throw exception    SQL error jika duplikat
```

### 3. Dashboard Pendaftar
```
User Login → Dashboard → Cek jumlah pendaftaran
                              ↓
                    Jika 0: Tampilkan tombol "Buat Pendaftaran"
                    Jika 1: Tampilkan info + tombol "Lihat Detail"
```

## Pesan Error/Info

### 1. Jika User Sudah Punya Pendaftaran
- **Pesan**: "Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali."
- **Action**: Redirect ke halaman detail pendaftaran

### 2. Di Dashboard
- **Info**: "Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali saja."
- **Instruksi**: "Silakan kelola pendaftaran Anda yang sudah ada di bawah ini."

## Command untuk Maintenance

### 1. Cek Data Duplikat
```bash
php artisan clean:duplicate-pendaftar
```

### 2. Fix Status Pembayaran
```bash
php artisan fix:payment-status
```

### 3. Cek Status Migration
```bash
php artisan migrate:status
```

## Testing

### 1. Test Constraint Database
```php
// Di tinker
$existingUser = Pendaftar::first();
$duplicate = new Pendaftar([
    'user_id' => $existingUser->user_id,
    // ... data lainnya
]);
$duplicate->save(); // Akan error dengan UNIQUE constraint violation
```

### 2. Test Helper Methods
```php
// Di tinker
Pendaftar::userHasRegistration($userId); // true/false
Pendaftar::getUserRegistration($userId); // object/null
```

## Keamanan

1. **Database Level**: UNIQUE constraint mencegah duplikasi di level SQL
2. **Model Level**: Event `creating` mencegah duplikasi di level aplikasi
3. **Controller Level**: Validasi manual di controller
4. **Middleware Level**: Proteksi di level HTTP request
5. **UI Level**: Menyembunyikan akses ke form pendaftaran

## Rollback (Jika Diperlukan)

Jika perlu mengembalikan sistem ke kondisi sebelumnya:

1. **Hapus Constraint Database**:
```bash
php artisan migrate:rollback --step=1
```

2. **Hapus Middleware dari Route**:
```php
// Di routes/web.php, hapus ->middleware('check.registration')
```

3. **Hapus Event dari Model**:
```php
// Di app/Models/Pendaftar.php, hapus method boot()
```

4. **Kembalikan UI**:
```php
// Di dashboard/pendaftar.blade.php, hapus kondisi @if($pendaftar->count() == 0)
```

## Status Implementasi

✅ Database constraint ditambahkan
✅ Model validation ditambahkan  
✅ Controller protection ditambahkan
✅ Middleware protection ditambahkan
✅ UI/UX improvements ditambahkan
✅ Data cleanup commands dibuat
✅ Testing dilakukan
✅ Dokumentasi lengkap

**Sistem Single Registration sudah aktif dan berfungsi dengan baik!**