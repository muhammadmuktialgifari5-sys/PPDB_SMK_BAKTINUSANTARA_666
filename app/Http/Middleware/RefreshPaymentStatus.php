<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Pembayaran;

class RefreshPaymentStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Middleware disabled - payment verification now manual by staff keuangan
        return $next($request);
    }
}