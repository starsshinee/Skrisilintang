<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.registrasi');
    }

    /**
     * Proses pendaftaran pengguna baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'nip'      => ['required', 'string', 'max:30'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username'),
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role'     => [
                'required',
                Rule::in([
                    'superadmin', 'kepalabpmp', 'kasubag',
                    'adminpersediaan', 'adminsarpras', 'adminasettetap',
                    'pegawai', 'tamu',
                ]),
            ],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'nip.required'      => 'NIP/NIK wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'username.unique'   => 'Username sudah digunakan, pilih yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Peran wajib dipilih.',
            'role.in'           => 'Peran tidak valid.',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'nip'       => $request->nip,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        // Langsung login setelah registrasi
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan masuk dengan akun baru Anda.');
    }
}
