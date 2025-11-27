# Sistem Verifikasi Email dengan Kode OTP

## Deskripsi
Sistem verifikasi email menggunakan kode OTP 6 digit yang dikirim ke Gmail asli pendaftar untuk memastikan email yang valid.

## Fitur yang Ditambahkan

### 1. Database Schema
- **Field Baru di Tabel `pengguna`**:
  - `email_verified_at` - Timestamp verifikasi email
  - `verification_code` - Kode OTP 6 digit
  - `verification_code_expires_at` - Waktu kadaluarsa kode

### 2. Alur Registrasi Baru
```
Registrasi → Generate Kode OTP → Kirim Email → Verifikasi Kode → Aktivasi Akun
```

### 3. Validasi Email
- **Kode OTP**: 6 digit angka random
- **Berlaku**: 15 menit
- **Kirim Ulang**: Tersedia jika kode kadaluarsa
- **Gmail SMTP**: Menggunakan Gmail asli

## Implementasi Teknis

### 1. Registrasi dengan Verifikasi
```php
// Generate kode 6 digit
$verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

// User tidak aktif sampai verifikasi
'aktif' => 0,
'verification_code' => $verificationCode,
'verification_code_expires_at' => now()->addMinutes(15)
```

### 2. Pengiriman Email
```php
Mail::raw(
    "Kode verifikasi email Anda untuk SMK Bakti Nusantara 666: {$code}\n\nKode ini berlaku selama 15 menit.",
    function ($message) use ($user) {
        $message->to($user->email)
               ->subject('Kode Verifikasi Email - SMK Bakti Nusantara 666');
    }
);
```

### 3. Validasi Login
```php
if (!$user->email_verified_at) {
    return back()->withErrors(['email' => 'Email belum diverifikasi. Silakan cek email Anda.']);
}
```

## Konfigurasi Email (Gmail)

### 1. Setup Gmail SMTP
Tambahkan ke file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="SMK Bakti Nusantara 666"
```

### 2. Gmail App Password
1. Aktifkan 2-Factor Authentication di Gmail
2. Generate App Password di Google Account Settings
3. Gunakan App Password sebagai `MAIL_PASSWORD`

## Route dan Controller

### 1. Route Verifikasi
```php
Route::get('/verify-email/{userId}', [AuthController::class, 'showVerifyEmailForm'])->name('verify.email.form');
Route::post('/verify-email/{userId}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('/resend-verification/{userId}', [AuthController::class, 'resendVerificationCode'])->name('resend.verification');
```

### 2. Method Controller
- `showVerifyEmailForm()` - Tampilkan form input kode
- `verifyEmail()` - Validasi kode dan aktivasi akun
- `resendVerificationCode()` - Kirim ulang kode baru

## UI/UX Verifikasi

### 1. Halaman Verifikasi
- **Input**: 6 digit dengan format otomatis
- **Info**: Email tujuan ditampilkan
- **Timer**: Informasi kadaluarsa 15 menit
- **Resend**: Tombol kirim ulang kode

### 2. Validasi Real-time
```javascript
// Auto format hanya angka
document.querySelector('input[name="verification_code"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
```

## Keamanan

### 1. Validasi Kode
- ✅ Kode hanya berlaku 15 menit
- ✅ Kode dihapus setelah verifikasi berhasil
- ✅ Validasi format 6 digit
- ✅ Rate limiting untuk resend

### 2. Email Security
- ✅ Menggunakan Gmail SMTP dengan TLS
- ✅ App Password untuk autentikasi
- ✅ Email template sederhana untuk keamanan

### 3. Database Security
- ✅ Kode disimpan plain (tidak sensitive setelah 15 menit)
- ✅ Timestamp kadaluarsa untuk cleanup otomatis
- ✅ User tidak aktif sampai verifikasi

## Alur Lengkap

### 1. Registrasi
```
User Input Data → Validasi → Generate Kode → Simpan User (aktif=0) → Kirim Email → Redirect ke Verifikasi
```

### 2. Verifikasi
```
Input Kode → Validasi Kode & Waktu → Update User (aktif=1, email_verified_at) → Redirect ke Login
```

### 3. Login
```
Input Credentials → Cek Password → Cek Email Verified → Login Success
```

## Error Handling

### 1. Email Gagal Terkirim
- Log error tanpa gagalkan registrasi
- User tetap bisa resend kode
- Fallback ke log driver jika SMTP gagal

### 2. Kode Kadaluarsa
- Pesan error yang jelas
- Tombol resend otomatis muncul
- Generate kode baru dengan waktu baru

### 3. Kode Salah
- Pesan error spesifik
- Input tetap fokus untuk retry
- Tidak ada limit percobaan (kode akan kadaluarsa)

## Testing

### 1. Test Registrasi
```php
// Test generate kode
$user = User::factory()->create();
$this->assertNotNull($user->verification_code);
$this->assertEquals(6, strlen($user->verification_code));
```

### 2. Test Verifikasi
```php
// Test kode valid
$response = $this->post("/verify-email/{$user->id}", [
    'verification_code' => $user->verification_code
]);
$this->assertNotNull($user->fresh()->email_verified_at);
```

## Troubleshooting

### 1. Email Tidak Terkirim
- Cek konfigurasi SMTP di .env
- Pastikan App Password Gmail benar
- Cek log Laravel untuk error detail

### 2. Kode Tidak Valid
- Pastikan kode belum kadaluarsa (15 menit)
- Cek format input (6 digit angka)
- Verifikasi user ID di URL

### 3. Login Gagal Setelah Verifikasi
- Pastikan `email_verified_at` terisi
- Cek `aktif` = 1 di database
- Clear cache session jika perlu

## Status Implementasi

✅ Database schema untuk verifikasi email
✅ Generate dan kirim kode OTP via email
✅ Halaman verifikasi dengan UI yang user-friendly
✅ Validasi kode dan aktivasi akun
✅ Resend kode jika kadaluarsa
✅ Integrasi dengan sistem login
✅ Error handling yang komprehensif
✅ Dokumentasi lengkap

**Sistem verifikasi email dengan Gmail sudah siap digunakan!**

## Catatan Penting
- Pastikan menggunakan Gmail asli dengan App Password
- Kode OTP berlaku 15 menit untuk keamanan
- User tidak bisa login sampai email diverifikasi
- Sistem otomatis mengirim email saat registrasi