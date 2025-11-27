@extends('layouts.app')

@section('title', 'Dashboard Pendaftar')

@php
$hideBackButton = true;
@endphp

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl p-8 mb-8 shadow-lg">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h1>
            <p class="text-blue-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>
        <div class="text-right">
            @if($pendaftar->count() > 0)
                @php
                    $p = $pendaftar->first();
                    $isLulus = in_array($p->status, ['LULUS', 'PAYMENT_VERIFIED']);
                @endphp
                @if($isLulus)
                    <div class="bg-green-500 text-white px-6 py-3 rounded-xl font-bold text-lg flex items-center gap-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        LULUS
                    </div>
                @else
                    <div class="bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold text-lg">
                        Dalam Proses
                    </div>
                @endif
            @else
                <div class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold text-lg">
                    Belum Daftar
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Dashboard Stats -->
@if($pendaftar->count() > 0)
    @php
        $p = $pendaftar->first();
        // Hitung hanya berkas yang benar-benar diupload (bukan yang di-skip)
        $berkasCount = $p->berkas->where('nama_file', '!=', 'DILEWATI')->where('url', '!=', null)->count();
        $hasPembayaran = $p->pembayaran ? true : false;
    @endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-blue-500">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-600 font-semibold">Upload Berkas</h3>
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $berkasCount }}</p>
        <p class="text-sm text-gray-500 mt-1">Berkas terupload</p>
        <a href="{{ route('pendaftaran.show', $p->id) }}" class="text-blue-600 text-sm font-semibold mt-3 inline-block hover:underline">Kelola Berkas →</a>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-green-500">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-600 font-semibold">Status Pembayaran</h3>
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        @if($hasPembayaran)
            @php
                $statusPembayaran = [
                    'PENDING' => ['text' => 'Menunggu', 'color' => 'text-yellow-600'],
                    'VERIFIED' => ['text' => 'Terverifikasi', 'color' => 'text-green-600'],
                    'REJECTED' => ['text' => 'Ditolak', 'color' => 'text-red-600']
                ];
                $status = $statusPembayaran[$p->pembayaran->status] ?? ['text' => 'Belum', 'color' => 'text-gray-600'];
            @endphp
            <p class="text-3xl font-bold {{ $status['color'] }}">{{ $status['text'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Rp {{ number_format($p->pembayaran->nominal, 0, ',', '.') }}</p>
        @else
            <p class="text-3xl font-bold text-gray-400">Belum</p>
            <p class="text-sm text-gray-500 mt-1">Belum upload</p>
        @endif
        <a href="{{ route('pendaftaran.pembayaran', $p->id) }}" class="text-green-600 text-sm font-semibold mt-3 inline-block hover:underline">Kelola Pembayaran →</a>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-purple-500">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-600 font-semibold">Cetak Kartu</h3>
            <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">Siap</p>
        <p class="text-sm text-gray-500 mt-1">Kartu pendaftaran</p>
        <a href="{{ route('cetak.kartu', $p->id) }}" target="_blank" class="text-purple-600 text-sm font-semibold mt-3 inline-block hover:underline">Cetak Sekarang →</a>
    </div>
</div>
@endif

<!-- CTA Button -->
@if($pendaftar->count() == 0)
<div class="mb-8">
    <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition transform hover:scale-105">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>
        Buat Pendaftaran Baru
    </a>
</div>
@else
<div class="mb-8">
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-center gap-3">
            <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-blue-900">Informasi Pendaftaran</h3>
                <p class="text-blue-700">Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar <strong>1 kali</strong> saja.</p>
                <p class="text-sm text-blue-600 mt-1">Silakan kelola pendaftaran Anda yang sudah ada di bawah ini.</p>
            </div>
        </div>
    </div>
</div>
@endif

@if($pendaftar->count() > 0)
<!-- Pendaftaran List -->
<div class="space-y-4">
    @foreach($pendaftar as $p)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-green-100 text-green-700 rounded-xl w-12 h-12 flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $p->no_pendaftaran }}</h3>
                            <p class="text-sm text-gray-500">Nomor Pendaftaran</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
                            <span class="font-medium">{{ $p->jurusan->nama }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                            <span class="font-medium">{{ $p->gelombang->nama }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-3">
                    @php
                        $statusConfig = [
                            'SUBMIT' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Menunggu Verifikasi Berkas'],
                            'BERKAS_VALID' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Berkas Valid - Silakan Bayar'],
                            'LUNAS' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Lunas - Menunggu Keputusan'],
                            'LULUS' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'DITERIMA'],
                            'TIDAK_LULUS' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Tidak Diterima'],
                        ];
                        $status = $statusConfig[$p->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $p->status];
                    @endphp
                    <span class="{{ $status['bg'] }} {{ $status['text'] }} px-4 py-2 rounded-full font-semibold text-sm">
                        {{ $status['label'] }}
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 h-1.5"></div>
    </div>
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-2xl shadow-lg p-12 text-center">
    <div class="bg-gray-100 text-gray-400 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Pendaftaran</h3>
    <p class="text-gray-600 mb-6">Anda belum memiliki pendaftaran. Mulai dengan membuat pendaftaran baru.</p>
    <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-3 rounded-xl font-bold hover:shadow-xl transition transform hover:scale-105">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>
        Buat Pendaftaran Sekarang
    </a>
</div>
@endif
@endsection
