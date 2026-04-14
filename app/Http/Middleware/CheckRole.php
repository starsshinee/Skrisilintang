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
     * Pemakaian di routes:
     *   ->middleware('role:superadmin')
     *   ->middleware('role:superadmin,kasubag')   ← boleh lebih dari satu role
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diperbolehkan mengakses rute ini
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah akun aktif
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('login')
                ->withErrors(['username' => 'Akun Anda tidak aktif. Hubungi administrator.']);
        }

        // Jika tidak ada parameter role, izinkan semua yang sudah login
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user ada di daftar yang diizinkan
        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
