<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 120)->unique();
            $table->string('hp', 20)->nullable();
            $table->string('password_hash', 255);
            $table->enum('role', ['pendaftar', 'admin', 'verifikator_adm', 'keuangan', 'kepsek']);
            $table->tinyInteger('aktif')->default(0);
            $table->timestamps();
            $table->index('role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
};
