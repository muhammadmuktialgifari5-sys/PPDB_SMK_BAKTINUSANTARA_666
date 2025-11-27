<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::middleware(['auth', 'role:admin,keuangan'])->get('/api/pending-payments', function () {
    $count = \App\Models\Pembayaran::where('status', 'PENDING')->count();
    return response()->json(['count' => $count]);
})->name('api.pending-payments');

// Auth Routes
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');

// Email Verification Routes
Route::get('/verify-email/{userId}', [AuthController::class, 'showVerifyEmailForm'])->name('verify.email.form');
Route::post('/verify-email/{userId}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('/resend-verification/{userId}', [AuthController::class, 'resendVerificationCode'])->name('resend.verification');

// Development only - bypass email verification
if (app()->environment('local')) {
    Route::get('/dev/verify-email/{userId}', function($userId) {
        $user = \App\Models\Pengguna::findOrFail($userId);
        $user->update([
            'email_verified_at' => now(),
            'aktif' => 1,
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);
        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi (DEV MODE)!');
    })->name('dev.verify.email');
}

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pendaftar Routes
    Route::middleware(['role:pendaftar', 'refresh.payment'])->group(function () {
        Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create')->middleware('check.registration');
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store')->middleware('check.registration');
        Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::get('/pendaftaran/{id}/pembayaran', [PembayaranController::class, 'showPembayaran'])->name('pendaftaran.pembayaran');
        Route::post('/berkas/{pendaftarId}/upload', [BerkasController::class, 'upload'])->name('berkas.upload');
        Route::post('/berkas/{pendaftarId}/skip', [BerkasController::class, 'skip'])->name('berkas.skip');
        Route::post('/pembayaran/{pendaftarId}/upload', [PembayaranController::class, 'upload'])->name('pembayaran.upload');
        Route::get('/cetak/kartu/{id}', [\App\Http\Controllers\CetakController::class, 'kartu'])->name('cetak.kartu');
        Route::get('/cetak/bukti-bayar/{id}', [\App\Http\Controllers\CetakController::class, 'buktiBayar'])->name('cetak.bukti-bayar');
    });
    
    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/master/jurusan', [MasterDataController::class, 'jurusan'])->name('master.jurusan');
        Route::post('/master/jurusan', [MasterDataController::class, 'storeJurusan'])->name('master.jurusan.store');
        Route::get('/master/gelombang', [MasterDataController::class, 'gelombang'])->name('master.gelombang');
        Route::post('/master/gelombang', [MasterDataController::class, 'storeGelombang'])->name('master.gelombang.store');
        Route::get('/peta', [DashboardController::class, 'peta'])->name('peta');
        Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users/{userId}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword']);
    });
    
    // Verifikator Routes (Admin can also access)
    Route::middleware('role:verifikator_adm,admin')->group(function () {
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('/verifikasi/{id}/detail', [VerifikasiController::class, 'detail'])->name('verifikasi.detail');
        Route::post('/verifikasi/{id}', [VerifikasiController::class, 'verifikasi'])->name('verifikasi.store');
        Route::post('/verifikasi/bulk', [VerifikasiController::class, 'bulkVerifikasi'])->name('verifikasi.bulk');
        Route::post('/berkas/{berkasId}/verifikasi', [BerkasController::class, 'verifikasi'])->name('berkas.verifikasi');
    });
    
    // Keuangan Routes
    Route::middleware('role:keuangan,admin')->group(function () {
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/{pembayaranId}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
    });
    
    // Kepala Sekolah Routes
    Route::middleware('role:kepsek,admin')->group(function () {
        Route::get('/dashboard/eksekutif', [DashboardController::class, 'index'])->name('dashboard.eksekutif');
    });
    
    // Laporan Routes
    Route::middleware('role:admin,verifikator_adm,keuangan,kepsek')->group(function () {
        Route::get('/laporan/pendaftar', [LaporanController::class, 'pendaftar'])->name('laporan.pendaftar');
        Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    });
    
    Route::middleware('role:keuangan,admin,kepsek')->group(function () {
        Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
    });
});

// Debug routes (only in development)
if (app()->environment('local')) {
    require __DIR__ . '/debug.php';
}
