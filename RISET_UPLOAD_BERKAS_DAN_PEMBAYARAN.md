# Riset Upload Berkas dan Status Pembayaran

## 📋 RINGKASAN SISTEM

### A. UPLOAD BERKAS

#### 1. Jenis Berkas yang Didukung
Berdasarkan migration dan controller:
- **PAS_FOTO** (ditambahkan via migration terpisah)
- **IJAZAH** (wajib)
- **RAPOR** (wajib)
- **KIP** (opsional - bisa dilewati)
- **KKS** (opsional - bisa dilewati)
- **AKTA** (wajib)
- **KK** (wajib)
- **LAINNYA** (enum di database, tapi tidak digunakan di controller)

#### 2. Validasi Upload
```php
'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
```
- Format: PDF, JPG, JPEG, PNG
- Ukuran maksimal: 2MB (2048 KB)

#### 3. Proses Upload
**File:** `app/Http/Controllers/BerkasController.php`

**Method:** `upload(Request $request, $pendaftarId)`

**Alur:**
1. Validasi jenis berkas dan file
2. Cek apakah berkas jenis ini sudah diupload (tidak boleh duplikat)
3. Simpan file ke `storage/app/public/berkas/`
4. Nama file: `timestamp_namaasli.ext`
5. Simpan record ke tabel `pendaftar_berkas`
6. Catat ke audit log

**Tabel:** `pendaftar_berkas`
```sql
- id
- pendaftar_id (FK)
- jenis (ENUM)
- nama_file (nama asli file)
- url (path di storage)
- ukuran_kb (ukuran file dalam KB)
- valid (0/1 - untuk verifikasi admin)
- catatan (catatan verifikasi)
- timestamps
```

#### 4. Fitur Skip Berkas
**Method:** `skip(Request $request, $pendaftarId)`

**Berkas yang bisa dilewati:**
- KIP (Kartu Indonesia Pintar)
- KKS (Kartu Keluarga Sejahtera)

**Cara kerja:**
- Membuat record dengan `nama_file = 'DILEWATI'`
- `url = null`
- `ukuran_kb = 0`

#### 5. Verifikasi Berkas (Admin/Verifikator)
**Method:** `verifikasi(Request $request, $berkasId)`

**Field:**
- `valid` (0 = tidak valid, 1 = valid)
- `catatan` (catatan verifikasi)

---

### B. STATUS PEMBAYARAN

#### 1. Status Pembayaran
Berdasarkan enum di database:
- **PENDING** - Menunggu verifikasi keuangan
- **VERIFIED** - Terverifikasi oleh staff keuangan
- **REJECTED** - Ditolak oleh staff keuangan

#### 2. Validasi Upload Bukti Pembayaran
```php
'bukti_bayar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
'metode_pembayaran' => 'required|string'
'tanggal_bayar' => 'required|date'
'nominal' => 'required|string'
```

#### 3. Proses Upload Bukti Pembayaran
**File:** `app/Http/Controllers/PembayaranController.php`

**Method:** `upload(Request $request, $pendaftarId)`

**Alur:**
1. Validasi input
2. Simpan file ke `storage/app/public/pembayaran/`
3. Nama file: `timestamp_namaasli.ext`
4. Parse nominal (hapus format Rp, titik, koma)
5. `updateOrCreate` record pembayaran dengan status `PENDING`
6. **Update status pendaftar menjadi `PAID`**
7. Catat ke audit log

**Tabel:** `pembayaran`
```sql
- id
- pendaftar_id (FK)
- nominal (DECIMAL 12,2)
- metode_pembayaran (STRING) - ditambah via migration
- tanggal_bayar (DATE) - ditambah via migration
- bukti_bayar (path file)
- status (ENUM: PENDING, VERIFIED, REJECTED)
- catatan (catatan verifikasi)
- timestamps
```

#### 4. Verifikasi Pembayaran (Staff Keuangan)
**Method:** `verifikasi(Request $request, $pembayaranId)`

**Alur:**
1. Update status pembayaran (VERIFIED/REJECTED)
2. Update catatan jika ada
3. **Update status pendaftar:**
   - Jika `VERIFIED` → status pendaftar = `PAYMENT_VERIFIED`
   - Jika `REJECTED` → status pendaftar = `ADM_PASS` (kembali)
4. Simpan nama verifikator dan tanggal
5. Catat ke audit log

---

## 🔄 ALUR STATUS PENDAFTAR

### Status Flow Lengkap:
```
1. DRAFT 
   ↓ (submit formulir)
2. SUBMIT 
   ↓ (verifikasi admin)
3. ADM_PASS / ADM_REJECT
   ↓ (upload bukti bayar)
4. PAID
   ↓ (verifikasi keuangan)
5. PAYMENT_VERIFIED / kembali ke ADM_PASS (jika ditolak)
   ↓ (keputusan kepala sekolah)
6. LULUS / TIDAK_LULUS / CADANGAN
```

