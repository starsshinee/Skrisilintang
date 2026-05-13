<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    PeminjamanGedung,
    PermintaanPersediaan,
    PeminjamanBarang,
    PengembalianBarang,
    PeminjamanKendaraan,
    PengembalianKendaraan
};

class KasubagController extends Controller
{
    public function dashboard()
    {
        // 1. Hitung Statistik Barang
        $barangTotal = PeminjamanBarang::count();
        $barangPending = PeminjamanBarang::where('status', 'diteruskan_kasubag')->count();
        $barangSetuju = PeminjamanBarang::where('status', 'disetujui')->count();
        $barangTolak = PeminjamanBarang::where('status', 'ditolak')->count();

        // 2. Hitung Statistik Kendaraan
        $kendaraanTotal = PeminjamanKendaraan::count();
        $kendaraanPending = PeminjamanKendaraan::where('status', 'pending')->count(); 
        $kendaraanSetuju = PeminjamanKendaraan::where('status', 'disetujui')->count();
        $kendaraanTolak = PeminjamanKendaraan::where('status', 'ditolak')->count();

        // 3. Hitung Statistik Gedung (✅ DIPERBAIKI)
        $gedungTotal = PeminjamanGedung::count();
        $gedungPending = PeminjamanGedung::where('status', 'dalam_review')->count(); // Status menunggu verifikasi Kasubag
        $gedungSetuju = PeminjamanGedung::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count();
        $gedungTolak = PeminjamanGedung::where('status', 'ditolak')->count();

        // 4. Hitung Statistik Persediaan (✅ DIPERBAIKI)
        $persediaanTotal = PermintaanPersediaan::count();
        $persediaanPending = PermintaanPersediaan::whereIn('status', ['pending', 'diproses'])->count();
        $persediaanSetuju = PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count();
        $persediaanTolak = PermintaanPersediaan::where('status', 'ditolak')->count();

        // 5. Gabungkan Total Keseluruhan
        $totalPending = $barangPending + $kendaraanPending + $gedungPending + $persediaanPending;
        $totalDisetujui = $barangSetuju + $kendaraanSetuju + $gedungSetuju + $persediaanSetuju;
        $totalDitolak = $barangTolak + $kendaraanTolak + $gedungTolak + $persediaanTolak;
        $totalPermintaan = $barangTotal + $kendaraanTotal + $gedungTotal + $persediaanTotal;

        // 6. Ambil Data Pending Terbaru untuk di List (Mapping menjadi format seragam)
        $recentBarang = PeminjamanBarang::with('user')->where('status', 'diteruskan_kasubag')->latest()->take(3)->get()->map(function($item) {
            return ['tipe' => 'Barang', 'nama_item' => $item->nama_barang, 'nama_peminjam' => $item->user->name ?? 'Tamu/Pegawai', 'tanggal' => $item->created_at];
        });

        $recentKendaraan = PeminjamanKendaraan::with(['kendaraan', 'user'])->where('status', 'pending')->latest()->take(3)->get()->map(function($item) {
            return ['tipe' => 'Kendaraan', 'nama_item' => $item->kendaraan->merek ?? 'Kendaraan', 'nama_peminjam' => $item->user->name ?? 'Tamu/Pegawai', 'tanggal' => $item->created_at];
        });

        $recentGedung = PeminjamanGedung::where('status', 'dalam_review')->latest()->take(3)->get()->map(function($item) {
            return ['tipe' => 'Gedung', 'nama_item' => $item->nama_fasilitas ?? $item->fasilitas, 'nama_peminjam' => $item->nama_lengkap, 'tanggal' => $item->created_at];
        });

        $recentPersediaan = PermintaanPersediaan::with(['user', 'persediaan'])->whereIn('status', ['pending', 'diproses'])->latest()->take(3)->get()->map(function($item) {
            return ['tipe' => 'Persediaan', 'nama_item' => $item->persediaan->nama_barang ?? $item->nama_barang ?? 'Barang', 'nama_peminjam' => $item->user->name ?? $item->nama_lengkap ?? 'Tamu/Pegawai', 'tanggal' => $item->created_at];
        });

        // Gabungkan semua koleksi, urutkan berdasarkan tanggal terbaru, dan ambil 5 data paling atas
        $recentPending = collect($recentBarang)
            ->merge($recentKendaraan)
            ->merge($recentGedung)
            ->merge($recentPersediaan)
            ->sortByDesc('tanggal')
            ->take(5);

        // 7. Kirim data ke View
        return view('kasubag.dashbord', compact(
            'totalPending', 'totalDisetujui', 'totalDitolak', 'totalPermintaan',
            'barangTotal', 'barangPending',
            'kendaraanTotal', 'kendaraanPending',
            'gedungTotal', 'gedungPending',
            'persediaanTotal', 'persediaanPending',
            'recentPending'
        ));
    }

