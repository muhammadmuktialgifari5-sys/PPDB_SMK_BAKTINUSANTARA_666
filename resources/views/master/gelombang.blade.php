@extends('layouts.app')

@section('title', 'Master Gelombang')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Master Gelombang</h2>
    
    <form action="{{ route('master.gelombang.store') }}" method="POST" class="mb-6 border p-4 rounded">
        @csrf
        <h3 class="font-bold mb-3">Tambah Gelombang</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-2">Nama Gelombang</label>
                <input type="text" name="nama" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Tahun</label>
                <input type="number" name="tahun" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block mb-2">Biaya Pendaftaran</label>
                <input type="number" name="biaya_daftar" class="w-full border px-3 py-2 rounded" required>
            </div>
        </div>
        <button type="submit" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>

    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Tahun</th>
                <th class="border p-2">Periode</th>
                <th class="border p-2">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gelombang as $g)
            <tr>
                <td class="border p-2">{{ $g->nama }}</td>
                <td class="border p-2">{{ $g->tahun }}</td>
                <td class="border p-2">{{ $g->tgl_mulai->format('d/m/Y') }} - {{ $g->tgl_selesai->format('d/m/Y') }}</td>
                <td class="border p-2">Rp {{ number_format($g->biaya_daftar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
