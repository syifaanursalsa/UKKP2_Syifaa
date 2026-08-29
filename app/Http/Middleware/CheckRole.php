<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Membatasi akses halaman berdasarkan role user.
     * Cara pakai di route: middleware('role:admin')
     * atau beberapa role: middleware('role:admin,petugas')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika role user tidak termasuk yang diizinkan, tampilkan 403
        if (! in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}