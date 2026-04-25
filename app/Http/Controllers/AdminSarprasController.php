<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    AdminSarpras,
    PengembalianGedung,
    PeminjamanGedung,
    Kerusakan
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

    public function dataGedung()
    {
        // Data master gedung yang bisa dipinjam
        $gedung = []; // Bisa dari model Gedung jika ada
        return view('adminsarpras.data_gedung', compact('gedung'));
    }

    public function daftarPeminjaman(Request $request)
    {
        $query = PeminjamanGedung::with('pengembalian');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter terlambat
        if ($request->boolean('terlambat')) {
            $query->where('status', 'terlambat');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%'.$request->search.'%')
                  ->orWhere('nama_gedung', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi', 'like', '%'.$request->search.'%');
            });
        }

        $peminjaman = $query->paginate(15);

        return view('adminsarpras.daftar_peminjaman', compact('peminjaman'));
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

    public function pengaturanAkun()
    {
        $admin = auth('admin_sarpras')->user(); // Sesuaikan dengan guard auth
        return view('adminsarpras.pengaturan_akun', compact('admin'));
    }

    // Method tambahan untuk verifikasi
    public function verifikasiPengembalian(Request $request, PengembalianGedung $pengembalianGedung)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000',
            'denda_akhir' => 'nullable|numeric|min:0'
        ]);

        $admin = auth('admin_sarpras')->user();

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
        $query = Kerusakan::query();  // ✅ Kerusakan (PascalCase)

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%'.$request->lokasi.'%');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('nup', 'like', '%'.$request->search.'%')
                  ->orWhere('lokasi', 'like', '%'.$request->search.'%');
            });
        }

        $kerusakans = $query->latest()->paginate(15);

        $stats = [
            'total' => Kerusakan::count(),
            'baik' => Kerusakan::where('kondisi', 'Baik')->count(),
            'rusak_ringan' => Kerusakan::where('kondisi', 'Rusak Ringan')->count(),
            'rusak_sedang' => Kerusakan::where('kondisi', 'Rusak Sedang')->count(),
            'rusak_berat' => Kerusakan::whereIn('kondisi', ['Rusak Berat', 'Hancur'])->count(),
        ];

        return view('adminsarpras.data_kerusakan', compact('kerusakans', 'stats'));
    }

    /**
     * Form tambah data kerusakan
     */
        public function createKerusakan()
        {
            return view('adminsarpras.tambah_kerusakan');
        }

    public function tambahKerusakan()
    {
        return view('adminsarpras.tambah-kerusakan');
    }

    /**
     * Simpan data kerusakan baru
     */
    public function storeKerusakan(Request $request)
    {
        $request->validate([
            'tanggal_input' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:kerusakans,kode_barang',
            'nup' => 'required|string|max:100|unique:kerusakans,nup',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat,Hancur',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kerusakan_photos', 'public');
        }

        Kerusakan::create($data);

        return redirect()->route('admin.sarpras.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil ditambahkan!');
    }

    /**
     * Edit data kerusakan
     */
    public function editKerusakan(Kerusakan $kerusakan)
    {
        return view('adminsarpras.edit_kerusakan', compact('kerusakan'));
    }

    /**
     * Update data kerusakan
     */
    public function updateKerusakan(Request $request, Kerusakan $kerusakan)
    {
        $request->validate([
            'tanggal_input' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:kerusakans,kode_barang,' . $kerusakan->id,
            'nup' => 'required|string|max:100|unique:kerusakans,nup,' . $kerusakan->id,
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat,Hancur',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($kerusakan->foto && file_exists(storage_path('app/public/' . $kerusakan->foto))) {
                unlink(storage_path('app/public/' . $kerusakan->foto));
            }
            $data['foto'] = $request->file('foto')->store('kerusakan_photos', 'public');
        }

        $kerusakan->update($data);

        return redirect()->route('admin.sarpras.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil diupdate!');
    }

    /**
     * Hapus data kerusakan
     */
    public function destroyKerusakan(Kerusakan $kerusakan)
    {
        // Hapus foto
        if ($kerusakan->foto && file_exists(storage_path('app/public/' . $kerusakan->foto))) {
            unlink(storage_path('app/public/' . $kerusakan->foto));
        }

        $kerusakan->delete();

        return redirect()->route('admin.sarpras.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil dihapus!');
    }

    /**
     * Detail data kerusakan
     */
    public function showKerusakan(Kerusakan $kerusakan)
    {
        return view('adminsarpras.detail_kerusakan', compact('kerusakan'));
    }

    /**
 * API untuk load data edit (JSON)
 */
public function editKerusakanJson(Kerusakan $kerusakan)
{
    return response()->json([
        'id' => $kerusakan->id,
        'tanggal_input' => $kerusakan->tanggal_input,
        'nama_barang' => $kerusakan->nama_barang,
        'kode_barang' => $kerusakan->kode_barang,
        'nup' => $kerusakan->nup,
        'kondisi' => $kerusakan->kondisi,
        'lokasi' => $kerusakan->lokasi,
        'deskripsi' => $kerusakan->deskripsi,
        'foto' => $kerusakan->foto,
        'foto_url' => $kerusakan->foto ? asset('storage/' . $kerusakan->foto) : null,
    ]);
}

/**
 * API untuk detail data (JSON)
 */
public function showKerusakanJson(Kerusakan $kerusakan)
{
    return response()->json([
        'id' => $kerusakan->id,
        'tanggal_input' => $kerusakan->tanggal_input,
        'nama_barang' => $kerusakan->nama_barang,
        'kode_barang' => $kerusakan->kode_barang,
        'nup' => $kerusakan->nup,
        'kondisi' => $kerusakan->kondisi,
        'lokasi' => $kerusakan->lokasi,
        'deskripsi' => $kerusakan->deskripsi,
        'foto' => $kerusakan->foto,
        'foto_url' => $kerusakan->foto ? asset('storage/' . $kerusakan->foto) : null,
    ]);
}

/**
 * Update via AJAX
 */
public function updateKerusakanAjax(Request $request, Kerusakan $kerusakan)
{
    $request->validate([
        'tanggal_input' => 'required|date',
        'nama_barang' => 'required|string|max:255',
        'kode_barang' => 'required|string|max:50|unique:kerusakans,kode_barang,' . $kerusakan->id,
        'nup' => 'required|string|max:100|unique:kerusakans,nup,' . $kerusakan->id,
        'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat,Hancur',
        'lokasi' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->all();

    // Upload foto baru jika ada
    if ($request->hasFile('foto')) {
        // Hapus foto lama
        if ($kerusakan->foto && Storage::disk('public')->exists($kerusakan->foto)) {
            Storage::disk('public')->delete($kerusakan->foto);
        }
        $data['foto'] = $request->file('foto')->store('kerusakan_photos', 'public');
    }

    $kerusakan->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate!'
    ]);
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

        return view('adminsarpras.laporan_kerusakan', compact('laporan', 'stats'));
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