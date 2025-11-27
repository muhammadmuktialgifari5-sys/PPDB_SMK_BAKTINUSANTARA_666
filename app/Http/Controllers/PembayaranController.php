<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftar;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function showPembayaran($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran'])->findOrFail($id);
        return view('pendaftaran.pembayaran', compact('pendaftar'));
    }

    public function index(Request $request)
    {
        $query = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $pembayaran = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('pembayaran.index', compact('pembayaran'));
    }
    public function upload(Request $request, $pendaftarId)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
            'rekening_tujuan' => 'required|string',
            'bukti_bayar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $pendaftar = Pendaftar::findOrFail($pendaftarId);
        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pembayaran', $filename, 'public');

        Pembayaran::updateOrCreate(
            ['pendaftar_id' => $pendaftarId],
            [
                'nominal' => $request->nominal,
                'metode_pembayaran' => $request->rekening_tujuan,
                'bukti_bayar' => $path,
                'status' => 'PENDING'
            ]
        );

        $pendaftar->update(['status' => 'PAID']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'UPLOAD_BUKTI_BAYAR',
            'deskripsi' => "Upload bukti bayar untuk pendaftar {$pendaftarId}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    public function verifikasi(Request $request, $pembayaranId)
    {
        $pembayaran = Pembayaran::findOrFail($pembayaranId);
        $pembayaran->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        // Update status pendaftar berdasarkan status pembayaran
        if ($request->status == 'VERIFIED') {
            $pembayaran->pendaftar->update([
                'status' => 'PAYMENT_VERIFIED',
                'user_verifikasi_payment' => Auth::user()->nama,
                'tgl_verifikasi_payment' => now()
            ]);
        } elseif ($request->status == 'REJECTED') {
            // Jika pembayaran ditolak, kembalikan ke status sebelumnya
            $pembayaran->pendaftar->update([
                'status' => 'ADM_PASS',
                'user_verifikasi_payment' => null,
                'tgl_verifikasi_payment' => null
            ]);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'VERIFIKASI_PEMBAYARAN',
            'deskripsi' => "Verifikasi pembayaran ID {$pembayaranId} - Status: {$request->status}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    private function parseNominal($nominal)
    {
        // Remove Rp, spaces, dots, and commas, keep only numbers
        $cleaned = preg_replace('/[^0-9]/', '', $nominal);
        return (int) $cleaned;
    }

    private function formatNominal($nominal)
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}
