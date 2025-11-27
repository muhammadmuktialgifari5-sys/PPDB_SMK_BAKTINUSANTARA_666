@extends('layouts.app')

@section('title', 'Dashboard Eksekutif')

@php
$hideBackButton = true;
@endphp

@section('content')
<div class="fixed inset-0 top-[88px] flex -mx-6">
    <!-- Sidebar Navigation -->
    <div class="w-72 flex-shrink-0 bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl p-6 overflow-y-auto">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-blue-400">
                <div class="bg-white rounded-lg p-2">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg">Menu Kepala Sekolah</h3>
                    <p class="text-blue-200 text-xs">Navigasi Cepat</p>
                </div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-white bg-opacity-20 font-semibold transition hover:bg-opacity-30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('laporan.pendaftar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                    <span>Laporan Pendaftar</span>
                </a>
                <a href="{{ route('laporan.keuangan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                    <span>Laporan Keuangan</span>
                </a>
            </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-6">
<!-- Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl p-8 mb-8 shadow-lg">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->nama }}!</h1>
            <p class="text-blue-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>
        <div class="bg-purple-500 text-white px-6 py-3 rounded-xl font-bold text-lg">
            KEPALA SEKOLAH
        </div>
    </div>
</div>

<div class="mb-8">
    <p class="text-gray-600">KPI dan analisis strategis SPMB.</p>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-blue-100 text-blue-600 rounded-xl w-14 h-14 flex items-center justify-center">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Target</span>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Pencapaian Kuota</h3>
        @php $kuotaTotal = $perJurusan->sum(function($j) { return $j->jurusan->kuota ?? 100; }); @endphp
        <p class="text-4xl font-bold text-gray-900">{{ number_format(($stats['total_pendaftar']/$kuotaTotal)*100, 1) }}%</p>
        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_pendaftar'] }}/{{ $kuotaTotal }} siswa</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-green-100 text-green-600 rounded-xl w-14 h-14 flex items-center justify-center">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">Quality</span>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Rasio Terverifikasi</h3>
        <p class="text-4xl font-bold text-gray-900">{{ $stats['submit'] > 0 ? number_format(($stats['terverifikasi']/$stats['submit'])*100, 1) : 0 }}%</p>
        <p class="text-xs text-gray-500 mt-1">{{ $stats['terverifikasi'] }}/{{ $stats['submit'] }} diverifikasi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-yellow-100 text-yellow-600 rounded-xl w-14 h-14 flex items-center justify-center">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
            </div>
            <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">Today</span>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Pendaftar Hari Ini</h3>
        @php $hariIni = \App\Models\Pendaftar::whereDate('created_at', today())->count(); @endphp
        <p class="text-4xl font-bold text-gray-900">{{ $hariIni }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-purple-100 text-purple-600 rounded-xl w-14 h-14 flex items-center justify-center">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm8 8a1 1 0 100-2h1a1 1 0 100 2h-1z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">Revenue</span>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Potensi Pendapatan</h3>
        @php $totalPendapatan = $perGelombang->sum(function($g) { return $g->total * ($g->gelombang->biaya_daftar ?? 500000); }); @endphp
        <p class="text-4xl font-bold text-gray-900">{{ number_format($totalPendapatan/1000000, 1) }}M</p>
        <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Tren Harian -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Tren Pendaftaran 7 Hari Terakhir</h3>
    @php
    $tren = [];
    for($i = 6; $i >= 0; $i--) {
        $tanggal = \Carbon\Carbon::now()->subDays($i);
        $jumlah = \App\Models\Pendaftar::whereDate('created_at', $tanggal)->count();
        $tren[] = ['tanggal' => $tanggal->format('d/m'), 'jumlah' => $jumlah];
    }
    $maxTren = max(array_column($tren, 'jumlah')) ?: 1;
    @endphp
    <div class="flex items-end justify-between space-x-4 h-48">
        @foreach($tren as $data)
        <div class="flex-1 flex flex-col items-center justify-end h-full">
            <div class="text-lg font-bold text-blue-600 mb-2">{{ $data['jumlah'] }}</div>
            <div class="bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg w-full transition-all hover:from-blue-600 hover:to-blue-500" style="height: {{ $data['jumlah'] > 0 ? max(20, ($data['jumlah']/$maxTren)*100) : 5 }}%"></div>
            <div class="text-sm font-semibold text-gray-700 mt-3">{{ $data['tanggal'] }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Komposisi Asal Sekolah -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Top 5 Asal Sekolah</h3>
        @php
        $asalSekolah = \App\Models\PendaftarAsalSekolah::select('nama_sekolah', \DB::raw('count(*) as total'))
            ->groupBy('nama_sekolah')->orderBy('total', 'desc')->limit(5)->get();
        @endphp
        <div class="space-y-3">
            @foreach($asalSekolah as $sekolah)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <span class="font-medium text-gray-800">{{ $sekolah->nama_sekolah }}</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold text-sm">{{ $sekolah->total }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Sebaran Wilayah</h3>
        @php
        $wilayah = \App\Models\PendaftarDataSiswa::select('kota', \DB::raw('count(*) as total'))
            ->whereNotNull('kota')->groupBy('kota')->orderBy('total', 'desc')->limit(5)->get();
        @endphp
        <div class="space-y-3">
            @foreach($wilayah as $w)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <span class="font-medium text-gray-800">{{ $w->kota }}</span>
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold text-sm">{{ $w->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Status Overview -->
<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Status Pendaftaran Overview</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-2xl font-bold text-gray-700">{{ $stats['draft'] }}</div>
            <div class="text-sm text-gray-600">Draft</div>
        </div>
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-2xl font-bold text-blue-700">{{ $stats['submit'] }}</div>
            <div class="text-sm text-blue-600">Submit</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-2xl font-bold text-green-700">{{ $stats['terverifikasi'] }}</div>
            <div class="text-sm text-green-600">Terverifikasi</div>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-2xl font-bold text-yellow-700">{{ $stats['terbayar'] }}</div>
            <div class="text-sm text-yellow-600">Terbayar</div>
        </div>
        <div class="text-center p-4 bg-purple-50 rounded-lg">
            <div class="text-2xl font-bold text-purple-700">{{ $stats['lulus'] }}</div>
            <div class="text-sm text-purple-600">Lulus</div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection