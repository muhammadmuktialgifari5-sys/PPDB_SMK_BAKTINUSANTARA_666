<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran', 'dataOrtu', 'asalSekolah', 'berkas']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['SUBMIT', 'PAID', 'ADM_PASS', 'ADM_REJECT', 'PAYMENT_VERIFIED']);
        }
        
        if ($request->gelombang) {
            $query->where('gelombang_id', $request->gelombang);
        }
        
        if ($request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('dataSiswa', function($subq) use ($request) {
                    $subq->where('nama', 'like', '%' . $request->search . '%')
                         ->orWhere('nik', 'like', '%' . $request->search . '%');
                })->orWhere('no_pendaftaran', 'like', '%' . $request->search . '%');
            });
        }
        
        $pendaftar = $query->orderBy('tanggal_daftar', 'desc')->paginate(20);
        
        // Statistik untuk semua pendaftar
        $allPendaftar = Pendaftar::all();
        
        $jurusan = \App\Models\Jurusan::all();
        $gelombang = \App\Models\Gelombang::all();
        
        return view('verifikasi.index', compact('pendaftar', 'allPendaftar', 'jurusan', 'gelombang'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ADM_PASS,ADM_REJECT',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $pendaftar = Pendaftar::findOrFail($id);
        
        // Validasi status yang bisa diverifikasi
        if (!in_array($pendaftar->status, ['SUBMIT', 'PAID'])) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Hanya pendaftar dengan status SUBMIT atau PAID yang dapat diverifikasi'], 400);
            }
            return back()->with('error', 'Hanya pendaftar dengan status SUBMIT atau PAID yang dapat diverifikasi');
        }
        
        $pendaftar->update([
            'status' => $request->status,
            'user_verifikasi_adm' => Auth::user()->nama,
            'tgl_verifikasi_adm' => now(),
            'catatan_verifikasi_adm' => $request->catatan
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'VERIFIKASI_ADMINISTRASI',
            'deskripsi' => "Verifikasi administrasi pendaftar {$pendaftar->no_pendaftaran} dengan status {$request->status}" . ($request->catatan ? " - Catatan: {$request->catatan}" : ''),
            'ip_address' => $request->ip()
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Verifikasi berhasil disimpan untuk pendaftar ' . $pendaftar->no_pendaftaran]);
        }
        
        return back()->with('success', 'Verifikasi berhasil disimpan untuk pendaftar ' . $pendaftar->no_pendaftaran);
    }
    
    public function bulkVerifikasi(Request $request)
    {
        $request->validate([
            'pendaftar_ids' => 'required|array',
            'pendaftar_ids.*' => 'exists:pendaftar,id',
            'status' => 'required|in:ADM_PASS,ADM_REJECT',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $updated = 0;
        foreach ($request->pendaftar_ids as $id) {
            $pendaftar = Pendaftar::find($id);
            if ($pendaftar && in_array($pendaftar->status, ['SUBMIT', 'PAID'])) {
                $pendaftar->update([
                    'status' => $request->status,
                    'user_verifikasi_adm' => Auth::user()->nama,
                    'tgl_verifikasi_adm' => now(),
                    'catatan_verifikasi_adm' => $request->catatan
                ]);
                
                AuditLog::create([
                    'user_id' => Auth::id(),
                    'aksi' => 'VERIFIKASI_BULK',
                    'deskripsi' => "Bulk verifikasi pendaftar {$pendaftar->no_pendaftaran} dengan status {$request->status}",
                    'ip_address' => $request->ip()
                ]);
                
                $updated++;
            }
        }
        
        return back()->with('success', "Berhasil memverifikasi {$updated} pendaftar");
    }
    
    public function detail($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])->findOrFail($id);
        
        return response()->json([
            'dataSiswa' => $pendaftar->dataSiswa ?? [],
            'dataOrtu' => $pendaftar->dataOrtu ?? [],
            'asalSekolah' => $pendaftar->asalSekolah ?? [],
            'berkas' => $pendaftar->berkas ?? []
        ]);
    }
}
