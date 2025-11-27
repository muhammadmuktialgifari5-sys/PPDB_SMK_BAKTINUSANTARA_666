@extends('layouts.app')

@section('title', 'Laporan Pendaftar')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Laporan Pendaftar</h2>
        <div class="flex gap-2">
            <a href="{{ route('laporan.export.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Export Excel
            </a>
        </div>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-6 p-4 bg-gray-50 rounded">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                    <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gelombang</label>
                <select name="gelombang_id" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Gelombang</option>
                    @foreach($gelombang as $g)
                    <option value="{{ $g->id }}" {{ request('gelombang_id') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                    <option value="SUBMIT" {{ request('status') == 'SUBMIT' ? 'selected' : '' }}>Submit</option>
                    <option value="ADM_PASS" {{ request('status') == 'ADM_PASS' ? 'selected' : '' }}>Lulus Verifikasi</option>
                    <option value="ADM_REJECT" {{ request('status') == 'ADM_REJECT' ? 'selected' : '' }}>Ditolak</option>
                    <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="PAYMENT_VERIFIED" {{ request('status') == 'PAYMENT_VERIFIED' ? 'selected' : '' }}>Pembayaran Terverifikasi</option>
                    <option value="LULUS" {{ request('status') == 'LULUS' ? 'selected' : '' }}>Diterima</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
                    Filter
                </button>
                <a href="{{ route('laporan.pendaftar') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </div>
    </form>
    
    <!-- Summary Stats -->
    <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 p-3 rounded text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $data->count() }}</div>
            <div class="text-sm text-blue-600">Total Data</div>
        </div>
        <div class="bg-green-50 p-3 rounded text-center">
            <div class="text-2xl font-bold text-green-600">{{ $data->where('status', 'ADM_PASS')->count() }}</div>
            <div class="text-sm text-green-600">Lulus Verifikasi</div>
        </div>
        <div class="bg-yellow-50 p-3 rounded text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $data->where('status', 'PAID')->count() }}</div>
            <div class="text-sm text-yellow-600">Sudah Bayar</div>
        </div>
        <div class="bg-purple-50 p-3 rounded text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $data->where('status', 'LULUS')->count() }}</div>
            <div class="text-sm text-purple-600">Diterima</div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">No. Pendaftaran</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Jurusan</th>
                    <th class="border p-2">Gelombang</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $pendaftar)
                <tr>
                    <td class="border p-2">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $pendaftar->no_pendaftaran }}</td>
                    <td class="border p-2">{{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $pendaftar->jurusan->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $pendaftar->gelombang->nama ?? '-' }}</td>
                    <td class="border p-2">
                        @php
                        $statusColors = [
                            'DRAFT' => 'bg-gray-100 text-gray-800',
                            'SUBMIT' => 'bg-yellow-100 text-yellow-800',
                            'ADM_PASS' => 'bg-green-100 text-green-800',
                            'ADM_REJECT' => 'bg-red-100 text-red-800',
                            'PAID' => 'bg-blue-100 text-blue-800',
                            'PAYMENT_VERIFIED' => 'bg-purple-100 text-purple-800',
                            'LULUS' => 'bg-green-200 text-green-900'
                        ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $statusColors[$pendaftar->status] ?? 'bg-gray-100' }}">
                            {{ $pendaftar->status }}
                        </span>
                    </td>
                    <td class="border p-2">{{ $pendaftar->tanggal_daftar->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($data->isEmpty())
    <div class="text-center py-8 text-gray-500">
        Tidak ada data pendaftar
    </div>
    @endif
</div>
@endsection