<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftar;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class CleanDuplicatePendaftar extends Command
{
    protected $signature = 'clean:duplicate-pendaftar {--force : Force cleanup without confirmation}';
    protected $description = 'Clean duplicate pendaftar records, keeping the most advanced one';

    public function handle()
    {
        $this->info('🔍 Checking for duplicate pendaftar records...');

        $duplicates = Pendaftar::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id');

        if ($duplicates->count() == 0) {
            $this->info('✅ No duplicate records found.');
            return 0;
        }

        $this->warn("❌ Found {$duplicates->count()} users with duplicate registrations:");

        $statusPriority = [
            'LULUS' => 9,
            'PAYMENT_VERIFIED' => 8,
            'PAID' => 7,
            'ADM_PASS' => 6,
            'SUBMIT' => 5,
            'DRAFT' => 4,
            'ADM_REJECT' => 3,
            'TIDAK_LULUS' => 2,
            'CADANGAN' => 1
        ];

        $toDelete = [];
        $toKeep = [];

        foreach ($duplicates as $userId) {
            $pendaftarList = Pendaftar::where('user_id', $userId)
                ->with(['pembayaran', 'dataSiswa'])
                ->orderBy('id')
                ->get();

            $this->line("\n👤 User ID: {$userId} has {$pendaftarList->count()} registrations:");

            // Find the best record to keep
            $bestRecord = null;
            $bestPriority = -1;

            foreach ($pendaftarList as $p) {
                $priority = $statusPriority[$p->status] ?? 0;
                
                // Add bonus for having payment
                if ($p->pembayaran) {
                    $priority += 10;
                }
                
                $this->line("   📋 {$p->no_pendaftaran} (ID: {$p->id}) - Status: {$p->status} - Priority: {$priority}");
                
                if ($priority > $bestPriority || 
                    ($priority == $bestPriority && $p->id > $bestRecord->id)) {
                    $bestRecord = $p;
                    $bestPriority = $priority;
                }
            }

            $toKeep[] = $bestRecord;
            $this->info("   ✅ Will keep: {$bestRecord->no_pendaftaran} (ID: {$bestRecord->id})");

            foreach ($pendaftarList as $p) {
                if ($p->id != $bestRecord->id) {
                    $toDelete[] = $p;
                    $this->line("   🗑️  Will delete: {$p->no_pendaftaran} (ID: {$p->id})");
                }
            }
        }

        if (!$this->option('force') && !$this->confirm("\nDo you want to proceed with cleanup? This will delete " . count($toDelete) . " duplicate records.")) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info("\n🧹 Starting cleanup...");

        DB::beginTransaction();
        try {
            foreach ($toDelete as $pendaftar) {
                $this->line("Deleting: {$pendaftar->no_pendaftaran}");
                
                // Delete related records first
                $pendaftar->berkas()->delete();
                $pendaftar->pembayaran()->delete();
                $pendaftar->dataSiswa()->delete();
                $pendaftar->dataOrtu()->delete();
                $pendaftar->asalSekolah()->delete();
                
                // Delete the pendaftar record
                $pendaftar->delete();

                AuditLog::create([
                    'user_id' => 1,
                    'aksi' => 'DELETE_DUPLICATE_PENDAFTAR',
                    'deskripsi' => "Deleted duplicate pendaftar: {$pendaftar->no_pendaftaran}",
                    'ip_address' => '127.0.0.1'
                ]);
            }

            DB::commit();
            $this->info("✅ Successfully cleaned " . count($toDelete) . " duplicate records.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error during cleanup: " . $e->getMessage());
            return 1;
        }

        $this->info("🎉 Cleanup completed successfully!");
        return 0;
    }
}