### Kondisi Upload Bukti Pembayaran:
**File:** `resources/views/pendaftaran/pembayaran.blade.php`

**Kondisi saat ini:**
```php
@if(in_array($pendaftar->status, ['ADM_PASS', 'PAID', 'PAYMENT_VERIFIED', 'LULUS']))
```

Siswa bisa upload bukti pembayaran jika statusnya:
- ✅ **ADM_PASS** - Lolos verifikasi administrasi
- ✅ **PAID** - Sudah upload (bisa upload ulang jika ditolak)
- ✅ **PAYMENT_VERIFIED** - Sudah terverifikasi (hanya lihat)
- ✅ **LULUS** - Sudah diterima (hanya lihat)

---

## 🐛 TEMUAN MASALAH

### 1. Inkonsistensi Jenis Berkas
**Masalah:**
- Migration: `IJAZAH, RAPOR, KIP, KKS, AKTA, KK, LAINNYA`
- Controller: `PAS_FOTO, IJAZAH, RAPOR, KIP, KKS, AKTA, KK`
- `PAS_FOTO` tidak ada di enum awal, ditambah via migration terpisah
- `LAINNYA` ada di enum tapi tidak digunakan

**Solusi:**
Perlu update migration atau controller agar konsisten.

### 2. Field Pembayaran Ditambah Kemudian
**Masalah:**
- Migration awal tidak punya `metode_pembayaran` dan `tanggal_bayar`
- Ditambahkan via migration terpisah: `2025_11_18_025521_add_payment_fields_to_pembayaran_table.php`

**Status:** Sudah diperbaiki dengan migration tambahan.

### 3. Validasi Berkas Tidak Digunakan
**Masalah:**
- Field `valid` di tabel `pendaftar_berkas` ada
- Method `verifikasi()` di BerkasController ada
- Tapi tidak ada UI untuk verifikasi berkas individual
- Verifikasi hanya di level pendaftar (ADM_PASS/ADM_REJECT)

**Rekomendasi:**
Bisa ditambahkan fitur verifikasi berkas per-item jika diperlukan.

### 4. Upload Ulang Berkas
**Masalah:**
- Sistem tidak mengizinkan upload ulang berkas yang sama
- Jika berkas ditolak, tidak ada cara untuk upload ulang

**Solusi yang mungkin:**
- Tambah fitur delete berkas
- Atau izinkan replace berkas yang sudah ada

---

## 📊 STATISTIK SISTEM

### Berkas yang Wajib:
- PAS_FOTO ✓
- IJAZAH ✓
- RAPOR ✓
- AKTA ✓
- KK ✓

### Berkas yang Opsional:
- KIP (bisa skip)
- KKS (bisa skip)

### Total Berkas Maksimal: 7 file

### Ukuran Total Maksimal: 14 MB (7 × 2MB)

---

## 🔐 KEAMANAN

### 1. Storage
- File disimpan di `storage/app/public/`
- Perlu `php artisan storage:link` untuk akses publik
- Path: `storage/berkas/` dan `storage/pembayaran/`

### 2. Validasi
- ✅ Validasi tipe file (PDF, JPG, JPEG, PNG)
- ✅ Validasi ukuran (max 2MB)
- ✅ Validasi duplikasi berkas
- ✅ Audit log untuk tracking

### 3. Authorization
- Upload berkas: hanya pendaftar (role: pendaftar)
- Verifikasi berkas: admin dan verifikator_adm
- Verifikasi pembayaran: admin dan keuangan

---

## 📝 REKOMENDASI PERBAIKAN

### 1. Konsistensi Enum Berkas
Update migration atau controller agar enum berkas konsisten.

### 2. Fitur Upload Ulang
Tambahkan fitur untuk menghapus dan upload ulang berkas yang ditolak.

### 3. Verifikasi Berkas Individual
Tambahkan UI untuk verifikasi berkas per-item (opsional).

### 4. Validasi Kelengkapan Berkas
Tambahkan pengecekan apakah semua berkas wajib sudah diupload sebelum submit.

### 5. Preview Berkas
Tambahkan preview untuk file PDF dan gambar sebelum upload.

### 6. Compress Image
Tambahkan fitur compress otomatis untuk gambar yang terlalu besar.

---

## 🎯 KESIMPULAN

### Upload Berkas: ✅ BERFUNGSI
- Validasi: ✅
- Storage: ✅
- Audit Log: ✅
- Skip opsional: ✅

### Status Pembayaran: ✅ BERFUNGSI
- Upload bukti: ✅
- Verifikasi: ✅
- Update status otomatis: ✅
- Audit Log: ✅

### Yang Perlu Diperbaiki:
1. ⚠️ Inkonsistensi enum berkas
2. ⚠️ Tidak bisa upload ulang berkas
3. ⚠️ Verifikasi berkas individual tidak digunakan

### Overall: **SISTEM BERJALAN BAIK** dengan beberapa perbaikan minor yang disarankan.
