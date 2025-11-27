<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftar;
use App\Models\Pembayaran;
use App\Models\AuditLog;

class FixPaymentStatus extends Command
{
    protected $signature = 'fix:payment-status {--force : Force fix without confirmation}';
    protected $description = 'Fix payment status synchronization between pendaftar and pembayaran tables';

    public function handle()
    {
        $this->info('🔍 Checking payment status synchronization...');

        // Find all verified payments where pendaftar status is not PAYMENT_VERIFIED
        $verifiedPayments = Pembayaran::where('status', 'VERIFIED')
            ->whereHas('pendaftar', function($query) {
                $query->where('status', '!=', 'PAYMENT_VERIFIED');
            })
            ->with('pendaftar')
            ->get();

        // Find all rejected payments where pendaftar status is still PAYMENT_VERIFIED
        $rejectedPayments = Pembayaran::where('status', 'REJECTED')
            ->whereHas('pendaftar', function($query) {
                $query->where('status', 'PAYMENT_VERIFIED');
            })
            ->with('pendaftar')
            ->get();

        $totalIssues = $verifiedPayments->count() + $rejectedPayments->count();

        if ($totalIssues == 0) {
            $this->info('✅ All payment statuses are synchronized correctly.');
            
            // Show current status for verification
            $this->info('\n📊 Current payment status summary:');
            $allPayments = Pembayaran::with('pendaftar')->get();
            foreach ($allPayments as $p) {
                $status = $p->status == 'VERIFIED' && $p->pendaftar->status == 'PAYMENT_VERIFIED' ? '✅' : '❌';
                $this->line("{$status} {$p->pendaftar->no_pendaftaran}: Payment={$p->status}, Pendaftar={$p->pendaftar->status}");
            }
            
            return 0;
        }

        $this->warn("❌ Found {$totalIssues} mismatched records:");
        
        if ($verifiedPayments->count() > 0) {
            $this->line("\n🔧 Verified payments with incorrect pendaftar status:");
            foreach ($verifiedPayments as $payment) {
                $this->line("   {$payment->pendaftar->no_pendaftaran}: Payment=VERIFIED, Pendaftar={$payment->pendaftar->status}");
            }
        }
        
        if ($rejectedPayments->count() > 0) {
            $this->line("\n🔧 Rejected payments with incorrect pendaftar status:");
            foreach ($rejectedPayments as $payment) {
                $this->line("   {$payment->pendaftar->no_pendaftaran}: Payment=REJECTED, Pendaftar={$payment->pendaftar->status}");
            }
        }

        if (!$this->option('force') && !$this->confirm('\nDo you want to fix these issues?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $fixed = 0;
        
        // Fix verified payments
        foreach ($verifiedPayments as $payment) {
            $pendaftar = $payment->pendaftar;
            $oldStatus = $pendaftar->status;
            
            $pendaftar->update([
                'status' => 'PAYMENT_VERIFIED',
                'user_verifikasi_payment' => 'System Fix',
                'tgl_verifikasi_payment' => $payment->updated_at
            ]);
            
            AuditLog::create([
                'user_id' => 1, // System user
                'aksi' => 'FIX_PAYMENT_STATUS',
                'deskripsi' => "Fixed payment status for {$pendaftar->no_pendaftaran}: {$oldStatus} → PAYMENT_VERIFIED",
                'ip_address' => '127.0.0.1'
            ]);
            
            $this->line("✅ Fixed: {$pendaftar->no_pendaftaran} - {$oldStatus} → PAYMENT_VERIFIED");
            $fixed++;
        }
        
        // Fix rejected payments
        foreach ($rejectedPayments as $payment) {
            $pendaftar = $payment->pendaftar;
            $oldStatus = $pendaftar->status;
            
            $pendaftar->update([
                'status' => 'PAID',
                'user_verifikasi_payment' => null,
                'tgl_verifikasi_payment' => null
            ]);
            
            AuditLog::create([
                'user_id' => 1, // System user
                'aksi' => 'FIX_PAYMENT_STATUS',
                'deskripsi' => "Fixed payment status for {$pendaftar->no_pendaftaran}: {$oldStatus} → PAID (payment rejected)",
                'ip_address' => '127.0.0.1'
            ]);
            
            $this->line("✅ Fixed: {$pendaftar->no_pendaftaran} - {$oldStatus} → PAID (payment rejected)");
            $fixed++;
        }

        $this->info("\n🎉 Successfully fixed {$fixed} payment status records.");
        
        // Clear cache if exists
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        $this->info('💡 Tip: You can run this command with --force to skip confirmation.');
        
        return 0;
    }
}