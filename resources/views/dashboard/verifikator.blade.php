@extends('layouts.app')

@section('title', 'Dashboard Verifikator')

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
                    <h3 class="text-white font-bold text-lg">Menu Verifikator</h3>
                    <p class="text-blue-200 text-xs">Navigasi Cepat</p>
                </div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-white bg-opacity-20 font-semibold transition hover:bg-opacity-30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Verifikasi</span>
                </a>
                <a href="{{ route('laporan.pendaftar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    <span>Data Pendaftar</span>
                </a>
                <a href="{{ route('laporan.pendaftar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-white hover:bg-opacity-10 transition">
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
        <div class="bg-orange-500 text-white px-6 py-3 rounded-xl font-bold text-lg">
            VERIFIKATOR
        </div>
    </div>
</div>

<div class="mb-8">
    <p class="text-gray-600">Berikut ringkasan data verifikasi.</p>
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
            <p class="text-xs text-gray-500 mt-1">Draft: {{ $stats['draft'] }} | Submit: {{ $stats['submit'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2"></div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-yellow-100 text-yellow-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">Pending</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Menunggu Verifikasi</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['submit'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Perlu diverifikasi</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2"></div>
    </div>

    <!-- Terverifikasi -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-100 text-green-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">Verified</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Lulus Verifikasi</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['terverifikasi'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Sudah diverifikasi</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2"></div>
    </div>

    <!-- Ditolak -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-100 text-red-600 rounded-xl w-14 h-14 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">Rejected</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Ditolak</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $stats['ditolak'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Tidak lolos verifikasi</p>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 h-2"></div>
    </div>
</div>

<!-- Status Overview -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Progress Verifikasi</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-3xl font-bold text-yellow-700">{{ $stats['submit'] }}</div>
            <div class="text-sm text-yellow-600">Menunggu Verifikasi</div>
            <div class="w-full bg-yellow-200 rounded-full h-2 mt-2">
                <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $stats['total_pendaftar'] > 0 ? ($stats['submit'] / $stats['total_pendaftar']) * 100 : 0 }}%"></div>
            </div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-3xl font-bold text-green-700">{{ $stats['terverifikasi'] }}</div>
            <div class="text-sm text-green-600">Lulus Verifikasi</div>
            <div class="w-full bg-green-200 rounded-full h-2 mt-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['total_pendaftar'] > 0 ? ($stats['terverifikasi'] / $stats['total_pendaftar']) * 100 : 0 }}%"></div>
            </div>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg">
            <div class="text-3xl font-bold text-red-700">{{ $stats['ditolak'] }}</div>
            <div class="text-sm text-red-600">Ditolak</div>
            <div class="w-full bg-red-200 rounded-full h-2 mt-2">
                <div class="bg-red-600 h-2 rounded-full" style="width: {{ $stats['total_pendaftar'] > 0 ? ($stats['ditolak'] / $stats['total_pendaftar']) * 100 : 0 }}%"></div>
            </div>
        </div>
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

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
        Menu Cepat Verifikator
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('verifikasi.index') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:shadow-xl transition transform hover:scale-105">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-bold text-lg">Verifikasi Administrasi</p>
                <p class="text-sm text-orange-100">Verifikasi data pendaftar</p>
            </div>
        </a>
        <a href="{{ route('laporan.pendaftar') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:shadow-xl transition transform hover:scale-105">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
            </div>
            <div>
                <p class="font-bold text-lg">Data Pendaftar</p>
                <p class="text-sm text-blue-100">Lihat data pendaftar</p>
            </div>
        </a>
    </div>
</div>
    </div>
</div>
@endsection