<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    AdminSarpras,
    Gedung,
    PengembalianGedung,
    PeminjamanGedung,
    Kerusakan,
    laporanKerusakan,
    laporanPeminjamanGedung,
    
};


class AdminSarprasController extends Controller
{
    public function dashboard()
    {
        return view('adminsarpras.dashbord');
        // // Statistics untuk dashboard
        // $stats = [
        //     'total_peminjaman' => PeminjamanGedung::count(),
        //     'peminjaman_aktif' => PeminjamanGedung::whereIn('status', ['dipinjam', 'terlambat'])->count(),
        //     'pengembalian_menunggu' => PengembalianGedung::where('status_verifikasi', 'menunggu')->count(),
        //     'pengembalian_selesai' => PengembalianGedung::where('status_verifikasi', 'disetujui')->count(),
        //     'total_denda' => PengembalianGedung::sum('denda_akhir'),
        // ];

        // $peminjaman_terbaru = PeminjamanGedung::with('pengembalian')
        //     ->whereIn('status', ['dipinjam', 'terlambat'])
        //     ->latest()
        //     ->limit(5)
        //     ->get();

        // $pengembalianGedung_menunggu = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
        //     ->where('status_verifikasi', 'menunggu')
        //     ->latest()
        //     ->limit(5)
        //     ->get();

        // return view('adminsarpras.dashboard', compact('stats', 'peminjaman_terbaru', 'pengembalian_menunggu'));
    }

    // DATA GEDUNG
    public function dataGedung(Request $request)
    {
        $query = Gedung::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_gedung', 'like', '%'.$request->search.'%')
                ->orWhere('lokasi', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('kategori')) {
        $query->kategori($request->kategori);
        }


        if ($request->filled('ketersediaan')) {
            $query->where('ketersediaan', $request->ketersediaan);
        }

        // ✅ KONSISTEN - $gedung untuk view
        $gedung = $query->latest()->paginate(10);
        
        $stats = [
            'total' => Gedung::count(),
            'tersedia' => Gedung::where('ketersediaan', 'Tersedia')->count(),
            'dipakai' => Gedung::where('ketersediaan', 'Sedang Dipakai')->count(),
            'renovasi' => Gedung::whereIn('ketersediaan', ['Renovasi', 'Perlu Perbaikan'])->count(),
        ];

        return view('adminsarpras.data_gedung', compact('gedung', 'stats'));
    }

