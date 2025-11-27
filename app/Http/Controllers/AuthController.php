<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => null,
            'password_hash' => Hash::make($request->password),
            'role' => 'pendaftar',
            'aktif' => 1,
            'email_verified_at' => now()
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'aksi' => 'REGISTER',
            'deskripsi' => 'Registrasi akun baru',
            'ip_address' => $request->ip()
        ]);

        // Auto login setelah register
        Auth::login($user);
        
        return redirect()->route('pendaftaran.create')->with('success', 'Registrasi berhasil! Silakan lengkapi formulir pendaftaran.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Coba login dengan email atau nama
        $user = Pengguna::where('email', $credentials['email'])
                       ->orWhere('nama', $credentials['email'])
                       ->first();

        if ($user && Hash::check($credentials['password'], $user->password_hash)) {
            Auth::login($user);
            
            AuditLog::create([
                'user_id' => $user->id,
                'aksi' => 'LOGIN',
                'deskripsi' => 'Login berhasil',
                'ip_address' => $request->ip()
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email/Username atau password salah']);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'LOGOUT',
                'deskripsi' => 'Logout',
                'ip_address' => $request->ip()
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
    
    private function sendVerificationEmail($user, $code)
    {
        try {
            $subject = 'Kode Verifikasi Email - SMK Bakti Nusantara 666';
            $message = "Halo {$user->nama},\n\n";
            $message .= "Kode verifikasi email Anda: {$code}\n\n";
            $message .= "Kode ini berlaku selama 15 menit.\n\n";
            $message .= "Jika Anda tidak mendaftar, abaikan email ini.\n\n";
            $message .= "Terima kasih,\nSMK Bakti Nusantara 666";
            
            Mail::raw($message, function ($mail) use ($user, $subject) {
                $mail->to($user->email, $user->nama)
                     ->subject($subject)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            \Log::info("FALLBACK - Verification code for {$user->email}: {$code}");
        }
    }
    
    public function showVerifyEmailForm($userId)
    {
        $user = Pengguna::findOrFail($userId);
        return view('auth.verify-email', compact('user'));
    }
    
    public function verifyEmail(Request $request, $userId)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6'
        ]);
        
        $user = Pengguna::findOrFail($userId);
        
        if (!$user->verification_code || $user->verification_code_expires_at < now()) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi sudah kadaluarsa.']);
        }
        
        if ($user->verification_code !== $request->verification_code) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
        }
        
        $user->update([
            'email_verified_at' => now(),
            'aktif' => 1,
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);
        
        AuditLog::create([
            'user_id' => $user->id,
            'aksi' => 'EMAIL_VERIFIED',
            'deskripsi' => 'Email berhasil diverifikasi',
            'ip_address' => $request->ip()
        ]);
        
        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }
    
    public function resendVerificationCode($userId)
    {
        $user = Pengguna::findOrFail($userId);
        
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email sudah diverifikasi.');
        }
        
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(15)
        ]);
        
        $this->sendVerificationEmail($user, $verificationCode);
        
        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }
}
