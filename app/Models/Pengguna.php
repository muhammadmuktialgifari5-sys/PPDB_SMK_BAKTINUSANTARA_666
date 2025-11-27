<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $fillable = ['nama', 'email', 'hp', 'password_hash', 'role', 'aktif'];
    protected $hidden = ['password_hash'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'user_id');
    }
}
