@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Laporan Keuangan</h2>
        <div class="text-lg font-semibold text-green-600">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </div>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-6 p-4 bg-gray-50 rounded">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="VERIFIED" {{ request('status') == 'VERIFIED' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gelombang</label>
                <select name="gelombang_id" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Gelombang</option>
                    @foreach($gelombang as $g)
                    <option value="{{ $g->id }}" {{ request('gelombang_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('laporan.keuangan') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </div>
    </form>
    
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">No. Pendaftaran</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Jurusan</th>
                    <th class="border p-2">Gelombang</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Metode</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $pembayaran)
                <tr>
                    <td class="border p-2">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $pembayaran->pendaftar->no_pendaftaran }}</td>
                    <td class="border p-2">{{ $pembayaran->pendaftar->dataSiswa->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $pembayaran->pendaftar->jurusan->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $pembayaran->pendaftar->gelombang->nama ?? '-' }}</td>
                    <td class="border p-2 text-green-600 font-semibold">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    <td class="border p-2">{{ $pembayaran->metode_pembayaran ?? 'Transfer Bank' }}</td>
                    <td class="border p-2">{{ $pembayaran->tanggal_bayar ?? $pembayaran->created_at->format('d/m/Y') }}</td>
                    <td class="border p-2">
                        @if($pembayaran->status == 'VERIFIED')
                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Terverifikasi</span>
                        @elseif($pembayaran->status == 'REJECTED')
                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                        @else
                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Menunggu</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($data->isEmpty())
    <div class="text-center py-8 text-gray-500">
        Tidak ada data pembayaran
    </div>
    @endif
    
    <!-- Summary Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-green-600">{{ $data->where('status', 'VERIFIED')->count() }}</div>
            <div class="text-sm text-green-600">Terverifikasi</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $data->where('status', 'PENDING')->count() }}</div>
            <div class="text-sm text-yellow-600">Menunggu</div>
        </div>
        <div class="bg-red-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-red-600">{{ $data->where('status', 'REJECTED')->count() }}</div>
            <div class="text-sm text-red-600">Ditolak</div>
        </div>
    </div>
</div>
@endsection