    public function persetujuanPeminjamanGedung(Request $request)
    {
       $query = PeminjamanGedung::with(['user', 'reviewer'])
            ->whereIn('status', ['dalam_review', 'disetujui_kasubag'])
            ->orderBy('diteruskan_ke_kasubag_date', 'desc');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi_lembaga', 'like', '%'.$request->search.'%');
            });
        }

        $peminjaman = $query->paginate(15);

        return view('kasubag.persetujuan_peminjaman_gedung', compact('peminjaman'));
    }

    // Approve oleh Kasubag
    // Fix approve method - tambahkan CSRF handling
    public function approveByKasubag(Request $request, PeminjamanGedung $peminjaman)
    {
        $request->validate(['komentar' => 'nullable|string|max:1000']);

        // Cek apakah masih dalam review
        if ($peminjaman->status !== 'dalam_review') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah diproses sebelumnya!'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'disetujui_kasubag', // Ubah ke status yang sesuai model
            'approved_by_kasubag_id' => auth()->id(),
            'approved_by_kasubag_date' => now(),
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil disetujui!'
        ]);
    }

    public function rejectByKasubag(Request $request, PeminjamanGedung $peminjaman)
    {
        $request->validate(['komentar' => 'required|string|max:1000']);

        if ($peminjaman->status !== 'dalam_review') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah diproses sebelumnya!'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'ditolak_kasubag',
            'approved_by_kasubag_id' => auth()->id(),
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil ditolak!'
        ]);
    }


    // Download surat untuk Kasubag
    public function downloadSurat(PeminjamanGedung $peminjaman)
    {
        if (!$peminjaman->surat_path || !Storage::disk('public')->exists($peminjaman->surat_path)) {
        return back()->with('error', 'Surat peminjaman tidak ditemukan!');
    }

    $filePath = storage_path('app/public/' . $peminjaman->surat_path);
    $originalName = pathinfo($peminjaman->surat_path, PATHINFO_BASENAME);
    $downloadName = "Surat_Peminjaman_{$peminjaman->nama_lengkap}_{$peminjaman->id}." . 
                    pathinfo($originalName, PATHINFO_EXTENSION);

    return response()->download($filePath, $downloadName);
    }

    // Method untuk detail JSON (API)
    public function show(PeminjamanGedung $peminjaman)
    {
        $peminjaman->load(['user', 'gedung', 'reviewer', 'approver']);
        
        return response()->json([
            'id' => $peminjaman->id,
            'gedung' => $peminjaman->gedung ? [
                'nama_gedung' => $peminjaman->gedung->nama_gedung,
                'lokasi' => $peminjaman->gedung->lokasi,
            ] : null,
            'nama_lengkap' => $peminjaman->nama_lengkap,
            'nip_nik' => $peminjaman->nip_nik,
            'instansi_lembaga' => $peminjaman->instansi_lembaga,
            'kabupaten_kota' => $peminjaman->kabupaten_kota,
            'fasilitas' => $peminjaman->fasilitas,
            'nama_fasilitas' => $peminjaman->nama_fasilitas,
            'tarif_per_hari' => $peminjaman->tarif_per_hari,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
            'jam_mulai' => $peminjaman->jam_mulai,
            'jam_selesai' => $peminjaman->jam_selesai,
            'lama_peminjaman_hari' => $peminjaman->lama_peminjaman_hari,
            'total_pembayaran' => $peminjaman->total_pembayaran,
            'tujuan_penggunaan' => $peminjaman->tujuan_penggunaan,
            'nomor_kontak' => $peminjaman->nomor_kontak,
            'status' => $peminjaman->status,
            'status_text' => $peminjaman->status_text,
            'komentar' => $peminjaman->komentar,
            'reviewer' => $peminjaman->reviewer ? ['name' => $peminjaman->reviewer->name] : null,
            'diteruskan_ke_kasubag_date' => $peminjaman->diteruskan_ke_kasubag_date,
            'surat_url' => $peminjaman->surat_url,
            'created_at' => $peminjaman->created_at->toISOString(),
        ]);
    }

    //PEMINJAMAN BARANG
    // ====================================================================
    // PEMINJAMAN BARANG (ASET TETAP)
    // ====================================================================
    
    public function persetujuanPeminjamanBarang(Request $request)
    {
        // 1. Hitung Statistik Ringkasan
        $stats = [
            'menunggu'  => \App\Models\PeminjamanBarang::where('status', 'diteruskan_kasubag')->count(),
            'disetujui' => \App\Models\PeminjamanBarang::where('status', 'disetujui')->count(),
            'total'     => \App\Models\PeminjamanBarang::whereIn('status', ['diteruskan_kasubag', 'disetujui', 'ditolak'])->count()
        ];

        // 2. Tampilkan semua data yang sudah sampai ke tahap Kasubag
        $query = \App\Models\PeminjamanBarang::with('user')
            ->whereIn('status', ['diteruskan_kasubag', 'disetujui', 'ditolak'])
            ->orderByRaw("FIELD(status, 'diteruskan_kasubag') DESC") // Prioritaskan yang butuh review di atas
            ->orderBy('diteruskan_ke_kasubag_date', 'desc');

        $peminjaman = $query->paginate(15);

        return view('kasubag.persetujuan_peminjaman_barang', compact('peminjaman', 'stats'));
    }

    // FITUR BARU: Ambil Detail Peminjaman Barang via AJAX
    public function detailPeminjamanBarang($id)
    {
        $peminjaman = \App\Models\PeminjamanBarang::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true, 
            'data' => $peminjaman
        ]);
    }

    public function approvePeminjamanBarang(Request $request, $id)
    {
        // Temukan data peminjaman
        $peminjaman = \App\Models\PeminjamanBarang::findOrFail($id);

        if ($request->action == 'setuju') {
            // 🔥 GUNAKAN CARA MANUAL (FORCE SAVE)
            $peminjaman->status = 'disetujui';
            $peminjaman->approved_by_kasubag_id = auth()->id();
            $peminjaman->approved_by_kasubag_date = now();
            $peminjaman->save(); // Simpan paksa mengabaikan fillable/guarded

            $pesan = 'Peminjaman berhasil disetujui.';
            
        } elseif ($request->action == 'tolak') {
            // 🔥 CARA MANUAL UNTUK TOLAK
            $peminjaman->status = 'ditolak';
            $peminjaman->approved_by_kasubag_id = auth()->id();
            $peminjaman->approved_by_kasubag_date = now();
            $peminjaman->komentar = $request->komentar;
            $peminjaman->save(); // Simpan paksa mengabaikan fillable/guarded

            $pesan = 'Peminjaman berhasil ditolak.';
        }

        return back()->with('success', $pesan);
    }

     //PEMINJAMAN KENDARAAN
    public function persetujuanPeminjamanKendaraan()
    {
        // Mengambil data peminjaman kendaraan yang relevan untuk Kasubag
        // (yang sedang direview, sudah disetujui, atau ditolak)
        $peminjaman = PeminjamanKendaraan::with('user')
            ->whereIn('status', ['dalam_review', 'disetujui', 'ditolak'])
            ->orderByRaw("FIELD(status, 'dalam_review', 'disetujui', 'ditolak')")
            ->orderBy('created_at', 'desc')
            ->get();

        // Menghitung statistik untuk ringkasan kartu di tampilan
        $stats = [
            'menunggu' => PeminjamanKendaraan::where('status', 'dalam_review')->count(),
            'disetujui' => PeminjamanKendaraan::where('status', 'disetujui')->count(),
            'total' => $peminjaman->count(),
        ];

        return view('kasubag.persetujuan_peminjaman_kendaraan', compact('peminjaman', 'stats'));
    }

    public function approveKendaraan(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:setuju,tolak'
        ]);

        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        if ($request->action === 'setuju') {
            $peminjaman->status = 'disetujui';
            $pesan = 'Peminjaman kendaraan berhasil disetujui.';
        } else {
            $peminjaman->status = 'ditolak';
            $pesan = 'Peminjaman kendaraan telah ditolak.';
        }

        // Menyimpan jejak persetujuan Kasubag
        $peminjaman->approved_by_kasubag_id = auth()->id();
        $peminjaman->approved_by_kasubag_date = now();
        $peminjaman->save();

        return back()->with('success', $pesan);
    }

    public function showJsonKendaraan($id)
    {
        // Mengambil data beserta relasi user
        $data = PeminjamanKendaraan::with('user')->find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

     
    //PERMINTAAN PERSEDIAAN
    public function persetujuanPermintaanPersediaan()
    {
        $stats = [
            'menunggu' => PermintaanPersediaan::where('status', 'dalam_review')->count(),
            'disetujui' => PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
            'total' => PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag', 'ditolak', 'ditolak_kasubag'])->count()
        ];

        $permintaan = PermintaanPersediaan::with(['user', 'persediaan'])
                    ->whereIn('status', ['dalam_review', 'disetujui', 'disetujui_kasubag', 'ditolak', 'ditolak_kasubag'])
                    ->orderByRaw("CASE WHEN status = 'dalam_review' THEN 1 ELSE 2 END") // Yang belum direview ditaruh paling atas
                    ->latest()
                    ->get();

        // BENAR: Gunakan compact('permintaan') untuk mengirim data
        return view('kasubag.persetujuan_permintaan_persediaan', compact('permintaan', 'stats'));
    }

    public function approvePermintaan(Request $request, PermintaanPersediaan $permintaan)
    {
        if (!in_array($permintaan->status, ['dalam_review', 'disetujui_kasubag'])) {
            return back()->with('error', 'Permintaan tidak valid untuk diproses!');
        }

        if ($request->action === 'setuju') {
            $permintaan->update([
                'status' => 'disetujui',
                'approved_by_kasubag_id' => Auth::id(),
            ]);
        } else {
            $permintaan->update([
                'status' => 'ditolak',
                'approved_by_kasubag_id' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Permintaan berhasil diproses!');
    }

    /**
     * Menampilkan Detail Permintaan Persediaan untuk Kasubag
     */
    public function showPermintaan($id)
    {
        // Ambil data beserta relasinya
        $permintaan = PermintaanPersediaan::with(['persediaan', 'user', 'reviewedBy', 'approvedByKasubag'])
                        ->findOrFail($id);

        return view('kasubag.detail_permintaan_persediaan', compact('permintaan'));
    }

    public function pengaturanAkun()
    {
        // Logika untuk menampilkan pengaturan akun
        return view('kasubag.pengaturan_akun');
    }
}