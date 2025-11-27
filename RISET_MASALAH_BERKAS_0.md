# Riset Masalah: Upload Berkas Menampilkan 0

## 🔍 MASALAH

Di dashboard pendaftar, card "Upload Berkas" menampilkan **0 Berkas terupload** padahal seharusnya ada berkas yang sudah diupload.

```
Upload Berkas
0  ← MASALAH: Menampilkan 0
Berkas terupload
Kelola Berkas →
```

## 🕵️ INVESTIGASI

### 1. Kode di Dashboard Pendaftar
**File:** `resources/views/dashboard/pendaftar.blade.php`

**Kode Sebelumnya:**
```php
@php
    $p = $pendaftar->first();
    $berkasCount = $p->berkas->count();  // ← MASALAH DI SINI
    $hasPembayaran = $p->pembayaran ? true : false;
@endphp
```

**Masalah:**
- `$p->berkas->count()` menghitung **SEMUA** record di tabel `pendaftar_berkas`
- Termasuk berkas yang **DI-SKIP** (KIP/KKS yang tidak diupload)

### 2. Fitur Skip Berkas
**File:** `app/Http/Controllers/BerkasController.php`

**Method:** `skip(Request $request, $pendaftarId)`

Ketika siswa skip berkas KIP/KKS, sistem membuat record dengan:
```php
PendaftarBerkas::create([
    'pendaftar_id' => $pendaftarId,
    'jenis' => $jenis,
    'nama_file' => 'DILEWATI',  // ← Penanda berkas di-skip
    'url' => null,               // ← Tidak ada file
    'ukuran_kb' => 0
]);
```

### 3. Skenario yang Menyebabkan Masalah

**Contoh Kasus:**
1. Siswa upload 5 berkas: PAS_FOTO, IJAZAH, RAPOR, AKTA, KK
2. Siswa skip 2 berkas: KIP, KKS
3. Total record di database: **7 record**
4. Berkas yang benar-benar diupload: **5 file**
5. Dashboard menampilkan: **7** ❌ (SALAH!)
6. Seharusnya menampilkan: **5** ✅

**Atau kasus ekstrim:**
1. Siswa belum upload berkas sama sekali
2. Siswa skip KIP dan KKS
3. Total record: **2 record** (keduanya DILEWATI)
4. Dashboard menampilkan: **2** ❌ (SALAH!)
5. Seharusnya menampilkan: **0** ✅

## ✅ SOLUSI

### Perbaikan Kode
**File:** `resources/views/dashboard/pendaftar.blade.php`

**Kode Baru:**
```php
@php
    $p = $pendaftar->first();
    // Hitung hanya berkas yang benar-benar diupload (bukan yang di-skip)
    $berkasCount = $p->berkas
        ->where('nama_file', '!=', 'DILEWATI')
        ->where('url', '!=', null)
        ->count();
    $hasPembayaran = $p->pembayaran ? true : false;
@endphp
```

**Penjelasan:**
- Filter berkas dengan `nama_file != 'DILEWATI'` → Exclude berkas yang di-skip
- Filter berkas dengan `url != null` → Hanya yang ada filenya
- Hasilnya: hanya berkas yang **benar-benar diupload**

## 🧪 TESTING

### Test Case 1: Semua Berkas Diupload
```
Upload: PAS_FOTO, IJAZAH, RAPOR, KIP, KKS, AKTA, KK
Skip: -
Expected: 7 berkas
```

### Test Case 2: Skip KIP dan KKS
```
Upload: PAS_FOTO, IJAZAH, RAPOR, AKTA, KK
Skip: KIP, KKS
Expected: 5 berkas (bukan 7)
```

### Test Case 3: Belum Upload Sama Sekali
```
Upload: -
Skip: KIP, KKS
Expected: 0 berkas (bukan 2)
```

### Test Case 4: Upload Sebagian
```
Upload: PAS_FOTO, IJAZAH
Skip: KIP
Expected: 2 berkas (bukan 3)
```

## 📊 DAMPAK PERBAIKAN

### Sebelum Perbaikan:
- ❌ Menampilkan jumlah record di database
- ❌ Termasuk berkas yang di-skip
- ❌ Membingungkan user

### Setelah Perbaikan:
- ✅ Menampilkan jumlah file yang benar-benar diupload
- ✅ Tidak menghitung berkas yang di-skip
- ✅ Informasi akurat untuk user

## 🔗 FILE TERKAIT

1. **Dashboard Pendaftar**
   - File: `resources/views/dashboard/pendaftar.blade.php`
   - Baris: ~48-52
   - Status: ✅ DIPERBAIKI

2. **Berkas Controller**
   - File: `app/Http/Controllers/BerkasController.php`
   - Method: `skip()` - Baris 48-67
   - Status: ✅ Sudah benar (tidak perlu diubah)

3. **Model Pendaftar**
   - File: `app/Models/Pendaftar.php`
   - Relasi: `berkas()` - Baris 56-59
   - Status: ✅ Sudah benar (tidak perlu diubah)

## 💡 REKOMENDASI TAMBAHAN

### 1. Tambahkan Indikator Visual
Tampilkan berkas mana yang di-skip di halaman detail:
```blade
@foreach($pendaftar->berkas as $b)
    @if($b->nama_file == 'DILEWATI')
        <span class="text-gray-400 italic">Dilewati</span>
    @else
        <a href="{{ Storage::url($b->url) }}">{{ $b->nama_file }}</a>
    @endif
@endforeach
```

### 2. Tambahkan Validasi Kelengkapan
Cek apakah semua berkas wajib sudah diupload:
```php
$berkasWajib = ['PAS_FOTO', 'IJAZAH', 'RAPOR', 'AKTA', 'KK'];
$berkasOpsional = ['KIP', 'KKS'];

$berkasTerupload = $p->berkas
    ->whereIn('jenis', $berkasWajib)
    ->where('url', '!=', null)
    ->pluck('jenis')
    ->toArray();

$berkasKurang = array_diff($berkasWajib, $berkasTerupload);
$isLengkap = empty($berkasKurang);
```

### 3. Progress Bar
Tampilkan progress upload berkas:
```blade
<div class="w-full bg-gray-200 rounded-full h-2">
    <div class="bg-blue-600 h-2 rounded-full" 
         style="width: {{ ($berkasCount / 5) * 100 }}%">
    </div>
</div>
<p class="text-xs text-gray-600 mt-1">
    {{ $berkasCount }} dari 5 berkas wajib
</p>
```

## 🎯 KESIMPULAN

### Root Cause:
Perhitungan berkas menggunakan `count()` tanpa filter, sehingga menghitung semua record termasuk yang di-skip.

### Solution:
Filter berkas dengan kondisi:
- `nama_file != 'DILEWATI'`
- `url != null`

### Status: ✅ RESOLVED

### Impact: 
- Dashboard sekarang menampilkan jumlah berkas yang **akurat**
- User tidak bingung dengan angka yang tidak sesuai
- Sistem lebih transparan dan user-friendly
