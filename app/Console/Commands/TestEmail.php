<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $email = $this->argument('email');
        $testCode = '123456';
        
        $this->info('Testing email configuration...');
        $this->info('Email: ' . $email);
        $this->info('MAIL_MAILER: ' . config('mail.default'));
        
        try {
            Mail::raw(
                "Test email dari SMK Bakti Nusantara 666\n\nKode verifikasi test: {$testCode}\n\nJika Anda menerima email ini, konfigurasi email sudah benar.",
                function ($message) use ($email) {
                    $message->to($email)
                           ->subject('Test Email - SMK Bakti Nusantara 666')
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );
            
            $this->info('✅ Email berhasil dikirim!');
            
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email: ' . $e->getMessage());
            $this->info('💡 Periksa konfigurasi MAIL di file .env');
        }
        
        return 0;
    }
}