<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function kartu($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'gelombang', 'jurusan'])->findOrFail($id);
        return view('cetak.kartu', compact('pendaftar'));
    }

    public function buktiBayar($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'gelombang', 'jurusan', 'pembayaran'])->findOrFail($id);
        return view('cetak.bukti-bayar', compact('pendaftar'));
    }
}
