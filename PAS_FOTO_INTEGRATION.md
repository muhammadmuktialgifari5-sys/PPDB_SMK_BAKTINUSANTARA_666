# Integrasi Pas Foto 3x4 dengan Kartu Pendaftaran

## Deskripsi
Fitur upload pas foto 3x4 yang terintegrasi dengan sistem berkas dan otomatis muncul di kartu pendaftaran siswa.

## Fitur yang Ditambahkan

### 1. Upload Pas Foto
- **Lokasi**: Halaman detail pendaftaran (`pendaftaran/show.blade.php`)
- **Jenis Berkas**: "Pas Foto 3x4" ditambahkan ke dropdown
- **Validasi**: Hanya menerima file gambar (JPG, PNG)
- **Ukuran**: Maksimal 2MB

### 2. Integrasi dengan Data Siswa
- **Controller**: `BerkasController.php`
- **Logika**: Ketika upload pas foto, otomatis update field `foto` di tabel `pendaftar_data_siswa`
- **Storage**: File disimpan di `storage/app/public/berkas/`

### 3. Tampilan di Kartu Pendaftaran
- **File**: `cetak/kartu.blade.php`
- **Posisi**: Di sebelah kanan data siswa
- **Ukuran**: 90px x 120px (rasio 3:4)
- **Fallback**: Placeholder jika belum upload foto

### 4. Preview di Halaman Detail
- **Lokasi**: Tabel berkas di halaman detail pendaftaran
- **Ukuran**: 64px x 80px (thumbnail)
- **Border**: Border abu-abu dengan rounded corners

### 5. Tampilan di Verifikasi
- **Lokasi**: Halaman verifikasi administrasi
- **Ukuran**: 32px x 32px (avatar kecil)
- **Posisi**: Di sebelah nama siswa

## Implementasi Teknis

### 1. Validasi Upload
```php
// Validasi berbeda untuk pas foto
if ($request->jenis === 'PAS_FOTO') {
    $request->validate([
        'jenis' => 'required|in:PAS_FOTO,IJAZAH,RAPOR,KIP,KKS,AKTA,KK,LAINNYA',
        'file' => 'required|file|mimes:jpg,jpeg,png|max:2048'
    ]);
}
```

### 2. Update Data Siswa
```php
// Jika upload pas foto, update foto di data siswa
if ($request->jenis === 'PAS_FOTO') {
    $pendaftar = Pendaftar::findOrFail($pendaftarId);
    $pendaftar->dataSiswa->update([
        'foto' => $path
    ]);
}
```

### 3. Tampilan di Kartu
```html
@if($pendaftar->dataSiswa->foto)
    <img src="{{ asset('storage/' . $pendaftar->dataSiswa->foto) }}" 
         alt="Pas Foto" 
         style="width: 90px; height: 120px; object-fit: cover; border: 2px solid #333;">
@else
    <div style="width: 90px; height: 120px; border: 2px dashed #ccc;">
        <span>Pas Foto 3x4</span>
    </div>
@endif
```

### 4. JavaScript Validation
```javascript
jenisSelect.addEventListener('change', function() {
    if (this.value === 'PAS_FOTO') {
        fileInput.accept = 'image/jpeg,image/jpg,image/png';
        fileHint.textContent = 'Pas Foto 3x4 - Format: JPG, PNG (Max: 2MB)';
    }
});
```

## Alur Kerja

### 1. Upload Pas Foto
```
Siswa → Detail Pendaftaran → Upload Berkas → Pilih "Pas Foto 3x4" → Upload File
```

### 2. Penyimpanan Data
```
File → storage/berkas/ → Record di tabel pendaftar_berkas → Update foto di pendaftar_data_siswa
```

### 3. Tampilan di Kartu
```
Cetak Kartu → Ambil foto dari pendaftar_data_siswa → Tampilkan di kartu (90x120px)
```

## Validasi dan Keamanan

### 1. Validasi File
- ✅ Hanya file gambar (JPG, PNG)
- ✅ Maksimal 2MB
- ✅ Validasi MIME type
- ✅ Validasi ekstensi file

### 2. Storage Security
- ✅ File disimpan di storage/app/public/
- ✅ Nama file di-hash dengan timestamp
- ✅ Akses melalui storage link

### 3. Display Security
- ✅ Validasi path file sebelum ditampilkan
- ✅ Fallback jika file tidak ditemukan
- ✅ Object-fit untuk mencegah distorsi

## Styling dan UI/UX

### 1. Kartu Pendaftaran
- **Layout**: Flex dengan foto di kanan
- **Ukuran**: 90px x 120px (rasio 3:4)
- **Border**: 2px solid #333
- **Fallback**: Border dashed dengan placeholder text

### 2. Preview di Detail
- **Ukuran**: 64px x 80px
- **Border**: 1px solid gray
- **Rounded**: Rounded corners
- **Position**: Di bawah nama file

### 3. Avatar di Verifikasi
- **Ukuran**: 32px x 32px
- **Shape**: Rounded full (circle)
- **Fallback**: Icon user dengan background gray

## Troubleshooting

### 1. Foto Tidak Muncul di Kartu
- Cek apakah file ada di storage/berkas/
- Pastikan field foto terisi di tabel pendaftar_data_siswa
- Verifikasi storage link sudah dibuat

### 2. Upload Gagal
- Cek validasi file (format dan ukuran)
- Pastikan folder storage/berkas/ writable
- Cek log Laravel untuk error detail

### 3. Foto Terdistorsi
- Gunakan object-fit: cover
- Pastikan rasio aspek 3:4 untuk pas foto
- Cek CSS styling di kartu

## Status Implementasi

✅ Upload pas foto di berkas
✅ Validasi khusus untuk file gambar
✅ Integrasi dengan data siswa
✅ Tampilan di kartu pendaftaran
✅ Preview di halaman detail
✅ Avatar di halaman verifikasi
✅ JavaScript validation
✅ Fallback placeholder
✅ Dokumentasi lengkap

**Fitur pas foto 3x4 sudah terintegrasi penuh dengan sistem!**