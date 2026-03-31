<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  (Parameter tambahan untuk menangkap role dari route)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login atau belum
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan di route
        // Contoh di route: ->middleware('role:petugas,kepala')
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika role tidak cocok, tendang balik ke dashboard dengan pesan error
        return redirect('/')->with('error', 'Maaf, Anda tidak memiliki akses ke halaman ini.');
    }
}