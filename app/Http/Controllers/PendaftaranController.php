<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarAsalSekolah;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function create()
    {
        // Cek apakah user sudah pernah mendaftar
        $existingPendaftar = Pendaftar::where('user_id', Auth::id())->first();
        
        if ($existingPendaftar) {
            return redirect()->route('pendaftaran.show', $existingPendaftar->id)
                ->with('info', 'Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali.');
        }
        
        $gelombang = Gelombang::orderBy('nama')->get();
        $jurusan = Jurusan::all();
        return view('pendaftaran.create', compact('gelombang', 'jurusan'));
    }

    public function store(Request $request)
    {
        // Cek apakah user sudah pernah mendaftar
        $existingPendaftar = Pendaftar::where('user_id', Auth::id())->first();
        
        if ($existingPendaftar) {
            return redirect()->route('pendaftaran.show', $existingPendaftar->id)
                ->with('error', 'Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali.');
        }
        
        $request->validate([
            'gelombang_id' => 'required|exists:gelombang,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama' => 'required|max:120',
            'jk' => 'required|in:L,P',
            'tmp_lahir' => 'required|max:60',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
            'nama_sekolah' => 'required|max:150'
        ]);

        DB::beginTransaction();
        try {
            $noPendaftaran = 'REG' . date('Ymd') . str_pad(Pendaftar::count() + 1, 4, '0', STR_PAD_LEFT);

            $pendaftar = Pendaftar::create([
                'user_id' => Auth::id(),
                'tanggal_daftar' => now(),
                'no_pendaftaran' => $noPendaftaran,
                'gelombang_id' => $request->gelombang_id,
                'jurusan_id' => $request->jurusan_id,
                'status' => 'PAID' // Status PAID, menunggu verifikasi
            ]);

            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'kota' => explode('|', $request->kota)[0] ?? null,
                'wilayah_id' => $request->wilayah_id,
                'lat' => $request->lat,
                'lng' => $request->lng
            ]);

            PendaftarDataOrtu::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'hp_ayah' => $request->hp_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'hp_ibu' => $request->hp_ibu,
                'wali_nama' => $request->wali_nama,
                'wali_hp' => $request->wali_hp
            ]);

            PendaftarAsalSekolah::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_sekolah' => $request->nama_sekolah,
                'kabupaten' => $request->kabupaten,
                'nilai_rata' => $request->nilai_rata
            ]);

            // Buat record pembayaran dengan status PENDING
            $gelombang = Gelombang::find($request->gelombang_id);
            \App\Models\Pembayaran::create([
                'pendaftar_id' => $pendaftar->id,
                'nominal' => $gelombang->biaya_daftar ?? 500000,
                'status' => 'PENDING', // Menunggu verifikasi keuangan
                'tanggal_bayar' => now()
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'CREATE_PENDAFTARAN',
                'deskripsi' => "Membuat pendaftaran {$noPendaftaran}",
                'ip_address' => $request->ip()
            ]);

            DB::commit();
            return redirect()->route('pendaftaran.show', $pendaftar->id)->with('success', 'Pendaftaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'gelombang', 'jurusan', 'berkas', 'pembayaran'])->findOrFail($id);
        
        // Sync payment status before showing
        $pendaftar->syncPaymentStatus();
        $pendaftar = $pendaftar->fresh(['dataSiswa', 'dataOrtu', 'asalSekolah', 'gelombang', 'jurusan', 'berkas', 'pembayaran']);
        
        return view('pendaftaran.show', compact('pendaftar'));
    }
}
