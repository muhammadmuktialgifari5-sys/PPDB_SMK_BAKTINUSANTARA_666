<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function pendaftar(Request $request)
    {
        $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang']);

        if ($request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        if ($request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tanggal_daftar', 'desc')->get();
        $jurusan = \App\Models\Jurusan::all();
        $gelombang = \App\Models\Gelombang::all();

        return view('laporan.pendaftar', compact('data', 'jurusan', 'gelombang'));
    }

    public function exportExcel(Request $request)
    {
        $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang']);

        if ($request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        if ($request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tanggal_daftar', 'desc')->get();
        
        return $this->downloadExcel($data);
    }

    public function keuangan(Request $request)
    {
        $query = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.gelombang', 'pendaftar.jurusan']);
        
        // Filter by status if specified, otherwise show all
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->gelombang_id) {
            $query->whereHas('pendaftar', function($q) use ($request) {
                $q->where('gelombang_id', $request->gelombang_id);
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();
        $total = $data->sum('nominal');
        $gelombang = \App\Models\Gelombang::all();

        return view('laporan.keuangan', compact('data', 'total', 'gelombang'));
    }

    private function downloadExcel($data)
    {
        $filename = 'laporan_pendaftar_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'No. Pendaftaran',
                'Nama',
                'NIK',
                'Jurusan',
                'Gelombang',
                'Status',
                'Tanggal Daftar'
            ]);
            
            // Data rows
            foreach ($data as $index => $pendaftar) {
                fputcsv($file, [
                    $index + 1,
                    $pendaftar->no_pendaftaran,
                    $pendaftar->dataSiswa->nama ?? '-',
                    $pendaftar->dataSiswa->nik ?? '-',
                    $pendaftar->jurusan->nama ?? '-',
                    $pendaftar->gelombang->nama ?? '-',
                    $pendaftar->status,
                    $pendaftar->tanggal_daftar->format('d/m/Y')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