    // Tambah gedung
    public function storeGedung(Request $request)
    {
        $validated = $request->validate([
        'nama_gedung' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'luas_bangunan' => 'required|string|max:100',
        'tarif_sewa' => 'required|integer|min:0',
        'kapasitas' => 'required|integer|min:1',
        'ketersediaan' => 'required|in:Tersedia,Sedang Dipakai,Renovasi,Perlu Perbaikan',
        'kategori' => 'required|in:ruang_sidang,mess,asrama,ruang_makan,aula,ruang_kelas',
        'fasilitas' => 'nullable|string|max:1000',
        'foto_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
        'nama_gedung' => $validated['nama_gedung'],
        'lokasi' => $validated['lokasi'],
        'luas_bangunan' => $validated['luas_bangunan'],
        'tarif_sewa' => $validated['tarif_sewa'],
        'kapasitas' => $validated['kapasitas'],
        'ketersediaan' => $validated['ketersediaan'],
        'kategori' => $validated['kategori'],
        'fasilitas' => $validated['fasilitas'] ?? null,
        ];

        //✅ UPLOAD FOTO TERpisah
        if ($request->hasFile('foto_url')) {
            $data['foto_url'] = $request->file('foto_url')->store('gedung_photos', 'public');
        }

        // ✅ SEKARANG AMAN
        $gedung = Gedung::create($data);

        return redirect()->route('adminsarpras.data-gedung')
            ->with('success', 'Gedung berhasil ditambahkan!');
    }

    // Edit gedung
    public function updateGedung(Request $request, Gedung $gedung)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'luas_bangunan' => 'required|string|max:100',
            'tarif_sewa' => 'required|integer|min:0',
            'kapasitas' => 'required|integer|min:1',
            'ketersediaan' => 'required|in:Tersedia,Sedang Dipakai,Renovasi,Perlu Perbaikan',
            'fasilitas' => 'nullable|string',
            'foto_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Update foto
        if ($request->hasFile('foto_url')) {
            // Hapus foto lama
            if ($gedung->foto_url && Storage::disk('public')->exists($gedung->foto_url)) {
                Storage::disk('public')->delete($gedung->foto_url);
            }
            $data['foto_url'] = $request->file('foto_url')->store('gedung_photos', 'public');
        }

        $gedung->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Gedung berhasil diupdate!'
        ]);
    }

    // Hapus gedung
    public function destroyGedung(Gedung $gedung)
    {
        // Hapus foto
        if ($gedung->foto_url && Storage::disk('public')->exists($gedung->foto_url)) {
            Storage::disk('public')->delete($gedung->foto_url);
        }

        $gedung->delete();

        return redirect()->back()->with('success', 'Gedung berhasil dihapus!');
    }

    // API untuk detail JSON
    public function showGedungJson(Gedung $gedung)
    {
        return response()->json([
            'id' => $gedung->id,
            'nama_gedung' => $gedung->nama_gedung,
            'foto_url' => $gedung->foto_url ? asset('storage/' . $gedung->foto_url) : null,
            'lokasi' => $gedung->lokasi,
            'luas_bangunan' => $gedung->luas_bangunan,
            'tarif_sewa' => $gedung->tarif_sewa,
            'kapasitas' => $gedung->kapasitas,
            'ketersediaan' => $gedung->ketersediaan,
            'fasilitas' => $gedung->fasilitas,
        ]);
    }


    //====DAFTAR PEMINJAMAN=========
    public function daftarPeminjaman(Request $request)
    {
        $query = PeminjamanGedung::with(['user', 'reviewer', 'approver'])
            ->orderBy('created_at', 'desc');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                ->orWhere('instansi_lembaga', 'like', '%'.$request->search.'%')
                ->orWhere('fasilitas', 'like', '%'.$request->search.'%')
                ->orWhere('nama_fasilitas', 'like', '%'.$request->search.'%');
            });
        }

        $peminjaman = $query->paginate(15);

        return view('adminsarpras.daftar_peminjaman', compact('peminjaman'));
    }
        public function approvePeminjaman(Request $request, PeminjamanGedung $peminjaman)
    {
        $peminjaman->update([
            'status' => 'disetujui',
            'reviewed_by_admin_id' => auth('adminsarpras')->id(),
            'tanggal_approval' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Peminjaman disetujui']);
    }

    public function rejectPeminjaman(Request $request, PeminjamanGedung $peminjaman)
    {
        $request->validate(['komentar' => 'required|string|max:1000']);
        
        $peminjaman->update([
            'status' => 'ditolak',
            'komentar' => $request->komentar,
            'reviewed_by_admin_id' => auth('adminsarpras')->id()
        ]);

        return response()->json(['success' => true, 'message' => 'Peminjaman ditolak']);
    }

    public function laporanPeminjamanGedung(Request $request)
    {
        $query = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
            ->orderBy('waktu_verifikasi', 'desc');

        // Filter bulan/tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('tanggal_pengembalian', $request->tahun)
                  ->whereMonth('tanggal_pengembalian', $request->bulan);
        }

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        $laporan = $query->paginate(20);

        $stats = [
            'total' => PengembalianGedung::count(),
            'baik' => PengembalianGedung::where('kondisi_gedung', 'baik')->count(),
            'ringan' => PengembalianGedung::where('kondisi_gedung', 'ringan')->count(),
            'rusak' => PengembalianGedung::where('kondisi_gedung', 'rusak')->count(),
            'total_denda' => PengembalianGedung::sum('denda_akhir')
        ];

        return view('adminsarpras.laporan_peminjaman_gedung', compact('laporan', 'stats'));
    }

    public function daftarPengembalian(Request $request)
    {
        $query = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
            ->orderBy('created_at', 'desc');

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        // Filter kondisi gedung
        if ($request->filled('kondisi_gedung')) {
            $query->where('kondisi_gedung', $request->kondisi_gedung);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('peminjaman', function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%'.$request->search.'%')
                  ->orWhere('nama_gedung', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi', 'like', '%'.$request->search.'%');
            });
        }

        $pengembalianGedung = $query->paginate(10);

        return view('adminsarpras.daftar_pengembalian', compact('pengembalianGedung'));
    }

    // public function pengaturanAkun()
    // {
    //     $admin = auth('adminsarpras')->user(); // Sesuaikan dengan guard auth
    //     return view('adminsarpras.pengaturan_akun', compact('admin'));
    // }

    // Method tambahan untuk verifikasi
    public function verifikasiPengembalian(Request $request, PengembalianGedung $pengembalianGedung)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000',
            'denda_akhir' => 'nullable|numeric|min:0'
        ]);

        $admin = auth('adminsarpras')->user();

        $pengembalianGedung->verifikasiOlehAdmin(
            $admin,
            $request->status_verifikasi,
            $request->catatan_verifikasi,
            $request->denda_akhir ?? 0
        );

        return redirect()->back()->with('success', 'Pengembalian berhasil diverifikasi!');
    }

    // Method untuk detail pengembalian
    public function showPengembalian(PengembalianGedung $pengembalianGedung)
    {
        $pengembalianGedung->load(['peminjaman', 'adminSarpras']);
        return view('adminsarpras.pengembalian_detail', compact('pengembalianGedung'));
    }

    // Method untuk cetak laporan
    public function cetakLaporan(PengembalianGedung $pengembalianGedung)
    {
        $pengembalianGedung->load(['peminjaman', 'adminSarpras']);
        // Logic cetak PDF atau print view
        return view('adminsarpras.cetak_laporan', compact('pengembalianGedung'));
    }

    // API untuk foto modal
    public function getPhotos(PengembalianGedung $pengembalianGedung)
    {
        return response()->json($pengembalianGedung->foto_kondisi ?? []);
    }

    /**
     * Daftar semua data kerusakan ✅ FIXED
     */
    public function dataKerusakan(Request $request)
    {
       $query = Kerusakan::query()
            ->orderBy('tanggal_input', 'desc')
            ->orderBy('id', 'desc');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('nup', 'like', '%'.$request->search.'%')
                  ->orWhere('lokasi', 'like', '%'.$request->search.'%');
            });
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // ✅ VARIABEL YANG BENAR: $kerusakans (plural)
        $kerusakans = $query->paginate(15);

        // ✅ STATS LENGKAP untuk dashboard laporan
        $stats = $this->getKerusakanStats();

        return view('adminsarpras.data_kerusakan', compact('kerusakans', 'stats'));
    }

    /**
     * Laporan kerusakan (halaman khusus dengan charts)
     */
    // public function laporanKerusakan(Request $request)
    // {
    //     $query = Kerusakan::query()
    //         ->orderBy('tanggal_input', 'desc');

    //     // Filter bulan/tahun
    //     if ($request->filled('bulan') && $request->filled('tahun')) {
    //         $query->whereYear('tanggal_input', $request->tahun)
    //               ->whereMonth('tanggal_input', $request->bulan);
    //     }

    //     // Filter kondisi
    //     if ($request->filled('kondisi')) {
    //         $query->where('kondisi', $request->kondisi);
    //     }

    //     // ✅ Pagination untuk laporan
    //     $kerusakans = $query->paginate(20);

    //     // ✅ Stats khusus laporan
    //     $stats = $this->getKerusakanStats();

    //     return view('adminsarpras.laporan_kerusakan', compact('kerusakans', 'stats'));
    // }

    /**
     * Hitung semua statistik kerusakan
     */
    private function getKerusakanStats()
    {
        $total = Kerusakan::count();

        // Stats kondisi
        $stats = [
            'baik' => Kerusakan::where('kondisi', 'Baik')->count(),
            'rusak_ringan' => Kerusakan::where('kondisi', 'Rusak Ringan')->count(),
            'rusak_berat' => Kerusakan::where('kondisi', 'Rusak Berat')->count(),
            'total' => $total,
        ];

        // Stats per lokasi (top 10)
        $lokasiStats = Kerusakan::select('lokasi')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN kondisi = 'Baik' THEN 1 ELSE 0 END) as baik")
            ->selectRaw("SUM(CASE WHEN kondisi = 'Rusak Ringan' THEN 1 ELSE 0 END) as rusak_ringan")
            ->selectRaw("SUM(CASE WHEN kondisi = 'Rusak Berat' THEN 1 ELSE 0 END) as rusak_berat")
            ->groupBy('lokasi')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $stats['lokasi'] = [];
        foreach ($lokasiStats as $item) {
            $stats['lokasi'][$item->lokasi] = [
                'total' => (int) $item->total,
                'baik' => (int) $item->baik,
                'rusak_ringan' => (int) $item->rusak_ringan,
                'rusak_berat' => (int) $item->rusak_berat,
            ];
        }

        // Lokasi terbanyak
        $lokasiTerbanyak = $lokasiStats->first();
        $stats['lokasi_terbanyak'] = $lokasiTerbanyak ? [
            'lokasi' => $lokasiTerbanyak->lokasi,
            'count' => (int) $lokasiTerbanyak->total
        ] : ['lokasi' => '—', 'count' => 0];

        return $stats;
    }

    /**
     * Simpan data kerusakan baru (via form/modal)
     */
    public function storeKerusakan(Request $request)
    {
        $validated = $request->validate([
            'tanggal_input' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:kerusakan,kode_barang',
            'nup' => 'nullable|string|max:100',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kerusakan_photos', 'public');
        }

        Kerusakan::create($validated);

        return redirect()->route('adminsarpras.data-kerusakan')
            ->with('success', 'Data kerusakan berhasil ditambahkan!');
    }

    /**
     * Update data kerusakan (AJAX untuk modal)
     */
    public function updateKerusakanAjax(Request $request, $id)
    {
        $kerusakan = Kerusakan::findOrFail($id);

        $validated = $request->validate([
            'tanggal_input' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:kerusakan,kode_barang,' . $id,
            'nup' => 'nullable|string|max:100',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($kerusakan->foto && Storage::disk('public')->exists($kerusakan->foto)) {
                Storage::disk('public')->delete($kerusakan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kerusakan_photos', 'public');
        }

        $kerusakan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate!'
        ]);
    }

    /**
     * Hapus data kerusakan
     */
    public function destroyKerusakan($id)
    {
        $kerusakan = Kerusakan::findOrFail($id);
        
        // Hapus foto
        if ($kerusakan->foto && Storage::disk('public')->exists($kerusakan->foto)) {
            Storage::disk('public')->delete($kerusakan->foto);
        }
        
        $kerusakan->delete();

        return redirect()->route('adminsarpras.data-kerusakan')
            ->with('success', 'Data kerusakan berhasil dihapus!');
    }

    /**
     * API untuk modal EDIT (JSON)
     */
    public function editKerusakanJson($id)
    {
        $kerusakan = Kerusakan::findOrFail($id);
        $kerusakan->foto_url = $kerusakan->foto ? asset('storage/' . $kerusakan->foto) : null;
        return response()->json($kerusakan);
    }

    /**
     * API untuk modal DETAIL (JSON)
     */
    public function showKerusakanJson($id)
    {
        $kerusakan = Kerusakan::findOrFail($id);
        $kerusakan->foto_url = $kerusakan->foto ? asset('storage/' . $kerusakan->foto) : null;
        $kerusakan->tanggal_input_formatted = $kerusakan->tanggal_input->locale('id')->isoFormat('D MMMM Y');
        return response()->json($kerusakan);
    }

    /**
     * Laporan kerusakan (statistik bulanan/tahunan)
     */
    public function laporanKerusakan(Request $request)
    {
        $query = Kerusakan::query();

        // Filter bulan/tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('tanggal_input', $request->tahun)
                  ->whereMonth('tanggal_input', $request->bulan);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $laporan = $query->latest()->paginate(20);

        $stats = [
            'total' => Kerusakan::count(),
            'per_kondisi' => Kerusakan::selectRaw('kondisi, count(*) as total')
                ->groupBy('kondisi')
                ->pluck('total', 'kondisi'),
            'per_lokasi' => Kerusakan::selectRaw('lokasi, count(*) as total')
                ->groupBy('lokasi')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('total', 'lokasi')
        ];

        $kerusakans = $query->latest()->paginate(20); // ✅ Plural
        $stats = $this->getKerusakanStats();

        return view('adminsarpras.laporan_kerusakan', compact('kerusakans', 'stats'));
    }

    /**
     * Export data kerusakan ke Excel/CSV (opsional)
     */
    public function exportKerusakan(Request $request)
    {
        $kerusakans = Kerusakan::filterKondisi($request->kondisi)
            ->search($request->search)
            ->get();

        // Logic export menggunakan Laravel Excel atau Maatwebsite
        return response()->json([
            'message' => 'Export berhasil',
            'data' => $kerusakans
        ]);
    }
}