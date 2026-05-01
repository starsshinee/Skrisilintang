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
use App\Models\Persediaan;
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
        $asetTetap = AssetTetap::where('status', 'Tersedia')
            ->where('kondisi', '!=', 'rusak berat')
            ->orderBy('nama_barang', 'asc')
            ->get();

        // Ambil riwayat peminjaman khusus user yang sedang login
        $riwayat = PeminjamanBarang::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.peminjaman_barang', compact('asetTetap', 'riwayat'));
    }

    public function storePeminjamanBarang(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|exists:aset_tetap,kode_barang',
            'jumlah' => 'required|integer|min:1',
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'deskripsi_peruntukan' => 'required|string',
        ]);

        // Ambil detail aset dari database berdasarkan kode_barang yang dipilih
        $aset = AssetTetap::where('kode_barang', $request->kode_barang)->first();

        // Simpan ke database
        PeminjamanBarang::create([
            'user_id' => Auth::id(),
            'nama_barang' => $aset->nama_barang,
            'kode_barang' => $aset->kode_barang,
            'nup' => $aset->nup,               // Otomatis tersimpan dari tabel aset
            'kategori' => $aset->kategori,     // Otomatis tersimpan dari tabel aset
            'merek' => $aset->merek,
            'jumlah' => $request->jumlah,
            'request_date' => now(),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'deskripsi_peruntukan' => $request->deskripsi_peruntukan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan peminjaman aset berhasil dikirim dan sedang menunggu persetujuan Admin.');
    }

    // 3. AJAX Detail Peminjaman (Opsional untuk Modal Detail)
    public function detailPeminjaman($id)
    {
        $peminjaman = PeminjamanBarang::with('user')->findOrFail($id);
        
        // Pastikan user hanya bisa melihat datanya sendiri
        if ($peminjaman->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['success' => true, 'data' => $peminjaman]);
    }

    // Fungsi Membatalkan Peminjaman Barang
    public function cancelPeminjaman($id)
    {
        // Cari data berdasarkan ID dan pastikan itu milik User yang sedang Login
        $peminjaman = \App\Models\PeminjamanBarang::where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        // Hanya peminjaman yang masih PENDING yang boleh dibatalkan
        if ($peminjaman->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Permintaan sudah diproses, tidak bisa dibatalkan.'], 400);
        }

        // Hapus data
        $peminjaman->delete();

        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil dibatalkan.']);
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
        $persediaan = Persediaan::select('id', 'kode_barang', 'nama_barang', 'jumlah')
                               ->where('jumlah', '>', 0)// Hanya barang tersedia
                               ->orderBy('nama_barang')
                               ->orderBy('nama_barang')
                               ->get();
        
        
        $riwayat = PermintaanPersediaan::where('user_id', Auth::id())
                                     ->with('persediaan')
                                     ->latest()
                                     ->limit(5)
                                     ->get();

        return view('pegawai.permintaan_persediaan', compact('persediaan', 'riwayat'));
    }

    public function storePermintaanPersediaan(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50', 
            'jumlah_diminta' => 'required|integer|min:1',
            'tanggal_permintaan' => 'required|date',
            'tanggal_dibutuhkan' => 'required|date|after_or_equal:tanggal_permintaan',
            'tujuan_penggunaan' => 'required|string|max:1000',
        ]);

        // ✅ CEK STOK BERDASARKAN KODE BARANG
        $persediaan = Persediaan::where('kode_barang', $request->kode_barang)->first();
        
        if (!$persediaan || $persediaan->jumlah < $request->jumlah_diminta) {
            return back()->withErrors([
                'kode_barang' => 'Stok tidak mencukupi atau barang tidak ditemukan!'
            ])->withInput();
        }

            PermintaanPersediaan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'kode_barang' => $request->kode_barang,           // ✅ GUNAKAN INI
            'nama_barang' => $persediaan->nama_barang,
            'persediaan_id' => $persediaan->id,               // ✅ AMBIL ID
            'user_id' => Auth::id(),
            'jumlah_diminta' => $request->jumlah_diminta,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'tujuan_penggunaan' => $request->tujuan_penggunaan,
            'status' => 'pending',
        ]);

        return redirect()->route('pegawai.permintaan-persediaan')
                ->with('success', 'Permintaan berhasil dikirim! Menunggu persetujuan Admin Persediaan.');
    }

     /**
     * Riwayat Permintaan
     */
    public function riwayatPermintaan(Request $request)
    {
        $query = PermintaanPersediaan::where('user_id', Auth::id())
                                   ->with('persediaan', 'reviewedBy', 'approvedByKasubag')
                                   ->latest();

        $riwayat = $query->paginate(10);
        
        return view('pegawai.permintaan_persediaan', compact('riwayat'));
    }

    /**
     * LIHAT DETAIL PERMINTAAN (AJAX)
     */
    public function detailPermintaanPersediaan($id)
    {
        try {
            $permintaan = PermintaanPersediaan::with(['persediaan', 'user', 'reviewedBy', 'approvedByKasubag'])
                                            ->findOrFail($id);

            // Pastikan hanya pemilik akun yang bisa melihat detailnya
            if ($permintaan->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke data ini.']);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $permintaan->id,
                    'kode' => 'REQ-' . str_pad($permintaan->id, 4, '0', STR_PAD_LEFT),
                    'nama_lengkap' => $permintaan->nama_lengkap,
                    'nama_barang' => $permintaan->nama_barang ?? '-',
                    'persediaan' => $permintaan->persediaan ? [
                        'nama_barang' => $permintaan->persediaan->nama_barang,
                        'kode_barang' => $permintaan->persediaan->kode_barang,
                        'kategori' => $permintaan->persediaan->kategori,
                        'jumlah' => $permintaan->persediaan->jumlah,
                    ] : null,
                    'jumlah_diminta' => $permintaan->jumlah_diminta,
                    
                    // Pengecekan aman agar tidak crash jika tanggal kosong
                    'tanggal_permintaan' => $permintaan->tanggal_permintaan ? \Carbon\Carbon::parse($permintaan->tanggal_permintaan)->format('d M Y') : '-',
                    'tanggal_dibutuhkan' => $permintaan->tanggal_dibutuhkan ? \Carbon\Carbon::parse($permintaan->tanggal_dibutuhkan)->format('d M Y') : '-',
                    'tujuan_penggunaan' => $permintaan->tujuan_penggunaan,
                    'status' => $permintaan->status,
                    
                    'status_label' => isset($permintaan->status_badge['text']) ? $permintaan->status_badge['text'] : ucfirst($permintaan->status),
                    'created_at' => $permintaan->created_at ? $permintaan->created_at->format('d M Y H:i') : '-',
                    
                    // Kita gunakan ->name (default Laravel), bukan ->nama
                    'admin_approved_by' => $permintaan->reviewedBy?->name ?? null,
                    'kasubag_approved_by' => $permintaan->approvedByKasubag?->name ?? null,
                    
                    'komentar_admin' => $permintaan->komentar ?? null,
                    'surat_path' => $permintaan->surat_url ? asset('storage/' . $permintaan->surat_url) : null,
                ]
            ]);
        } catch (\Exception $e) {
            // Ubah response code ke 200 agar pesan error ditangkap oleh Javascript dan dimunculkan di Toast Notifikasi
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage() . ' (Baris: ' . $e->getLine() . ' di ' . basename($e->getFile()) . ')'
            ], 200); 
        }
    }

    /**
     * BATALKAN / HAPUS PERMINTAAN (AJAX)
     */
    public function cancelPermintaanPersediaan($id)
    {
        $permintaan = PermintaanPersediaan::where('user_id', Auth::id())
                                        ->whereIn('status', ['pending']) // Hanya bisa batal jika status masih pending
                                        ->findOrFail($id);

        $permintaan->update([
            'status' => 'dibatalkan', // Status diubah menjadi dibatalkan
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan persediaan berhasil dibatalkan!'
        ]);
    }


    /**
     * Peminjaman Kendaraan - Daftar & Verifikasi
     */
    public function peminjamanKendaraan()
    {
        // Ambil data kendaraan dari aset tetap (Kategori Kendaraan)
        $kendaraan = AssetTetap::where('kategori', 'Kendaraan')
            ->where('status', 'Tersedia')
            ->get();

        $riwayat = PeminjamanKendaraan::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.peminjaman_kendaraan', compact('kendaraan', 'riwayat'));
    }

    public function storePeminjamanKendaraan(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|exists:aset_tetap,kode_barang',
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'deskripsi_peruntukan' => 'required|string',
        ]);

        $aset = AssetTetap::where('kode_barang', $request->kode_barang)->first();

        PeminjamanKendaraan::create([
            'user_id' => auth()->id(),
            'nama_barang' => $aset->nama_barang,
            'kode_barang' => $aset->kode_barang,
            'nup' => $aset->nup,
            'merek' => $aset->merek,
            'jumlah' => 1, // Kendaraan biasanya unit tunggal per request
            'request_date' => now(),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'deskripsi_peruntukan' => $request->deskripsi_peruntukan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan peminjaman kendaraan berhasil dikirim.');
    }

    public function cancelPeminjamanKendaraan($id)
    {
        $data = PeminjamanKendaraan::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();
        
        $data->delete();
        return response()->json(['success' => true]);
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