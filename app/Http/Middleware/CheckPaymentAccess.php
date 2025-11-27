<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPaymentAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'keuangan'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}