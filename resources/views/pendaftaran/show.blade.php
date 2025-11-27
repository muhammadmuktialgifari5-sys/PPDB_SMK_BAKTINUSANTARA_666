@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Detail Pendaftaran</h2>
        <a href="{{ route('cetak.kartu', $pendaftar->id) }}" target="_blank" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/></svg>
            Cetak Kartu Pendaftaran
        </a>
    </div>

    <!-- Status Verifikasi Administrasi -->
    @if($pendaftar->status == 'ADM_PASS')
    <div class="mb-6 bg-green-50 border-2 border-green-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-green-500 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-green-800 mb-2">✅ Selamat! Pendaftaran Anda DITERIMA</h3>
                <p class="text-green-700 mb-3">Berkas administrasi Anda telah diverifikasi dan dinyatakan <strong>LULUS VERIFIKASI</strong>.</p>
                @if($pendaftar->user_verifikasi_adm)
                <p class="text-sm text-green-600">Diverifikasi oleh: <strong>{{ $pendaftar->user_verifikasi_adm }}</strong> pada {{ $pendaftar->tgl_verifikasi_adm ? $pendaftar->tgl_verifikasi_adm->format('d M Y H:i') : '-' }}</p>
                @endif
                @if($pendaftar->catatan_verifikasi_adm)
                <div class="mt-3 bg-white p-3 rounded border border-green-200">
                    <p class="text-sm font-semibold text-gray-700">Catatan Admin:</p>
                    <p class="text-sm text-gray-600">{{ $pendaftar->catatan_verifikasi_adm }}</p>
                </div>
                @endif
                <div class="mt-4 bg-green-100 p-4 rounded-lg">
                    <p class="font-bold text-green-900 mb-2">📋 Langkah Selanjutnya:</p>
                    <ol class="list-decimal list-inside space-y-1 text-green-800">
                        <li>Lakukan pembayaran biaya pendaftaran</li>
                        <li>Upload bukti pembayaran</li>
                        <li>Tunggu verifikasi pembayaran dari bagian keuangan</li>
                        <li>Setelah pembayaran terverifikasi, Anda akan dinyatakan LULUS</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @elseif($pendaftar->status == 'ADM_REJECT')
    <div class="mb-6 bg-red-50 border-2 border-red-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-red-500 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-red-800 mb-2">❌ Pendaftaran Anda DITOLAK</h3>
                <p class="text-red-700 mb-3">Mohon maaf, berkas administrasi Anda <strong>TIDAK MEMENUHI SYARAT</strong>.</p>
                @if($pendaftar->user_verifikasi_adm)
                <p class="text-sm text-red-600">Diverifikasi oleh: <strong>{{ $pendaftar->user_verifikasi_adm }}</strong> pada {{ $pendaftar->tgl_verifikasi_adm ? $pendaftar->tgl_verifikasi_adm->format('d M Y H:i') : '-' }}</p>
                @endif
                @if($pendaftar->catatan_verifikasi_adm)
                <div class="mt-3 bg-white p-3 rounded border border-red-200">
                    <p class="text-sm font-semibold text-gray-700">Alasan Penolakan:</p>
                    <p class="text-sm text-gray-600">{{ $pendaftar->catatan_verifikasi_adm }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @elseif($pendaftar->status == 'SUBMIT')
    <div class="mb-6 bg-yellow-50 border-2 border-yellow-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-yellow-500 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-yellow-800 mb-2">⏳ Menunggu Verifikasi Administrasi</h3>
                <p class="text-yellow-700 mb-3">Pendaftaran Anda sedang dalam proses verifikasi oleh tim administrasi.</p>
            </div>
        </div>
    </div>
    @elseif($pendaftar->status == 'PAID')
    <div class="mb-6 bg-blue-50 border-2 border-blue-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-blue-500 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-blue-800 mb-2">💸 Bukti Pembayaran Sudah Diupload</h3>
                <p class="text-blue-700 mb-3">Bukti pembayaran Anda sedang dalam proses verifikasi oleh bagian keuangan.</p>
            </div>
        </div>
    </div>
    @elseif($pendaftar->status == 'PAYMENT_VERIFIED')
    <div class="mb-6 bg-purple-50 border-2 border-purple-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-purple-500 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-purple-800 mb-2">🎉 Pembayaran Terverifikasi!</h3>
                <p class="text-purple-700 mb-3">Selamat! Pembayaran Anda telah diverifikasi. Menunggu pengumuman kelulusan dari kepala sekolah.</p>
            </div>
        </div>
    </div>
    @elseif($pendaftar->status == 'LULUS')
    <div class="mb-6 bg-green-50 border-2 border-green-600 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="bg-green-600 text-white rounded-full p-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-green-800 mb-2">🎓 SELAMAT! Anda DITERIMA di SMK Bakti Nusantara 666</h3>
                <p class="text-green-700 mb-3">Anda resmi diterima sebagai siswa baru di jurusan <strong>{{ $pendaftar->jurusan->nama }}</strong>.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Informasi Pendaftaran -->
    <div class="mb-6 bg-blue-50 p-4 rounded-lg">
        <h3 class="font-bold text-lg mb-3 text-blue-900">Informasi Pendaftaran</h3>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-sm text-gray-600">No. Pendaftaran</p>
                <p class="font-semibold">{{ $pendaftar->no_pendaftaran }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Jurusan</p>
                <p class="font-semibold">{{ $pendaftar->jurusan->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Gelombang</p>
                <p class="font-semibold">{{ $pendaftar->gelombang->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <p><span class="px-3 py-1 rounded-full bg-blue-600 text-white text-sm font-semibold">{{ $pendaftar->status }}</span></p>
            </div>
        </div>
    </div>

    <!-- Data Siswa -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h3 class="font-bold text-lg mb-3 text-gray-900">Data Siswa</h3>
        <div class="flex gap-6">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-semibold">{{ $pendaftar->dataSiswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">NIK</p>
                    <p class="font-semibold">{{ $pendaftar->dataSiswa->nik }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tempat, Tanggal Lahir</p>
                    <p class="font-semibold">{{ $pendaftar->dataSiswa->tmp_lahir }}, {{ $pendaftar->dataSiswa->tgl_lahir->format('d-m-Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-semibold">{{ $pendaftar->dataSiswa->alamat }}</p>
                </div>
            </div>
            @if($pendaftar->dataSiswa->foto)
            <div class="text-center">
                <img src="{{ asset('storage/' . $pendaftar->dataSiswa->foto) }}" alt="Pas Foto" class="w-32 h-40 object-cover border-2 border-gray-400 rounded shadow-md">
                <p class="text-xs text-gray-500 mt-2">Pas Foto 3x4</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Upload Berkas -->
    <div class="mb-6">
        <h3 class="font-bold text-lg mb-3">Upload Berkas</h3>
        
        <form action="{{ route('berkas.upload', $pendaftar->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="flex gap-4">
                <select name="jenis" class="border px-3 py-2 rounded" required>
                    <option value="">Pilih Jenis Berkas</option>
                    <option value="PAS_FOTO">Pas Foto 3x4</option>
                    <option value="IJAZAH">Ijazah</option>
                    <option value="RAPOR">Rapor</option>
                    <option value="KIP">KIP</option>
                    <option value="KKS">KKS</option>
                    <option value="AKTA">Akta</option>
                    <option value="KK">KK</option>
                </select>
                <input type="file" name="file" class="border px-3 py-2 rounded" accept="image/*,application/pdf" required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
            </div>
        </form>

        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Jenis</th>
                    <th class="border p-2">Nama File</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftar->berkas as $b)
                <tr>
                    <td class="border p-2">
                        {{ $b->jenis }}
                        @if($b->jenis === 'PAS_FOTO')
                            <span class="text-blue-600 text-xs block">(Pas Foto 3x4)</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        {{ $b->nama_file }}
                        @if($b->jenis === 'PAS_FOTO' && $b->url)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $b->url) }}" alt="Pas Foto" class="w-24 h-32 object-cover border-2 border-gray-400 rounded shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Ukuran: 3x4</p>
                            </div>
                        @endif
                    </td>
                    <td class="border p-2">
                        @if($b->valid)
                        <span class="text-green-600">Valid</span>
                        @else
                        <span class="text-gray-600">Belum diverifikasi</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
