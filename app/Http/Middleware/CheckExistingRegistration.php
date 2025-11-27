<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pendaftar;

class CheckExistingRegistration
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'pendaftar') {
            $existingPendaftar = Pendaftar::where('user_id', auth()->id())->first();
            
            if ($existingPendaftar) {
                return redirect()->route('pendaftaran.show', $existingPendaftar->id)
                    ->with('info', 'Anda sudah memiliki pendaftaran. Setiap siswa hanya dapat mendaftar 1 kali.');
            }
        }
        
        return $next($request);
    }
}