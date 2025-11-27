<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';
    protected $fillable = ['user_id', 'tanggal_daftar', 'no_pendaftaran', 'gelombang_id', 'jurusan_id', 'status', 'user_verifikasi_adm', 'tgl_verifikasi_adm', 'catatan_verifikasi_adm', 'user_verifikasi_payment', 'tgl_verifikasi_payment'];
    protected $casts = ['tanggal_daftar' => 'datetime', 'tgl_verifikasi_adm' => 'datetime', 'tgl_verifikasi_payment' => 'datetime'];

    /**
     * Boot method to add model events
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pendaftar) {
            // Check if user already has a registration
            if (static::where('user_id', $pendaftar->user_id)->exists()) {
                throw new \Exception('User sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali.');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function dataSiswa()
    {
        return $this->hasOne(PendaftarDataSiswa::class);
    }

    public function dataOrtu()
    {
        return $this->hasOne(PendaftarDataOrtu::class);
    }

    public function asalSekolah()
    {
        return $this->hasOne(PendaftarAsalSekolah::class);
    }

    public function berkas()
    {
        return $this->hasMany(PendaftarBerkas::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    /**
     * Sync payment status with pendaftar status
     * Disabled - payment verification now manual
     */
    public function syncPaymentStatus()
    {
        // Manual verification by staff keuangan
        return false;
    }

    /**
     * Get current payment status with auto-sync
     */
    public function getCurrentPaymentStatus()
    {
        $this->syncPaymentStatus();
        return $this->fresh()->status;
    }

    /**
     * Check if user already has registration
     */
    public static function userHasRegistration($userId)
    {
        return static::where('user_id', $userId)->exists();
    }

    /**
     * Get user's registration
     */
    public static function getUserRegistration($userId)
    {
        return static::where('user_id', $userId)->first();
    }
}
