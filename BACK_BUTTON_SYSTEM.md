# Sistem Tombol Back Universal

## Deskripsi
Sistem tombol back yang terintegrasi di seluruh aplikasi SPMB untuk memudahkan navigasi user tanpa bergantung pada tombol back browser.

## Fitur Utama

### 1. Tombol Back Global
- **Lokasi**: Terintegrasi di layout utama (`layouts/app.blade.php`)
- **Tampil**: Otomatis di semua halaman kecuali dashboard dan halaman yang dikecualikan
- **Target**: Kembali ke dashboard untuk user yang sudah login

### 2. Tombol Back Khusus
- **Halaman Login/Register**: Kembali ke beranda atau halaman sebelumnya
- **Halaman Laporan**: Navigasi hierarkis (laporan detail → laporan index → dashboard)

### 3. Komponen Back Button
- **File**: `resources/views/components/back-button.blade.php`
- **Props**:
  - `url`: URL tujuan spesifik (opsional)
  - `text`: Teks tombol (default: "Kembali")
  - `fallback`: URL fallback jika tidak ada referrer (default: "/")

## Implementasi

### 1. Global Back Button (Layout)
```php
@if(!isset($hideBackButton) || !$hideBackButton)
    @if(request()->route() && request()->route()->getName() !== 'dashboard' && auth()->check())
        <x-back-button :url="route('dashboard')" />
    @endif
@endif
```

### 2. Menyembunyikan Tombol Back
Untuk menyembunyikan tombol back di halaman tertentu:
```php
@php
$hideBackButton = true;
@endphp
```

### 3. Tombol Back Manual
Untuk halaman yang membutuhkan navigasi khusus:
```php
<x-back-button :url="route('specific.route')" text="Kembali ke Halaman" />
```

### 4. Tombol Back Pintar
Untuk halaman login/register yang bisa kembali ke halaman sebelumnya:
```php
<x-back-button text="Kembali ke Beranda" />
```

## Logika Navigasi

### 1. User Sudah Login
- **Dari halaman manapun** → Dashboard
- **Kecuali**: Dashboard itu sendiri (tombol disembunyikan)

### 2. User Belum Login
- **Login/Register** → Beranda atau halaman sebelumnya (jika ada referrer)
- **Menggunakan**: `window.history.back()` atau fallback ke "/"

### 3. Navigasi Hierarkis
- **Laporan Detail** → Laporan Index → Dashboard
- **Master Data** → Dashboard
- **Verifikasi** → Dashboard

## Halaman dengan Tombol Back

### ✅ Halaman yang Memiliki Tombol Back
- Formulir Pendaftaran
- Detail Pendaftaran
- Verifikasi Administrasi
- Verifikasi Pembayaran
- Master Jurusan
- Master Gelombang
- Laporan Index
- Laporan Pendaftar
- Laporan Keuangan
- Peta Sebaran
- Login (ke beranda)
- Register (ke beranda)

### ❌ Halaman Tanpa Tombol Back
- Dashboard (semua role)
- Beranda/Welcome

## Kustomisasi

### 1. Mengubah Target Default
Edit di `layouts/app.blade.php`:
```php
<x-back-button :url="route('custom.route')" />
```

### 2. Mengubah Styling
Edit di `components/back-button.blade.php`:
```php
class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200"
```

### 3. Menambahkan Kondisi Khusus
```php
@if(auth()->user()->role === 'admin')
    <x-back-button :url="route('admin.dashboard')" />
@else
    <x-back-button :url="route('dashboard')" />
@endif
```

## JavaScript Functionality

### 1. Smart Back Function
```javascript
function goBack() {
    if (document.referrer && document.referrer !== window.location.href) {
        window.history.back();
    } else {
        window.location.href = '{{ $fallback }}';
    }
}
```

### 2. Deteksi Referrer
- **Ada referrer**: Gunakan `window.history.back()`
- **Tidak ada referrer**: Redirect ke fallback URL

## Keuntungan Sistem

### 1. User Experience
- ✅ Navigasi konsisten di seluruh aplikasi
- ✅ Tidak bergantung pada tombol browser
- ✅ Navigasi yang intuitif dan predictable

### 2. Developer Experience
- ✅ Implementasi sekali, jalan di mana-mana
- ✅ Mudah dikustomisasi per halaman
- ✅ Komponen reusable

### 3. Maintenance
- ✅ Satu tempat untuk mengatur logika back
- ✅ Mudah diupdate styling secara global
- ✅ Konsistensi UI/UX

## Troubleshooting

### 1. Tombol Back Tidak Muncul
- Cek apakah `$hideBackButton = true` di view
- Pastikan user sudah login (untuk halaman internal)
- Periksa kondisi di layout

### 2. Tombol Back Salah Target
- Periksa parameter `url` di komponen
- Cek logika kondisional di layout
- Verifikasi route name

### 3. Styling Tidak Sesuai
- Edit file `components/back-button.blade.php`
- Pastikan Tailwind CSS class tersedia
- Cek override CSS di halaman spesifik

## Status Implementasi

✅ Komponen back button dibuat
✅ Integrasi global di layout
✅ Implementasi di semua halaman utama
✅ Logika smart back untuk login/register
✅ Penyembunyian di dashboard
✅ Dokumentasi lengkap

**Sistem tombol back universal sudah aktif dan berfungsi dengan baik!**