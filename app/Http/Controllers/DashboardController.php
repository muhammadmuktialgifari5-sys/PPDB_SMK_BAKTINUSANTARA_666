<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'pendaftar') {
            $pendaftar = Pendaftar::where('user_id', $user->id)
                ->with(['dataSiswa', 'jurusan', 'gelombang', 'berkas', 'pembayaran'])
                ->get();
            
            // Sync payment status for each pendaftar
            foreach ($pendaftar as $p) {
                $p->syncPaymentStatus();
            }
            
            // Refresh data after sync
            $pendaftar = $pendaftar->fresh();
            
            return view('dashboard.pendaftar', compact('pendaftar'));
        }

        $stats = [
            'total_pendaftar' => Pendaftar::count(),
            'submit' => Pendaftar::where('status', 'SUBMIT')->count(),
            'terverifikasi' => Pendaftar::where('status', 'ADM_PASS')->count(),
            'terbayar' => Pendaftar::whereIn('status', ['PAID', 'PAYMENT_VERIFIED'])->count(),
            'lulus' => Pendaftar::where('status', 'LULUS')->count(),
            'tidak_lulus' => Pendaftar::where('status', 'TIDAK_LULUS')->count(),
            'pembayaran_pending' => Pembayaran::where('status', 'PENDING')->count(),
            'ditolak' => Pendaftar::where('status', 'ADM_REJECT')->count(),
            'draft' => Pendaftar::where('status', 'DRAFT')->count()
        ];

        $perJurusan = Pendaftar::select('jurusan_id', DB::raw('count(*) as total'))
            ->groupBy('jurusan_id')
            ->with('jurusan')
            ->get();

        $perGelombang = Pendaftar::select('gelombang_id', DB::raw('count(*) as total'))
            ->groupBy('gelombang_id')
            ->with('gelombang')
            ->get();

        if ($user->role == 'kepsek') {
            return view('dashboard.eksekutif', compact('stats', 'perJurusan', 'perGelombang'));
        }
        
        if ($user->role == 'keuangan') {
            $pembayaranList = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            return view('dashboard.keuangan', compact('stats', 'perJurusan', 'perGelombang', 'pembayaranList'));
        }
        
        if ($user->role == 'verifikator_adm') {
            return view('dashboard.verifikator', compact('stats', 'perJurusan', 'perGelombang'));
        }

        return view('dashboard.admin', compact('stats', 'perJurusan', 'perGelombang'));
    }

    public function peta()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
            ->whereHas('dataSiswa', function($q) {
                $q->whereNotNull('lat')->whereNotNull('lng');
            })
            ->get();

        return view('dashboard.peta', compact('pendaftar'));
    }
}
