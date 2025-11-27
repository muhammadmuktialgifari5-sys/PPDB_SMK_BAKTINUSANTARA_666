<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('metode_pembayaran', 50)->nullable()->after('nominal');
            $table->date('tanggal_bayar')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'tanggal_bayar']);
        });
    }
};