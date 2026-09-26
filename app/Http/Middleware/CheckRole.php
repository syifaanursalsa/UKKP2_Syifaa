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
    public function handle(Request $request, Closure $next, ...$roles)
{
    $user = auth()->user(); // Simpan dulu user-nya ke variabel

    // Jika tidak ada user (belum login) ATAU role-nya tidak cocok
    if (!$user || !in_array($user->role, $roles)) {
        abort(403, 'Kamu tidak punya akses ke halaman ini.');
    }

    return $next($request);
}
}