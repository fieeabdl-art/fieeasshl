<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tanpa ini, browser boleh menyimpan halaman admin yang sudah pernah
 * dibuka di cache "back-forward" (bfcache). Efeknya: admin klik Logout,
 * lalu tekan tombol Back di browser — halaman lama (yang isinya masih
 * konten admin) muncul lagi dari cache TANPA benar-benar minta ke server,
 * seolah-olah masih login. Sesi di server sebenarnya sudah mati; begitu
 * admin klik apa pun di halaman "hantu" itu barulah ke-lempar ke halaman
 * login. Supaya tombol Back langsung minta ulang ke server (dan langsung
 * ditolak/diarahkan ke login), setiap respons dari halaman admin diberi
 * header no-store di sini.
 */
class PreventBackHistoryCache
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
