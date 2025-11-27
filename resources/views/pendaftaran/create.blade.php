@extends('layouts.app')

@section('title', 'Formulir Pendaftaran')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Formulir Pendaftaran</h2>
    
    <form action="{{ route('pendaftaran.store') }}" method="POST">
        @csrf
        
        <h3 class="font-bold text-lg mb-3">Pilihan Jurusan & Gelombang</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2">Gelombang</label>
                <select name="gelombang_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Pilih Gelombang</option>
                    @foreach($gelombang as $g)
                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2">Jurusan</label>
                <select name="jurusan_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Pilih Jurusan</option>
                    @foreach($jurusan as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h3 class="font-bold text-lg mb-3">Data Siswa</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2">NIK</label>
                <input type="text" name="nik" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-2">NISN</label>
                <input type="text" name="nisn" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-2">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Jenis Kelamin</label>
                <select name="jk" class="w-full border px-3 py-2 rounded" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block mb-2">Tempat Lahir</label>
                <input type="text" name="tmp_lahir" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Kota/Kabupaten</label>
                <select name="kota" class="w-full border px-3 py-2 rounded" required onchange="setCoordinates(this.value)">
                    <option value="">Pilih Kota/Kabupaten</option>
                    <option value="Bandung|-6.9175|107.6191">Bandung</option>
                    <option value="Jakarta|-6.2088|106.8456">Jakarta</option>
                    <option value="Surabaya|-7.2575|112.7521">Surabaya</option>
                    <option value="Medan|3.5952|98.6722">Medan</option>
                    <option value="Semarang|-6.9667|110.4167">Semarang</option>
                    <option value="Makassar|-5.1477|119.4327">Makassar</option>
                    <option value="Palembang|-2.9761|104.7754">Palembang</option>
                    <option value="Tangerang|-6.1783|106.6319">Tangerang</option>
                    <option value="Depok|-6.4025|106.7942">Depok</option>
                    <option value="Bekasi|-6.2349|106.9896">Bekasi</option>
                    <option value="Bogor|-6.5971|106.8060">Bogor</option>
                    <option value="Yogyakarta|-7.7956|110.3695">Yogyakarta</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block mb-2">Alamat Lengkap</label>
                <textarea name="alamat" class="w-full border px-3 py-2 rounded" rows="3" required placeholder="Masukkan alamat lengkap (jalan, RT/RW, kelurahan, kecamatan)"></textarea>
            </div>
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">
            <div>
                <label class="block mb-2">Biaya Pendaftaran</label>
                <input type="number" name="biaya_pendaftaran" class="w-full border px-3 py-2 rounded" placeholder="Rp" required>
            </div>
        </div>

        <h3 class="font-bold text-lg mb-3">Data Orang Tua</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2">Nama Ayah</label>
                <input type="text" name="nama_ayah" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-2">Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-2">Nama Ibu</label>
                <input type="text" name="nama_ibu" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-2">Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <h3 class="font-bold text-lg mb-3">Asal Sekolah</h3>
        <div class="mb-6">
            <div>
                <label class="block mb-2">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="w-full border px-3 py-2 rounded" required>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" name="submit" value="0" class="bg-gray-600 text-white px-6 py-2 rounded">Simpan Draft</button>
            <button type="submit" name="submit" value="1" class="bg-blue-600 text-white px-6 py-2 rounded">Kirim Pendaftaran</button>
        </div>
    </form>
</div>

<script>
function setCoordinates(value) {
    if (value) {
        const parts = value.split('|');
        if (parts.length === 3) {
            document.getElementById('lat').value = parts[1];
            document.getElementById('lng').value = parts[2];
        }
    } else {
        document.getElementById('lat').value = '';
        document.getElementById('lng').value = '';
    }
}
</script>
@endsection
