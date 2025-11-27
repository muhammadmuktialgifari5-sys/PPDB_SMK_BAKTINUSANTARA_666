<?php

namespace App\Http\Controllers;

use App\Models\PendaftarBerkas;
use App\Models\Pendaftar;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function upload(Request $request, $pendaftarId)
    {
        $request->validate([
            'jenis' => 'required|in:PAS_FOTO,IJAZAH,RAPOR,KIP,KKS,AKTA,KK',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Cek apakah berkas jenis ini sudah diupload
        $exists = PendaftarBerkas::where('pendaftar_id', $pendaftarId)
            ->where('jenis', $request->jenis)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Berkas ' . $request->jenis . ' sudah diupload sebelumnya');
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('berkas', $filename, 'public');

        PendaftarBerkas::create([
            'pendaftar_id' => $pendaftarId,
            'jenis' => $request->jenis,
            'nama_file' => $file->getClientOriginalName(),
            'url' => $path,
            'ukuran_kb' => round($file->getSize() / 1024)
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'UPLOAD_BERKAS',
            'deskripsi' => "Upload berkas {$request->jenis} untuk pendaftar {$pendaftarId}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Berkas ' . $request->jenis . ' berhasil diupload');
    }

    public function skip(Request $request, $pendaftarId)
    {
        $jenis = $request->jenis;
        
        // Hanya KIP dan KKS yang bisa dilewati
        if (!in_array($jenis, ['KIP', 'KKS'])) {
            return response()->json(['success' => false, 'message' => 'Berkas ini wajib diupload']);
        }

        // Tandai sebagai dilewati dengan membuat record kosong
        PendaftarBerkas::create([
            'pendaftar_id' => $pendaftarId,
            'jenis' => $jenis,
            'nama_file' => 'DILEWATI',
            'url' => null,
            'ukuran_kb' => 0
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'SKIP_BERKAS',
            'deskripsi' => "Melewati upload berkas {$jenis} untuk pendaftar {$pendaftarId}",
            'ip_address' => $request->ip()
        ]);

        return response()->json(['success' => true]);
    }

    public function verifikasi(Request $request, $berkasId)
    {
        $berkas = PendaftarBerkas::findOrFail($berkasId);
        $berkas->update([
            'valid' => $request->valid,
            'catatan' => $request->catatan
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'VERIFIKASI_BERKAS',
            'deskripsi' => "Verifikasi berkas ID {$berkasId}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Berkas berhasil diverifikasi');
    }
}
