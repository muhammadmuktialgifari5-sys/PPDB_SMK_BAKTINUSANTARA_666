# Cara Menjalankan Aplikasi SPMB

## ✅ Masalah Sudah Diperbaiki!

Masalah error saat login dan registrasi sudah diperbaiki. Penyebabnya adalah:
- **MySQL tidak berjalan** di sistem Anda
- Konfigurasi sudah diubah ke **SQLite** yang lebih mudah untuk development

## 🚀 Cara Menjalankan Aplikasi

### 1. Pastikan di folder project
```bash
cd /Users/pplgbn666/spmb-app
```

### 2. Jalankan server development
```bash
php artisan serve
```

### 3. Buka browser
Akses: **http://localhost:8000**

## 👤 Akun Login Default

Gunakan akun berikut untuk login:

### Admin
- Email: `admin@spmb.com`
- Password: `password`

### Verifikator
- Email: `verifikator@spmb.com`
- Password: `password`

### Keuangan
- Email: `keuangan@spmb.com`
- Password: `password`

### Kepala Sekolah
- Email: `kepsek@spmb.com`
- Password: `password`

## 📝 Registrasi User Baru

Anda juga bisa mendaftar akun baru sebagai **Pendaftar** melalui halaman registrasi.

## 🔧 Troubleshooting

### Jika masih error, jalankan:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Jika ingin reset database:
```bash
php artisan migrate:fresh --seed
```

## 📊 Database

Aplikasi sekarang menggunakan **SQLite** yang tersimpan di:
```
database/database.sqlite
```

Tidak perlu install MySQL atau MariaDB!

## ✨ Fitur Desain Baru

Aplikasi sudah diperbarui dengan desain modern:
- 🎨 Landing page yang menarik
- 📊 Dashboard dengan card statistik yang cantik
- 🎯 UI/UX yang lebih user-friendly
- 📱 Responsive design untuk mobile
- ✨ Animasi dan hover effects

Selamat menggunakan! 🎉
