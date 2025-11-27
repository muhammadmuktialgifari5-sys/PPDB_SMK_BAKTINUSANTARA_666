@extends('layouts.app')

@section('title', 'Pembayaran')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Upload Bukti Pembayaran</h2>

    <div class="mb-6">
        
        @if(in_array($pendaftar->status, ['ADM_PASS', 'PAID', 'PAYMENT_VERIFIED', 'LULUS']))
            @if(!$pendaftar->pembayaran)
                <form action="{{ route('pembayaran.upload', $pendaftar->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg">
                        <h3 class="font-bold text-lg mb-3 text-blue-900">Informasi Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-blue-800"><strong>Nominal:</strong> Rp {{ number_format($pendaftar->gelombang->biaya_daftar, 0, ',', '.') }}</p>
                            <p class="text-blue-800"><strong>Rekening Tujuan:</strong> BCA - 1234567890</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-bold text-lg mb-4 text-gray-800">Upload Bukti Pembayaran</h3>
                        <input type="file" name="bukti_bayar" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500 focus:outline-none" accept="image/*,application/pdf" required>
                        <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
                    </div>
                    
                    <input type="hidden" name="nominal" value="{{ $pendaftar->gelombang->biaya_daftar }}">
                    <input type="hidden" name="rekening_tujuan" value="BCA - 1234567890">
                    
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition">
                        Upload Bukti Pembayaran
                    </button>
                </form>
            @else
                <div class="bg-green-50 border border-green-200 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-green-800 mb-3">Bukti Pembayaran Sudah Diupload</h4>
                            <div class="space-y-2 text-sm mb-4">
                                <p><strong>Status:</strong> 
                                    @if($pendaftar->pembayaran->status == 'VERIFIED')
                                        <span class="text-green-600 font-semibold">✅ Terverifikasi</span>
                                    @elseif($pendaftar->pembayaran->status == 'REJECTED')
                                        <span class="text-red-600 font-semibold">❌ Ditolak</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">⏳ Menunggu Verifikasi</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="border-t pt-4">
                                <h5 class="font-semibold text-gray-700 mb-3">Nominal Pembayaran</h5>
                                <p class="text-gray-800 mb-4">Rp {{ number_format($pendaftar->pembayaran->nominal, 0, ',', '.') }}</p>
                                
                                <h5 class="font-semibold text-gray-700 mb-3">Rekening Tujuan</h5>
                                <p class="text-gray-800 mb-4">{{ $pendaftar->pembayaran->metode_pembayaran ?? '-' }}</p>
                                
                                <h5 class="font-semibold text-gray-700 mb-3">Bukti Pembayaran</h5>
                                @if($pendaftar->pembayaran->bukti_bayar)
                                <div class="border-2 border-gray-300 rounded-lg p-2 bg-white">
                                    @php
                                    $extension = pathinfo($pendaftar->pembayaran->bukti_bayar, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($pendaftar->pembayaran->bukti_bayar) }}" 
                                             alt="Bukti Pembayaran" 
                                             class="max-w-full h-auto rounded cursor-pointer hover:opacity-90 transition"
                                             onclick="window.open('{{ Storage::url($pendaftar->pembayaran->bukti_bayar) }}', '_blank')">
                                    @else
                                        <a href="{{ Storage::url($pendaftar->pembayaran->bukti_bayar) }}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="font-semibold">Klik untuk melihat bukti pembayaran (PDF)</span>
                                        </a>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk memperbesar</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-yellow-800">Pembayaran Belum Tersedia</h4>
                        <p class="text-yellow-700 text-sm">Silakan tunggu hingga pendaftaran Anda diverifikasi oleh admin terlebih dahulu.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('pendaftaran.show', $pendaftar->id) }}" class="bg-gray-600 text-white px-4 py-2 rounded inline-block">Kembali ke Detail Pendaftaran</a>
    </div>
</div>
@endsection
