<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Log;

class NotifyPendingPayments extends Command
{
    protected $signature = 'payments:notify-pending';
    protected $description = 'Kirim notifikasi untuk pembayaran yang pending';

    public function handle()
    {
        $pendingCount = Pembayaran::where('status', 'PENDING')->count();
        
        if ($pendingCount > 0) {
            $adminKeuangan = Pengguna::whereIn('role', ['admin', 'keuangan'])->get();
            
            foreach ($adminKeuangan as $user) {
                // Log notifikasi (bisa diganti dengan email/SMS)
                Log::info("Notifikasi pembayaran pending untuk {$user->nama}: {$pendingCount} pembayaran menunggu verifikasi");
            }
            
            $this->info("Notifikasi terkirim untuk {$pendingCount} pembayaran pending ke {$adminKeuangan->count()} staff");
        } else {
            $this->info("Tidak ada pembayaran pending");
        }
    }
}