<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use App\Models\PeminjamanKendaraan;
use App\Models\PengembalianKendaraan;
use App\Models\AssetTetap;           // ✅ IMPORT INI
use App\Models\PermintaanPersediaan;
use App\Models\User;

class PegawaiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Dashboard Pegawai
     */
    public function dashboard()
    {
        return view('pegawai.dashbord');
        // $stats = [
        //     'total_peminjaman_barang' => PeminjamanBarang::count(),
        //     'total_pengembalian_barang' => PengembalianBarang::count(),
        //     'total_peminjaman_kendaraan' => PeminjamanKendaraan::count(),
        //     'total_pengembalian_kendaraan' => PengembalianKendaraan::count() ?? 0,
        //     'peminjaman_hari_ini' => PeminjamanBarang::whereDate('created_at', today())->count() +
        //                            PeminjamanKendaraan::whereDate('created_at', today())->count(),
        // ];

        // $recentPeminjaman = PeminjamanKendaraan::with('user', 'assetTetap')
        //     ->latest()
        //     ->limit(10)
        //     ->get();

        // return view('pegawai.dashboard', compact('stats', 'recentPeminjaman'));
    }

    /**
     * Peminjaman Barang
     */
    public function peminjamanBarang(Request $request)
    {
        $query = PeminjamanBarang::with(['user'])
            ->latest();

        if ($request->search) {
            $query->where('kode_peminjaman', 'like', '%'.$request->search.'%')
                  ->orWhereHas('user', fn($q) => $q->where('nama', 'like', '%'.$request->search.'%'));
        }

        $peminjamanBarang = $query->paginate(15);
        return view('pegawai.peminjaman_barang', compact('peminjamanBarang'));
    }

    /**
     * Pengembalian Barang
     */
    public function pengembalianBarang(Request $request)
    {
        $peminjamanBelumKembali = PeminjamanBarang::whereDoesntHave('pengembalianBarang')
            ->orWhereHas('pengembalianBarang', fn($q) => $q->where('status', 'diproses'))
            ->with('user')
            ->get();

        $pengembalianBarang = PengembalianBarang::with(['peminjamanBarang.user'])
            ->latest()
            ->paginate(10);

        return view('pegawai.pengembalian_barang', compact(
            'peminjamanBelumKembali',
            'pengembalianBarang'
        ));
    }

    /**
     * Permintaan Persediaan
     */
    public function permintaanPersediaan(Request $request)
    {
        $query = PermintaanPersediaan::with('user')
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $permintaanPersediaan = $query->paginate(15);
        return view('pegawai.permintaan_persediaan', compact('permintaanPersediaan'));
    }

    /**
     * Riwayat Permintaan
     */
    public function riwayatPermintaan(Request $request)
    {
        $query = PermintaanPersediaan::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->latest();

        $riwayatPermintaan = $query->paginate(20);
        return view('pegawai.riwayat_permintaan', compact('riwayatPermintaan'));
    }

    /**
     * Peminjaman Kendaraan - Daftar & Verifikasi
     */
    public function peminjamanKendaraan(Request $request)
    {
        $query = PeminjamanKendaraan::with(['user', 'assetTetap']) // ✅ assetTetap BUKAN kendaraan
            ->latest();

        if ($request->search) {
            $query->where('nama_kendaraan', 'like', '%'.$request->search.'%')
                  ->orWhereHas('assetTetap', fn($q) => $q->where('nopol', 'like', '%'.$request->search.'%'))
                  ->orWhereHas('user', fn($q) => $q->where('nama', 'like', '%'.$request->search.'%'));
        }

        $peminjamanKendaraan = $query->paginate(15);

        return view('pegawai.peminjaman_kendaraan', compact('peminjamanKendaraan'));
    }

    /**
     * Pengembalian Kendaraan - FORM + RIWAYAT (FIXED!)
     */
    public function pengembalianKendaraan(Request $request)
    {
        // ✅ GUNAKAN RELASI PENGEMBALIAN() & ASSETTETAP
        $peminjamanKendaraan = PeminjamanKendaraan::with([
                'user', 
                'assetTetap',           // ✅ BUKAN kendaraan
                'pengembalian'          // ✅ NAMA RELASI ANDA
            ])
            ->whereDoesntHave('pengembalian') // ✅ NAMA RELASI ANDA
            ->orWhereHas('pengembalian', function($q) {
                $q->where('status_pengembalian', 'diproses');
            })
            ->get();

        // ✅ RIWAYAT PENGEMBALIAN
        $pengembalianKendaraan = PengembalianKendaraan::with([
                'peminjamanKendaraan.user', 
                'peminjamanKendaraan.assetTetap'  // ✅ assetTetap
            ])
            ->latest()
            ->paginate(10);

        return view('pegawai.pengembalian_kendaraan', compact(
            'peminjamanKendaraan',
            'pengembalianKendaraan'
        ));
    }

    /**
     * Simpan Pengembalian Kendaraan (POST)
     */
    public function storePengembalianKendaraan(Request $request)
    {
        $request->validate([
            'peminjaman_kendaraan_id' => 'required|exists:peminjaman_kendaraan,id', // ✅ table name benar
            'tanggal_pengembalian_aktual' => 'required|date',
            'kondisi_kendaraan' => 'required|in:baik,rusak-ringan,rusak-berat,hilang',
            'foto_sebelum' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sesudah' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:1000',
            'status_pengembalian' => 'required|in:diproses,diterima,ditolak',
        ]);

        // Upload foto
        $fotoSebelum = $request->file('foto_sebelum')->store('pengembalian/kendaraan/sebelum', 'public');
        $fotoSesudah = $request->file('foto_sesudah')->store('pengembalian/kendaraan/sesudah', 'public');

        // Hitung denda
        $peminjaman = PeminjamanKendaraan::with('assetTetap')->findOrFail($request->peminjaman_kendaraan_id);
        $biayaDenda = $this->hitungDendaKendaraan($peminjaman, $request->kondisi_kendaraan);

        // Simpan pengembalian
        PengembalianKendaraan::create([
            'peminjaman_kendaraan_id' => $request->peminjaman_kendaraan_id,
            'tanggal_pengembalian_aktual' => $request->tanggal_pengembalian_aktual,
            'kondisi_kendaraan' => $request->kondisi_kendaraan,
            'foto_sebelum' => $fotoSebelum,
            'foto_sesudah' => $fotoSesudah,
            'catatan' => $request->catatan,
            'status_pengembalian' => $request->status_pengembalian,
            'biaya_denda' => $biayaDenda,
            'pegawai_id' => Auth::id(),
        ]);

        // Update status peminjaman
        $peminjaman->update(['status' => 'dikembalikan']);

        return redirect()->back()->with('success', 'Pengembalian kendaraan berhasil dilaporkan!');
    }

    /**
     * Pengaturan Akun
     */
    public function pengaturanAkun()
    {
        $pegawai = Auth::user();
        return view('pegawai.pengaturan_akun', compact('pegawai'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        // $request->validate([
        //     'nama' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email,'.Auth::id(),
        //     'no_telepon' => 'nullable|string|max:15',
        // ]);

        // Auth::user()->update($request->only(['nama', 'email', 'no_telepon']));
        // return redirect()->back()->with('success', 'Profile berhasil diupdate!');
    }

    /**
     * Hitung Denda
     */
    private function hitungDendaKendaraan($peminjaman, $kondisi)
    {
        $dendaBase = 0;
        switch ($kondisi) {
            case 'rusak-ringan': $dendaBase = 50000; break;
            case 'rusak-berat': $dendaBase = 250000; break;
            case 'hilang': $dendaBase = 5000000; break;
        }
        return $dendaBase;
    }
}