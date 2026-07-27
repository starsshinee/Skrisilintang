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
            'nomor_telepon' => ['required', 'string', 'max:14'],
            'unit_kerja_id' => ['nullable', 'exists:unit_kerjas,id'],
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
            'nomor_telepon.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_telepon.max' => 'Nomor WhatsApp maksimal 14 karakter.',
            'unit_kerja_id.exists' => 'Unit kerja yang dipilih tidak valid dalam sistem.',
        ]);

        // Di dalam fungsi registrasi pengguna baru
        $rolesButuhVerifikasi = ['adminpersediaan', 'adminsarpras', 'adminasettetap', 'kepalabpmp', 'kasubag', 'pegawai'];

        // Cek apakah role yang dipilih butuh verifikasi
        $statusAwal = in_array($request->role, $rolesButuhVerifikasi) ? 'pending' : 'approved';
        $user = User::create([
            'name'      => $request->name,
            'nip'       => $request->nip,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'nomor_telepon' => $request->nomor_telepon,
            'status' => $statusAwal,
            'unit_kerja_id' => $request->unit_kerja_id,
            'is_active' => true,
        ]);

        // Cek jika statusnya pending (butuh verifikasi)
        if ($statusAwal === 'pending') {
            // Ambil semua pengguna dengan role superadmin yang memiliki nomor telepon valid
            $superadmins = User::where('role', 'superadmin')
                               ->whereNotNull('nomor_telepon')
                               ->where('nomor_telepon', '!=', '')
                               ->get();

            // Loop untuk mengirim notifikasi ke setiap superadmin yang ditemukan
            foreach ($superadmins as $admin) {
                // Formatting pesan WhatsApp
                $pesan = "*NOTIFIKASI SIPANDU - VERIFIKASI AKUN*\n\n";
                $pesan .= "Halo {$admin->name},\n\n";
                $pesan .= "Terdapat pendaftar akun baru yang memerlukan verifikasi Anda:\n\n";
                $pesan .= "👤 *Nama:* " . $request->name . "\n";
                $pesan .= "🏷 *Role:* " . strtoupper($request->role) . "\n";
                $pesan .= "📱 *Nomor WhatsApp:* " . ($request->nomor_telepon ?? '-') . "\n\n";
                $pesan .= "Silakan login ke sistem untuk menindaklanjuti permintaan ini.\n";
                $pesan .= "Terima kasih.";

                // Dispatch Job Fonnte (pastikan path namespace Job sesuai)
                \App\Jobs\SendFonnteNotification::dispatch($admin->nomor_telepon, $pesan);
            }
        }

        // Langsung login setelah registrasi
        // Auth::login($user);
        // $request->session()->regenerate();

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Akun Anda sedang dalam tahap verifikasi oleh Operator. Silakan cek secara berkala.');
    }
}
