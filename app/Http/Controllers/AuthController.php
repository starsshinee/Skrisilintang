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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // ────────────────────────────────────────────────────────────────────
    // Halaman Login
    // ────────────────────────────────────────────────────────────────────
    public function showLogin(): View
    {
        return view('auth.login', ['alreadyLoggedIn' => Auth::check()]);
    }

    // ────────────────────────────────────────────────────────────────────
    // Proses Login
    // ────────────────────────────────────────────────────────────────────
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $user = User::where('username', $request->input('username'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau password salah.']);
        }

        if (!$user->is_active) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Akun tidak aktif. Hubungi admin.']);
        }

        RateLimiter::clear($throttleKey);
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    // ────────────────────────────────────────────────────────────────────
    // Logout
    // ────────────────────────────────────────────────────────────────────
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout.');
    }

    // ────────────────────────────────────────────────────────────────────
    // Redirect by Role
    // ────────────────────────────────────────────────────────────────────
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
    // Profile
    // ────────────────────────────────────────────────────────────────────
    public function showProfile(): View
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    // ✅ FIXED: Update Profile (NO MORE INTELLISENSE ERROR!)
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'nip' => ['sometimes', 'nullable', 'string', 'max:30'],
            'jabatan' => ['sometimes', 'nullable', 'string', 'max:255'],
            'signature' => ['sometimes', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'signature.image' => 'File harus gambar.',
            'signature.max' => 'Ukuran maksimal 2MB.',
        ]);

        // Update fields
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('nip')) {
            $user->nip = $request->nip;
        }
        if ($request->filled('jabatan')) {
            $user->jabatan = $request->jabatan;
        }

        // Handle signature upload
       if ($request->hasFile('signature')) {
        // Hapus signature lama jika ada
        if ($user->signature && Storage::disk('public')->exists($user->signature)) {
            Storage::disk('public')->delete($user->signature);
        }
        
        // Simpan signature baru
        $path = $request->file('signature')->store('signatures', 'public');
        
        // Simpan path ke kolom 'signature' sesuai database kamu
        $user->signature = $path; 
        $user->save();
    }

        $user->save();

        return back()->with('success', '✅ Profile berhasil diupdate!');
    }

    // ✅ FIXED: Change Password (NO MORE INTELLISENSE ERROR!)
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // ✅ SAFE ASSIGNMENT
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '✅ Password berhasil diubah!');
    }

    // ────────────────────────────────────────────────────────────────────
    // Register (Superadmin only)
    // ────────────────────────────────────────────────────────────────────
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['superadmin','kepalabpmp','kasubag','adminpersediaan','adminsarpras','adminasettetap','pegawai','tamu'])],
            'nip' => ['nullable', 'string', 'max:30'],
            'jabatan' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'is_active' => true,
        ]);

        return redirect()->route('login')
            ->with('success', "✅ User {$user->name} berhasil dibuat!");
    }
}