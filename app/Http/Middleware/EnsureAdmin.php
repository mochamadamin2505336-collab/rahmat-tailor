<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Memisahkan hak akses admin dan pelanggan (PRD bagian 9, keamanan).
 * Dipasang setelah middleware auth.
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $pengguna = $request->user();

        if ($pengguna === null || ! $pengguna->isAdmin()) {
            abort(403, 'Hanya admin yang boleh mengakses bagian ini.');
        }

        return $next($request);
    }
}
