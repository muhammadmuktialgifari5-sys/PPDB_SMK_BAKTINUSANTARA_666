<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Wilayah;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasterDataController extends Controller
{
    public function jurusan()
    {
        $jurusan = Jurusan::all();
        return view('master.jurusan', compact('jurusan'));
    }

    public function storeJurusan(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jurusan,kode',
            'nama' => 'required',
            'kuota' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['kode', 'nama', 'kuota']);
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('jurusan', $filename, 'public');
            $data['gambar'] = $path;
        }

        Jurusan::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'CREATE_JURUSAN',
            'deskripsi' => "Membuat jurusan {$request->nama}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function gelombang()
    {
        $gelombang = Gelombang::all();
        return view('master.gelombang', compact('gelombang'));
    }

    public function storeGelombang(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tahun' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'biaya_daftar' => 'required|numeric'
        ]);

        Gelombang::create($request->all());

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'CREATE_GELOMBANG',
            'deskripsi' => "Membuat gelombang {$request->nama}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Gelombang berhasil ditambahkan');
    }
}
