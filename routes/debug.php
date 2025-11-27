<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pendaftar;
use App\Models\Pembayaran;

Route::get('/debug/payment-status', function() {
    $pendaftar = Pendaftar::with(['pembayaran', 'dataSiswa'])->get();
    
    $html = '<h1>Debug Payment Status</h1>';
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    $html .= '<tr><th>No. Pendaftaran</th><th>Nama</th><th>Status Pendaftar</th><th>Status Pembayaran</th><th>Aksi</th></tr>';
    
    foreach ($pendaftar as $p) {
        $paymentStatus = $p->pembayaran ? $p->pembayaran->status : 'Belum ada';
        $bgColor = '';
        
        if ($p->pembayaran && $p->pembayaran->status == 'VERIFIED' && $p->status != 'PAYMENT_VERIFIED') {
            $bgColor = 'background-color: #ffcccc;'; // Red for mismatch
        } elseif ($p->status == 'PAYMENT_VERIFIED') {
            $bgColor = 'background-color: #ccffcc;'; // Green for correct
        }
        
        $html .= '<tr style="' . $bgColor . '">';
        $html .= '<td>' . $p->no_pendaftaran . '</td>';
        $html .= '<td>' . ($p->dataSiswa ? $p->dataSiswa->nama : 'N/A') . '</td>';
        $html .= '<td>' . $p->status . '</td>';
        $html .= '<td>' . $paymentStatus . '</td>';
        
        if ($p->pembayaran && $p->pembayaran->status == 'VERIFIED' && $p->status != 'PAYMENT_VERIFIED') {
            $html .= '<td><a href="/debug/fix-status/' . $p->id . '" style="color: red;">FIX NOW</a></td>';
        } else {
            $html .= '<td>OK</td>';
        }
        
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    return $html;
});

Route::get('/debug/fix-status/{id}', function($id) {
    $pendaftar = Pendaftar::findOrFail($id);
    
    if ($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'VERIFIED') {
        $pendaftar->update([
            'status' => 'PAYMENT_VERIFIED',
            'user_verifikasi_payment' => 'Debug Fix',
            'tgl_verifikasi_payment' => now()
        ]);
        
        return redirect('/debug/payment-status')->with('message', 'Status fixed for ' . $pendaftar->no_pendaftaran);
    }
    
    return redirect('/debug/payment-status')->with('message', 'No fix needed for ' . $pendaftar->no_pendaftaran);
});