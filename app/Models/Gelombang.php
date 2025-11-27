<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    protected $table = 'gelombang';
    protected $fillable = ['nama', 'tahun', 'tgl_mulai', 'tgl_selesai', 'biaya_daftar'];
    protected $casts = ['tgl_mulai' => 'date', 'tgl_selesai' => 'date'];
}
