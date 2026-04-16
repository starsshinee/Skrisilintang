<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ────────────────────────────────────────────────────────────────────
    // Halaman Login
    // ────────────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman login.
     */
    public function showLogin(): View
    {
        return view('auth.login', [
            'alreadyLoggedIn' => Auth::check(),
        ]);
    }

    // ────────────────────────────────────────────────────────────────────
    // Proses Login
    // ────────────────────────────────────────────────────────────────────

    /**
     * Proses permintaan login.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Rate limiter – max 5 percobaan per 60 detik per IP + username
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
                ]);
        }

        // Cari user berdasarkan username
        $user = User::where('username', $request->input('username'))->first();

        // Verifikasi user & password
        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Username atau password tidak sesuai.',
                ]);
        }

        // Cek apakah akun aktif
        if (! $user->is_active) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Akun Anda tidak aktif. Hubungi administrator.',
                ]);
        }

        // Login berhasil
        RateLimiter::clear($throttleKey);
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    // ────────────────────────────────────────────────────────────────────
    // Logout
    // ────────────────────────────────────────────────────────────────────

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    // ────────────────────────────────────────────────────────────────────
    // Helper: Redirect berdasarkan peran
    // ────────────────────────────────────────────────────────────────────

    /**
     * Tentukan halaman tujuan setelah login berdasarkan peran user.
     */
    private function redirectByRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'superadmin'      => redirect()->route('superadmin.dashboard'),
            'kepalabpmp'      => redirect()->route('kepalabpmp.dashboard'),
            'kasubag'         => redirect()->route('kasubag.dashboard'),
            'adminpersediaan' => redirect()->route('adminpersediaan.dashboard'),
            'adminsarpras'    => redirect()->route('adminsarpras.dashboard'),
            'adminasettetap'  => redirect()->route('adminasettetap.dashboard'),
            'pegawai'         => redirect()->route('pegawai.dashboard'),
            'tamu'            => redirect()->route('tamu.dashboard'),
            default           => redirect('/'),
        };
    }

    // ────────────────────────────────────────────────────────────────────
    // (Opsional) Profil & Ganti Password
    // ────────────────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman profil pengguna yang sedang login.
     */
    public function showProfile(): View
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    /**
     * Proses pergantian password pengguna.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required', 'string'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
