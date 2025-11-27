@extends('layouts.app')

@section('title', 'Dashboard Keuangan')

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
                    <h3 class="text-white font-bold text-lg">Menu Keuangan</h3>
                    <p class="text-blue-200 text-xs">Navigasi Cepat</p>
                </div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-white bg-opacity-20 font-semibold transition hover:bg-opacity-30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                    <span>Pembayaran</span>
                </a>
                <a href="{{ route('laporan.pendaftar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    <span>Data Pendaftar</span>
                </a>
                <a href="{{ route('laporan.keuangan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                    <span>Laporan</span>
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
        <div class="bg-green-500 text-white px-6 py-3 rounded-xl font-bold text-lg">
            KEUANGAN
        </div>
    </div>
</div>

<div class="mb-8">
    <p class="text-gray-600">Berikut ringkasan data pembayaran.</p>
    
    @if($stats['pembayaran_pending'] > 0)
    <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">URGENT: {{ $stats['pembayaran_pending'] }} pembayaran perlu diverifikasi segera!</span>
            <a href="{{ route('pembayaran.index', ['status' => 'PENDING']) }}" class="ml-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Verifikasi Sekarang</a>
        </div>
    </div>
    @endif
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Pendaftar -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-100 text-blue-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Pendaftar</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['total_pendaftar'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Yang perlu bayar: {{ $stats['total_pendaftar'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2"></div>
    </div>

    <!-- Sudah Bayar -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-100 text-green-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">Paid</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Sudah Bayar</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['terbayar'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Menunggu verifikasi</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2"></div>
    </div>

    <!-- Pembayaran Pending -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover {{ $stats['pembayaran_pending'] > 0 ? 'ring-2 ring-red-400 animate-pulse' : '' }}">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-100 text-red-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">{{ $stats['pembayaran_pending'] > 0 ? 'URGENT' : 'Clear' }}</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Menunggu Verifikasi</h3>
            <p class="text-4xl font-bold {{ $stats['pembayaran_pending'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $stats['pembayaran_pending'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Pembayaran pending</p>
        </div>
        <div class="bg-gradient-to-r {{ $stats['pembayaran_pending'] > 0 ? 'from-red-500 to-red-600' : 'from-gray-400 to-gray-500' }} h-2"></div>
    </div>

    <!-- Belum Bayar -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-yellow-100 text-yellow-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">Unpaid</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Belum Bayar</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['total_pendaftar'] - $stats['terbayar'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Perlu follow up</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2"></div>
    </div>

    <!-- Total Pendapatan -->
    @php
    $totalPendapatan = 0;
    foreach($perGelombang as $g) {
        $totalPendapatan += $g->total * $g->gelombang->biaya_daftar;
    }
    @endphp
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-100 text-purple-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/></svg>
                </div>
                <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">Revenue</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Potensi Pendapatan</h3>
            <p class="text-4xl font-bold text-gray-900">{{ number_format($totalPendapatan / 1000000, 1) }}M</p>
            <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2"></div>
    </div>
</div>

<!-- Status Pembayaran -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Status Pembayaran per Gelombang</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($perGelombang as $g)
        <div class="border rounded-lg p-4">
            <h4 class="font-bold text-lg mb-2">{{ $g->gelombang->nama }}</h4>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Total Pendaftar:</span>
                    <span class="font-semibold">{{ $g->total }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya per Siswa:</span>
                    <span class="font-semibold">Rp {{ number_format($g->gelombang->biaya_daftar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span>Total Potensi:</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($g->total * $g->gelombang->biaya_daftar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Data Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Per Jurusan -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/></svg>
                Pendaftar Per Jurusan
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Jurusan</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perJurusan as $j)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-800">{{ $j->jurusan->nama }}</td>
                            <td class="py-3 px-4 text-right">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold text-sm">{{ $j->total }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Per Gelombang -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                Pendaftar Per Gelombang
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Gelombang</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perGelombang as $g)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-800">{{ $g->gelombang->nama }}</td>
                            <td class="py-3 px-4 text-right">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold text-sm">{{ $g->total }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Data Pembayaran -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Data Pembayaran Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">No. Pendaftaran</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Nama</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Jurusan</th>
                    <th class="text-right py-3 px-4 font-semibold text-gray-700">Nominal</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-700">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                </tr>
            </thead>
            <tbody>

                @forelse($pembayaranList as $pembayaran)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-800 font-medium">{{ $pembayaran->pendaftar->no_pendaftaran }}</td>
                    <td class="py-3 px-4 text-gray-800">{{ $pembayaran->pendaftar->dataSiswa->nama ?? '-' }}</td>
                    <td class="py-3 px-4 text-gray-800">{{ $pembayaran->pendaftar->jurusan->nama ?? '-' }}</td>
                    <td class="py-3 px-4 text-right text-gray-800 font-semibold">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        @if($pembayaran->status == 'PENDING')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                        @elseif($pembayaran->status == 'VERIFIED')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Verified</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center text-gray-600 text-sm">{{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 10-2 0v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/></svg>
                            <p>Belum ada data pembayaran</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembayaranList->count() > 0)
    <div class="mt-4 text-center">
        <a href="{{ route('pembayaran.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Lihat Semua Pembayaran →</a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
        Menu Cepat Keuangan
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-xl transition transform hover:scale-105">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-bold text-lg">Verifikasi Pembayaran</p>
                <p class="text-sm text-green-100">Kelola bukti pembayaran</p>
            </div>
        </a>
        <a href="{{ route('laporan.keuangan') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:shadow-xl transition transform hover:scale-105">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm3 2v10h10V6H5zm2 2h6v2H7V8zm0 4h6v2H7v-2z"/></svg>
            </div>
            <div>
                <p class="font-bold text-lg">Laporan Keuangan</p>
                <p class="text-sm text-blue-100">Lihat laporan pembayaran</p>
            </div>
        </a>
    </div>
</div>
    </div>
</div>
@endsection