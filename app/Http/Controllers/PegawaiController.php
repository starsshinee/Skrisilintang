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
        $userId = Auth::id();

        // 1. Ambil Statistik Peminjaman Barang (Milik Pegawai)
        $statBarang = PeminjamanBarang::where('user_id', $userId)->count();
        $barangPending = PeminjamanBarang::where('user_id', $userId)
            ->whereIn('status', ['pending', 'diteruskan_kasubag'])->count();
        $barangSetuju = PeminjamanBarang::where('user_id', $userId)->where('status', 'disetujui')->count();

        // 2. Ambil Statistik Peminjaman Kendaraan
        $statKendaraan = PeminjamanKendaraan::where('user_id', $userId)->count();
        $kendaraanPending = PeminjamanKendaraan::where('user_id', $userId)->where('status', 'pending')->count();
        $kendaraanSetuju = PeminjamanKendaraan::where('user_id', $userId)->where('status', 'disetujui')->count();

        // 3. (Gedung & Persediaan diset 0 atau sesuaikan dengan model Anda nanti)
        $statGedung = 0; $gedungPending = 0; $gedungSetuju = 0;
        $statPersediaan = 0; $persediaanPending = 0; $persediaanSetuju = 0;

        // 4. Riwayat Terbaru (Hanya 5 Terakhir)
        $riwayatBarang = PeminjamanBarang::where('user_id', $userId)
            ->latest()->take(5)->get()->map(function($item) {
                return [
                    'tipe' => 'Barang',
                    'nama_item' => $item->nama_barang, // Asumsi nama kolomnya nama_barang
                    'status' => $item->status,
                    'tanggal' => $item->created_at
                ];
            });

        
        $riwayatKendaraan = PeminjamanKendaraan::where('user_id', $userId)
            ->latest()->take(5)->get()->map(function($item) {
                return [
                    'tipe' => 'Kendaraan',
                    'nama_item' => $item->merek ?? $item->nama_barang ?? 'Kendaraan Dinas', // Ambil langsung
                    'status' => $item->status,
                    'tanggal' => $item->created_at
                ];
            });

        // Gabungkan riwayat, lalu urutkan dari yang terbaru, dan ambil 5 teratas
        $riwayatTerbaru = collect($riwayatBarang)
            ->merge($riwayatKendaraan)
            ->sortByDesc('tanggal')
            ->take(5);

        return view('pegawai.dashbord', compact(
            'statBarang', 'barangPending', 'barangSetuju',
            'statKendaraan', 'kendaraanPending', 'kendaraanSetuju',
            'statGedung', 'gedungPending', 'gedungSetuju',
            'statPersediaan', 'persediaanPending', 'persediaanSetuju',
            'riwayatTerbaru'
        ));
    
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

    public function pengembalianBarang()
    {
        // Mengambil barang yang sedang dipinjam dan disetujui (Belum dikembalikan sepenuhnya)
        $peminjamanAktif = PeminjamanBarang::where('user_id', auth()->id())
            ->whereIn('status', ['disetujui', 'disetujui_admin', 'disetujui_kasubag'])
            ->get();

        // Mengambil riwayat pengembalian pegawai
        $riwayat = PengembalianBarang::with('peminjamanBarang')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.pengembalian_barang', compact('peminjamanAktif', 'riwayat'));
    }

    public function getPeminjamanJson($id)
    {
        $peminjaman = PeminjamanBarang::with('barang')->find($id);
        return response()->json($peminjaman);
    }

    public function storePengembalianBarang(Request $request)
    {
        $request->validate([
            'peminjaman_barang_id' => 'required|exists:peminjaman_barang,id',
            'tanggal_pengembalian_aktual' => 'required|date',
            'jumlah_dikembalikan' => 'required|integer|min:1',
            'kondisi_barang' => 'required|string',
            'foto_sesudah' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peminjaman = PeminjamanBarang::findOrFail($request->peminjaman_barang_id);

        // Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto_sesudah')) {
            $fotoPath = $request->file('foto_sesudah')->store('foto_pengembalian', 'public');
        }

        // Mapping Kondisi ke enum status_pengembalian
        $statusMap = [
            'baik' => 'lengkap',
            'rusak-ringan' => 'rusak_ringan',
            'rusak-berat' => 'rusak_berat',
            'hilang' => 'hilang'
        ];

        PengembalianBarang::create([
            'peminjaman_barang_id' => $request->peminjaman_barang_id,
            'user_id' => auth()->id(),
            'tanggal_pengembalian_aktual' => $request->tanggal_pengembalian_aktual . ' ' . ($request->jam_pengembalian ?? '00:00:00'),
            'jumlah_dikembalikan' => $request->jumlah_dikembalikan,
            'kondisi_barang' => $request->kondisi_barang,
            'status_pengembalian' => $statusMap[$request->kondisi_barang] ?? 'lengkap',
            'catatan' => $request->catatan,
            'foto_sesudah' => $fotoPath,
            'status_verifikasi' => 'pending',
        ]);

        // Ubah status peminjaman agar tidak bisa dikembalikan 2x jika jumlah penuh
        if ($request->jumlah_dikembalikan >= $peminjaman->jumlah) {
            $peminjaman->update(['status' => 'proses_pengembalian']);
        }

        return back()->with('success', 'Laporan pengembalian berhasil dikirim dan menunggu verifikasi Admin!');
    }

    public function showPengembalianJson($id)
    {
        $data = PengembalianBarang::with('peminjamanBarang')->find($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function cancelPengembalian($id)
    {
        $pengembalian = PengembalianBarang::findOrFail($id);
        if ($pengembalian->status_verifikasi === 'pending') {
            // Kembalikan status peminjaman
            $pengembalian->peminjamanBarang->update(['status' => 'disetujui']);
            $pengembalian->delete();
            return back()->with('success', 'Laporan pengembalian berhasil dibatalkan.');
        }
        return back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat dibatalkan.');
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

    public function show($id)
    {
        // Pastikan menambahkan ->with('user')
        $permintaan = PermintaanPersediaan::with(['persediaan', 'user'])->find($id);

        if (!$permintaan) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'data' => $permintaan
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
            'kode_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'deskripsi_peruntukan' => 'required|string',
        ]);

        // Ambil detail aset dari database berdasarkan kode_barang yang dipilih
        $aset = AssetTetap::where('kode_barang', $request->kode_barang)->first();

        PeminjamanKendaraan::create([
            'user_id' => auth()->id(),
            'nama_barang' => $aset->nama_barang,
            'kode_barang' => $aset->kode_barang,
            'nup' => $aset->nup,
            'merek' => $aset->merek,
            'jumlah' => $request->jumlah,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'deskripsi_peruntukan' => $request->deskripsi_peruntukan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    public function showPeminjamanKendaraan($id)
    {
        // Mengambil data peminjaman beserta informasi user terkait
        $data = PeminjamanKendaraan::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
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

    public function pengembalianKendaraan()
    {
        // 1. Ambil peminjaman langsung tanpa with('kendaraan')
        $peminjamanKendaraan = \App\Models\PeminjamanKendaraan::where('user_id', auth()->id())
            ->whereIn('status', ['disetujui']) // Sesuaikan status peminjaman yang bisa dikembalikan
            ->get();

        // 2. Ambil riwayat pengembalian, cukup panggil 'peminjamanKendaraan'
        $pengembalianKendaraan = \App\Models\PengembalianKendaraan::with('peminjamanKendaraan')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.pengembalian_kendaraan', compact('peminjamanKendaraan', 'pengembalianKendaraan'));
    }

    public function getPeminjamanKendaraanJson($id)
    {
        $peminjaman = PeminjamanKendaraan::find($id);
        return response()->json($peminjaman);
    }

    public function storePengembalianKendaraan(Request $request)
    {
        $request->validate([
            'peminjaman_kendaraan_id' => 'required|exists:peminjaman_kendaraan,id',
            'tanggal_pengembalian_aktual' => 'required|date',
            'kondisi_kendaraan' => 'required|string',
            'foto_sebelum' => 'required|image|max:2048',
            'foto_sesudah' => 'required|image|max:2048',
        ]);

        $peminjaman = PeminjamanKendaraan::findOrFail($request->peminjaman_kendaraan_id);

        // ✅ PENCEGAHAN DOUBLE SUBMIT: 
        // Tolak jika status kendaraan sudah dalam proses pengembalian atau sudah selesai
        if (in_array($peminjaman->status, ['proses_pengembalian', 'selesai', 'diterima'])) {
            return back()->withErrors(['Kendaraan ini sudah dilaporkan untuk dikembalikan.']);
        }

        // Upload Foto
        $fotoSebelum = $request->file('foto_sebelum')->store('pengembalian_kendaraan/sebelum', 'public');
        $fotoSesudah = $request->file('foto_sesudah')->store('pengembalian_kendaraan/sesudah', 'public');

        PengembalianKendaraan::create([
            'peminjaman_kendaraan_id' => $request->peminjaman_kendaraan_id,
            'user_id' => auth()->id(),
            'tanggal_pengembalian_aktual' => $request->tanggal_pengembalian_aktual,
            'kondisi_kendaraan' => $request->kondisi_kendaraan,
            'catatan' => $request->catatan,
            'foto_sebelum' => $fotoSebelum,
            'foto_sesudah' => $fotoSesudah,
            'status_pengembalian' => 'diproses',
            'biaya_denda' => 0 // Bisa disesuaikan logikanya nanti
        ]);

        // ✅ UBAH STATUS PEMINJAMAN
        // Agar kendaraan hilang dari opsi dropdown "Pilih Kendaraan yang Dikembalikan"
        $peminjaman->update(['status' => 'proses_pengembalian']);

        return back()->with('success', 'Laporan pengembalian kendaraan berhasil dikirim!');
    }

    public function showPengembalianKendaraanJson($id)
    {
        $data = PengembalianKendaraan::with('peminjamanKendaraan')->find($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function cancelPengembalianKendaraan($id)
    {
        $pengembalian = PengembalianKendaraan::findOrFail($id);
        if ($pengembalian->status_pengembalian === 'diproses') {
            $pengembalian->peminjamanKendaraan->update(['status' => 'disetujui']);
            $pengembalian->delete();
            return back()->with('success', 'Laporan pengembalian berhasil dibatalkan.');
        }
        return back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat dibatalkan.');
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

    public function infoMutasi()
    {
        // Mengambil data mutasi barang yang statusnya sudah disetujui/selesai
        // Disertai dengan informasi barang terkait
        $mutasiBarang = \App\Models\MutasiBarang::with(['asetTetap', 'user'])
            ->orderBy('tanggal_mutasi', 'desc')
            ->paginate(10);

        return view('pegawai.info_mutasibarang', compact('mutasiBarang'));
    }
}