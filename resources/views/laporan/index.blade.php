@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Laporan</h2>
    
    <!-- Quick Stats -->
    @php
    $totalPendaftar = \App\Models\Pendaftar::count();
    $lulusVerifikasi = \App\Models\Pendaftar::where('status', 'ADM_PASS')->count();
    $sudahBayar = \App\Models\Pendaftar::whereIn('status', ['PAID', 'PAYMENT_VERIFIED'])->count();
    $diterima = \App\Models\Pendaftar::where('status', 'LULUS')->count();
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $totalPendaftar }}</div>
            <div class="text-sm text-blue-600">Total Pendaftar</div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $lulusVerifikasi }}</div>
            <div class="text-sm text-green-600">Lulus Verifikasi</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-yellow-600">{{ $sudahBayar }}</div>
            <div class="text-sm text-yellow-600">Sudah Bayar</div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $diterima }}</div>
            <div class="text-sm text-purple-600">Diterima</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Laporan Pendaftar -->
        <div class="border rounded-lg p-6 hover:shadow-lg transition bg-gradient-to-br from-blue-50 to-blue-100">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Laporan Pendaftar</h3>
                    <p class="text-gray-600 text-sm">Data lengkap semua pendaftar</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('laporan.pendaftar') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition">
                    Lihat Laporan
                </a>
                <a href="{{ route('laporan.export.excel') }}" class="block w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 transition">
                    Export Excel
                </a>
            </div>
        </div>

        <!-- Laporan Keuangan -->
        @if(auth()->user()->role == 'keuangan' || auth()->user()->role == 'admin' || auth()->user()->role == 'kepsek')
        <div class="border rounded-lg p-6 hover:shadow-lg transition bg-gradient-to-br from-green-50 to-green-100">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 text-green-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Laporan Keuangan</h3>
                    <p class="text-gray-600 text-sm">Rekap pembayaran pendaftaran</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('laporan.keuangan') }}" class="block w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 transition">
                    Lihat Laporan
                </a>
            </div>
        </div>
        @endif
        
        <!-- Laporan Verifikasi -->
        @if(auth()->user()->role == 'verifikator_adm' || auth()->user()->role == 'admin')
        <div class="border rounded-lg p-6 hover:shadow-lg transition bg-gradient-to-br from-orange-50 to-orange-100">
            <div class="flex items-center mb-4">
                <div class="bg-orange-100 text-orange-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Laporan Verifikasi</h3>
                    <p class="text-gray-600 text-sm">Status verifikasi administrasi</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('verifikasi.index') }}" class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition">
                    Lihat Data Verifikasi
                </a>
            </div>
        </div>
        @endif

        <!-- Dashboard Statistik -->
        <div class="border rounded-lg p-6 hover:shadow-lg transition bg-gradient-to-br from-purple-50 to-purple-100">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 text-purple-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Dashboard Statistik</h3>
                    <p class="text-gray-600 text-sm">Ringkasan dan grafik data</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block w-full bg-purple-600 text-white text-center py-2 rounded hover:bg-purple-700 transition">
                    Lihat Dashboard
                </a>
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('peta') }}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded hover:bg-indigo-700 transition">
                    Peta Sebaran
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection