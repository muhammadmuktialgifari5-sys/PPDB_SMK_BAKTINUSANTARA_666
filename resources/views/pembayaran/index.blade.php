@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Verifikasi Pembayaran</h2>
        <div class="text-sm text-gray-600">
            Total: {{ $pembayaran->total() }} pembayaran
        </div>
    </div>
    
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    @php
        $pendingCount = $pembayaran->where('status', 'PENDING')->count();
    @endphp
    @if($pendingCount > 0 && (!request('status') || request('status') == 'PENDING'))
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    <strong>Perhatian!</strong> Ada <strong>{{ $pendingCount }}</strong> pembayaran yang menunggu verifikasi. 
                    Segera verifikasi untuk memproses pendaftaran siswa.
                </p>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Filter Status -->
    <div class="mb-4 flex flex-wrap gap-2">
        <span class="text-sm font-medium text-gray-700">Filter Status:</span>
        <a href="{{ route('pembayaran.index') }}" class="px-3 py-1 rounded text-sm {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Semua</a>
        <a href="{{ route('pembayaran.index', ['status' => 'PENDING']) }}" class="px-3 py-1 rounded text-sm {{ request('status') == 'PENDING' ? 'bg-yellow-600 text-white' : 'bg-gray-200' }}">Menunggu Verifikasi</a>
        <a href="{{ route('pembayaran.index', ['status' => 'VERIFIED']) }}" class="px-3 py-1 rounded text-sm {{ request('status') == 'VERIFIED' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">Terverifikasi</a>
        <a href="{{ route('pembayaran.index', ['status' => 'REJECTED']) }}" class="px-3 py-1 rounded text-sm {{ request('status') == 'REJECTED' ? 'bg-red-600 text-white' : 'bg-gray-200' }}">Ditolak</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No. Pendaftaran</th>
                    <th class="border p-2">Nama Siswa</th>
                    <th class="border p-2">Jurusan</th>
                    <th class="border p-2">Gelombang</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Tanggal Upload</th>
                    <th class="border p-2">Bukti Bayar</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaran as $p)
                <tr class="{{ $p->status == 'PENDING' ? 'bg-yellow-50' : '' }}">
                    <td class="border p-2 font-medium">{{ $p->pendaftar->no_pendaftaran }}</td>
                    <td class="border p-2">{{ $p->pendaftar->dataSiswa->nama }}</td>
                    <td class="border p-2">{{ $p->pendaftar->jurusan->nama }}</td>
                    <td class="border p-2">{{ $p->pendaftar->gelombang->nama }}</td>
                    <td class="border p-2 text-green-600 font-medium">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                    <td class="border p-2 text-sm">
                        <div>{{ $p->created_at->format('d/m/Y H:i') }}</div>
                        <div class="text-xs text-gray-500">{{ $p->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="border p-2">
                        @if($p->bukti_bayar)
                        <a href="{{ Storage::url($p->bukti_bayar) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
                        @else
                        <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        @php
                        $statusColors = [
                            'PENDING' => 'bg-yellow-100 text-yellow-800 animate-pulse',
                            'VERIFIED' => 'bg-green-100 text-green-800',
                            'REJECTED' => 'bg-red-100 text-red-800'
                        ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $statusColors[$p->status] ?? 'bg-gray-100' }}">{{ $p->status }}</span>
                    </td>
                    <td class="border p-2">
                        @if($p->status == 'PENDING')
                        <form action="{{ route('pembayaran.verifikasi', $p->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <select name="status" class="border px-2 py-1 rounded text-xs w-full">
                                <option value="VERIFIED">Terima</option>
                                <option value="REJECTED">Tolak</option>
                            </select>
                            <textarea name="catatan" placeholder="Catatan (opsional)" class="border px-2 py-1 rounded text-xs w-full" rows="2"></textarea>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs w-full">Verifikasi</button>
                        </form>
                        @else
                        <span class="text-gray-500 text-xs">Sudah diverifikasi</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pembayaran->appends(request()->query())->links() }}
    </div>
</div>
@endsection