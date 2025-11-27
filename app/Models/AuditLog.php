<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $fillable = ['user_id', 'aksi', 'deskripsi', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }
}
