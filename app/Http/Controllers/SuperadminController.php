<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk membaca tabel sessions

class SuperadminController extends Controller
{
    public function dashboard()
    {
        // Hitung berapa user yang statusnya masih 'pending'
        $jumlahPending = User::where('status', 'pending')->count();
        
        return view('superadmin.dashbord', compact('jumlahPending'));
    }

    public function manajemenUser(Request $request) // <-- Pastikan nama fungsi sesuai dengan rute di web.php kamu
    {
        // 1. AMBIL DATA USERS DARI DATABASE
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('nip', 'like', "%{$request->search}%");
        }

        // INI DIA VARIABEL $users YANG DICARI OLEH BLADE!
        $users = $query->orderBy('role', 'asc')->paginate(10)->withQueryString();

        // 2. AMBIL DATA LOG AKTIVITAS
        $logAktivitas = DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->select('users.name', 'users.role', 'sessions.ip_address', 'sessions.last_activity', 'sessions.user_agent')
            ->orderBy('sessions.last_activity', 'desc')
            ->get()
            ->map(function ($log) {
                $log->last_activity_format = \Carbon\Carbon::createFromTimestamp($log->last_activity)->diffForHumans();
                return $log;
            });

        // 3. KIRIM VARIABEL KE VIEW
        // Pastikan nama view ('superadmin.manajemen_user') sesuai dengan nama file blade kamu!
        return view('superadmin.manajemen_user', compact('users', 'logAktivitas'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:superadmin,kepalabpmp,kasubag,adminpersediaan,adminsarpras,adminasettetap,pegawai,tamu',
            'nip'      => 'nullable|string|max:30',
            'jabatan'  => 'nullable|string|max:255',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'nip'      => $request->nip,
            'jabatan'  => $request->jabatan,
            'is_active'=> true, // Secara default user baru langsung aktif
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updatePengguna(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => 'required|in:superadmin,kepalabpmp,kasubag,adminpersediaan,adminsarpras,adminasettetap,pegawai,tamu',
            'nip'      => 'nullable|string|max:30',
            'jabatan'  => 'nullable|string|max:255',
        ]);

        $updateData = [
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => strtolower(trim($request->email)),
            'role'     => $request->role,
            'nip'      => $request->nip,
            'jabatan'  => $request->jabatan,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroyPengguna(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    // Fungsi Baru: Untuk Switch Aktif / Nonaktif
    public function toggleStatus(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user->update([
            'is_active' => !$user->is_active // Membalikkan status (true jadi false, false jadi true)
        ]);

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$statusText}!");
    }

    public function verifikasiUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Ubah status menjadi approved
        $user->update([
            'status' => 'approved'
        ]);
        // 2. Kirim notifikasi WhatsApp ke user yang baru saja disetujui
        if (!empty($user->nomor_telepon)) {
            $pesan = "*NOTIFIKASI SIPANDU*\n\n";
            $pesan .= "Halo {$user->name},\n\n";
            $pesan .= "Selamat! Akun Anda dengan hak akses *" . strtoupper($user->role) . "* telah *DIVERIFIKASI* oleh Operator.\n\n";
            $pesan .= "Sekarang Anda sudah bisa login ke dalam sistem SIPANDU menggunakan username dan password yang telah didaftarkan.\n\n";
            $pesan .= "Terima kasih.";

            // Eksekusi Job pengiriman Fonnte
            \App\Jobs\SendFonnteNotification::dispatch($user->nomor_telepon, $pesan)->afterCommit();
        }

        return redirect()->back()->with('success', 'Akun pengguna berhasil diverifikasi dan sekarang dapat login.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data pengguna berhasil dihapus.');
    }
}