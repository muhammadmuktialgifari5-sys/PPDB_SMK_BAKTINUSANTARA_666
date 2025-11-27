@extends('layouts.app')

@section('title', 'Master Jurusan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Master Jurusan</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-3 text-left">Gambar</th>
                    <th class="border border-gray-300 p-3 text-left">Kode</th>
                    <th class="border border-gray-300 p-3 text-left">Nama Jurusan</th>
                    <th class="border border-gray-300 p-3 text-left">Kuota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusan as $j)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">
                        @if($j->gambar)
                        <img src="{{ asset($j->gambar) }}" alt="{{ $j->nama }}" class="w-16 h-16 rounded object-cover">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @endif
                    </td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $j->kode }}</td>
                    <td class="border border-gray-300 p-3">{{ $j->nama }}</td>
                    <td class="border border-gray-300 p-3 text-center">{{ $j->kuota }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
