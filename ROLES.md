# Dokumentasi Role Sistem SPMB

## Role yang Terdaftar

Sistem SPMB memiliki 5 (lima) role yang terdaftar di database:

### 1. **pendaftar**
- **Deskripsi**: Calon siswa yang mendaftar
- **Akses**:
  - Membuat pendaftaran baru
  - Mengisi formulir data siswa, orang tua, dan asal sekolah
  - Upload berkas persyaratan
  - Upload bukti pembayaran
  - Melihat status pendaftaran
  - Cetak kartu pendaftaran dan bukti bayar
- **Dashboard**: `dashboard.pendaftar`
- **Akun Default**: Dibuat saat registrasi

### 2. **admin**
- **Deskripsi**: Admin Panitia SPMB
- **Akses**:
  - Semua akses verifikator_adm
  - Semua akses keuangan
  - Semua akses kepsek
  - Master data jurusan
  - Master data gelombang
  - Peta sebaran pendaftar
  - Manajemen user
  - Reset password user
- **Dashboard**: `dashboard.admin`
- **Akun Default**: 
  - Email: admin@spmb.com
  - Password: password

### 3. **verifikator_adm**
- **Deskripsi**: Verifikator Administrasi
- **Akses**:
  - Verifikasi data dan berkas pendaftar
  - Approve/reject pendaftaran dengan catatan
  - Verifikasi berkas individual
  - Bulk verifikasi
  - Laporan pendaftar
- **Dashboard**: `dashboard.verifikator`
- **Akun Default**:
  - Email: verifikator@spmb.com
  - Password: password

### 4. **keuangan**
- **Deskripsi**: Staff Keuangan
- **Akses**:
  - Verifikasi bukti pembayaran
  - Approve/reject pembayaran
  - Laporan keuangan
  - Laporan pendaftar
  - Export Excel/PDF
- **Dashboard**: `dashboard.keuangan`
- **Akun Default**:
  - Email: keuangan@spmb.com
  - Password: password

### 5. **kepsek**
- **Deskripsi**: Kepala Sekolah/Yayasan
- **Akses**:
  - Dashboard eksekutif dengan KPI
  - Laporan komprehensif
  - Laporan keuangan
  - Laporan pendaftar
- **Dashboard**: `dashboard.eksekutif`
- **Akun Default**:
  - Email: kepsek@spmb.com
  - Password: password

## Struktur Database

Role disimpan di tabel `pengguna` dengan kolom:
```sql
enum('role', ['pendaftar', 'admin', 'verifikator_adm', 'keuangan', 'kepsek'])
```

## Middleware

Role divalidasi menggunakan `RoleMiddleware` di `app/Http/Middleware/RoleMiddleware.php`

Penggunaan di routes:
```php
Route::middleware('role:admin')->group(function () {
    // Routes khusus admin
});

Route::middleware('role:verifikator_adm,admin')->group(function () {
    // Routes untuk verifikator dan admin
});
```

## Hierarki Akses

```
admin (Full Access)
├── verifikator_adm (Verifikasi Administrasi)
├── keuangan (Verifikasi Pembayaran)
└── kepsek (Dashboard Eksekutif)

pendaftar (Self Service)
```

## Catatan Penting

1. **Admin memiliki akses ke semua fitur** - Admin dapat mengakses semua route yang tersedia untuk role lain
2. **Role name harus exact match** - Gunakan nama role yang tepat sesuai enum di database
3. **Tidak ada role 'verifikator'** - Gunakan `verifikator_adm` bukan `verifikator`
4. **Tidak ada role 'kepala_sekolah'** - Gunakan `kepsek` bukan `kepala_sekolah`

## Contoh Penggunaan di Blade

```blade
@if(auth()->user()->role == 'admin')
    <!-- Konten khusus admin -->
@endif

@if(in_array(auth()->user()->role, ['admin', 'keuangan']))
    <!-- Konten untuk admin dan keuangan -->
@endif
```

## Contoh Penggunaan di Controller

```php
$user = auth()->user();

if ($user->role == 'pendaftar') {
    // Logic untuk pendaftar
}

if (in_array($user->role, ['admin', 'verifikator_adm'])) {
    // Logic untuk admin dan verifikator
}
```
