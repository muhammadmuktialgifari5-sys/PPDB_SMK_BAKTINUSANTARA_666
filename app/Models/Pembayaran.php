<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['pendaftar_id', 'nominal', 'metode_pembayaran', 'tanggal_bayar', 'bukti_bayar', 'status', 'catatan'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
