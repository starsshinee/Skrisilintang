<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    AssetTetap,
    TransaksiMasukAssetTetap,
    TransaksiKeluarAsetTetap,
    MutasiBarang,
    PeminjamanBarang,
    PengembalianBarang,
    PeminjamanKendaraan,
    PengembalianKendaraan
};

class AdminAsettetapController extends Controller
{
    // ========== DASHBOARD ==========
    public function dashboard()
    {
        return view('adminasettetap.dashbord');
        // $stats = [
        //     'totalAset' => AssetTetap::count(),
        //     'transaksiMasuk' => TransaksiMasukAsetTetap::count(),
        //     'peminjamanBarangAktif' => PeminjamanBarang::where('status', 'disetujui')->count(),
        //     'pengembalianPending' => PengembalianBarang::where('status_verifikasi', 'pending')->count(),
        //     'kendaraanDipinjam' => PeminjamanKendaraan::where('status', 'disetujui')->count(),
        // ];

        // $recentPengembalian = PengembalianBarang::with('peminjamanBarang.barang', 'user')
        //     ->where('status_verifikasi', 'pending')
        //     ->latest()
        //     ->limit(5)
        //     ->get();

        // return view('adminasettetap.dashbord', compact('stats', 'recentPengembalian'));
    }

    // ========== DATA ASET TETAP - INDEX (sudah ada, update query) ==========
    public function dataAsetTetap(Request $request)
    {
        $query = AssetTetap::query()
            ->when($request->filled('search'), function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('nama_barang', 'like', "%{$request->search}%")
                        ->orWhere('kode_barang', 'like', "%{$request->search}%")
                        ->orWhere('nup', 'like', "%{$request->search}%")
                        ->orWhere('merek', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('kondisi'), function($q) use ($request) {
                $q->where('kondisi', $request->kondisi);
            })
            ->orderBy('created_at', 'desc');

        $asetTetap = $query->paginate(15)->withQueryString();

        return view('adminasettetap.data_asettetap', compact('asetTetap'));
    }

    // ========== CREATE ==========
    public function create()
    {
        return view('adminasettetap.data_asettetap_create');
    }

    // ========== STORE ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:aset_tetap,kode_barang',
            'nup' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'tanggal_peroleh' => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak,Perawatan',
            'lokasi' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
        ]);

        AssetTetap::create($validated);

        return redirect()->route('adminasettetap.data-aset-tetap')
            ->with('success', 'Aset tetap berhasil ditambahkan!');
        }

        // ========== SHOW (Detail) ==========
    public function show(AssetTetap $aset)
    {
        return view('adminasettetap.data_asettetap_show', compact('aset'));
    }

    // ========== EDIT ==========
    public function edit(AssetTetap $aset)
    {
        return view('adminasettetap.data_asettetap_edit', compact('aset'));
    }

    // ========== UPDATE ==========
    public function update(Request $request, AssetTetap $aset)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:aset_tetap,kode_barang,' . $aset->id,
            'nup' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'tanggal_peroleh' => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak,Perawatan',
            'lokasi' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
        ]);

        $aset->update($validated);

        return redirect()->route('adminasettetap.data-aset-tetap')
            ->with('success', 'Aset tetap berhasil diupdate!');
    }

    // ========== DESTROY ==========
    public function destroy(AssetTetap $aset)
    {
        $aset->delete();

        return redirect()->route('adminasettetap.data-aset-tetap')
            ->with('success', 'Aset tetap berhasil dihapus!');
    }

    // ========== TRANSAKSI MASUK ==========
    // public function TransaksiMasuk(Request $request)
    // {
    //     $query = TransaksiMasukAsetTetap::with(['aset', 'pemasok'])
    //         ->when($request->search, function($q, $search) {
    //             $q->where('no_transaksi', 'like', "%{$search}%")
    //               ->orWhereHas('aset', fn($q) => $q->where('nama', 'like', "%{$search}%"))
    //               ->orWhereHas('pemasok', fn($q) => $q->where('nama', 'like', "%{$search}%"));
    //         })
    //         ->when($request->status, fn($q, $s) => $q->where('status', $s));

    //     $transaksiMasuk = $query->paginate(15)->withQueryString();
        
    //     return view('adminasettetap.transaksi_masuk', compact('transaksiMasuk'));
    // }

    // Tambahkan di AdminAsettetapController

// ========== TRANSAKSI MASUK ASET TETAP ==========
    public function TransaksiMasuk(Request $request)
    {
    $kondisiOptions = ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak_operasi'];
    $kategoriOptions = AssetTetap::select('kategori')->distinct()->pluck('kategori')->filter()->values();

    $query = TransaksiMasukAssetTetap::with(['user', 'asetTetap'])
        ->when($request->filled('search'), function($q) use ($request) {
            $q->search($request->search);
        })
        ->when($request->filled('kondisi'), function($q) use ($request) {
            $q->kondisi($request->kondisi);
        })
        ->when($request->filled('kategori'), function($q) use ($request) {
            $q->kategori($request->kategori);
        })
        ->orderBy('created_at', 'desc');

    $transaksi = $query->paginate(15)->withQueryString();

    // Format untuk view
    $transaksi->getCollection()->transform(function ($item) {
        $item->tanggal_input = $item->created_at?->format('d/m/Y');
        return $item;
    });

    return view('adminasettetap.transaksi_masuk', compact('transaksi', 'kondisiOptions', 'kategoriOptions'));
    }

    public function createTransaksiMasuk()
    {
        return view('adminasettetap.transaksi_masuk_create');
    }

    public function storeTransaksiMasuk(Request $request)
    {
        $validated = $request->validate([
            'nomor_transaksi' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nomor_transaksi',
            'kode_barang' => 'required|string|max:100',
            'nup' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nup',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak_operasi',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'nomor_referensi' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        TransaksiMasukAssetTetap::create($validated);

        return redirect()->route('adminasettetap.transaksi-masuk')
            ->with('success', 'Transaksi masuk aset tetap berhasil ditambahkan!');
    }

    public function showTransaksiMasuk(TransaksiMasukAssetTetap $transaksi)
    {
        return view('adminasettetap.transaksi_masuk_show', compact('transaksi'));
    }

    public function editTransaksiMasuk(TransaksiMasukAssetTetap $transaksi)
    {
        return view('adminasettetap.transaksi_masuk_edit', compact('transaksi'));
    }

    public function updateTransaksiMasuk(Request $request, TransaksiMasukAssetTetap $transaksi)
    {
        $validated = $request->validate([
            'nomor_transaksi' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nomor_transaksi,' . $transaksi->id,
            'kode_barang' => 'required|string|max:100',
            'nup' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nup,' . $transaksi->id,
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_layak_operasi',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'nomor_referensi' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi->update($validated);

        return redirect()->route('adminasettetap.transaksi-masuk')
            ->with('success', 'Transaksi masuk aset tetap berhasil diupdate!');
    }

    public function destroyTransaksiMasuk(TransaksiMasukAssetTetap $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('adminasettetap.transaksi-masuk')
            ->with('success', 'Transaksi masuk aset tetap berhasil dihapus!');
    }
    // ========== TRANSAKSI KELUAR ==========
    public function TransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarAsetTetap::with(['aset', 'penerima'])
            ->when($request->search, function($q, $search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('aset', fn($q) => $q->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('penerima', fn($q) => $q->where('nama', 'like', "%{$search}%"));
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s));

        $transaksiKeluar = $query->paginate(15)->withQueryString();
        
        return view('adminasettetap.transaksi_keluar', compact('transaksiKeluar'));
    }

    // ========== MUTASI BARANG ==========
    public function mutasiBarang(Request $request)
    {
        $query = MutasiBarang::with(['barangAsal', 'barangTujuan', 'user'])
            ->when($request->search, function($q, $search) {
                $q->where('no_mutasi', 'like', "%{$search}%")
                  ->orWhereHas('barangAsal', fn($q) => $q->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('barangTujuan', fn($q) => $q->where('nama', 'like', "%{$search}%"));
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s));

        $mutasiBarang = $query->paginate(15)->withQueryString();
        
        return view('adminasettetap.mutasi_barang', compact('mutasiBarang'));
    }

    // ========== PEMINJAMAN BARANG ==========
    public function PeminjamanBarang(Request $request)
    {
        $query = PeminjamanBarang::with(['barang', 'user'])
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->search, function($q, $search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('barang', fn($qb) => $qb->where('nama_barang', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn($qb) => $qb->where('name', 'like', "%{$search}%"));
            });

        // $peminjamanBarang = $query->paginate(15)->withQueryString();
        
        return view('adminasettetap.peminjaman_barang', compact('peminjamanBarang'));
    }

    // ========== PENGEMBALIAN BARANG ==========
        public function PengembalianBarang(Request $request)
    {
        $query = PengembalianBarang::with([
                'peminjamanBarang.barang', 
                'user', 
                'adminVerifier'
            ])
            ->when($request->kondisi, fn($q, $k) => $q->kondisi($k))
            ->when($request->status_verifikasi, fn($q, $s) => $q->where('status_verifikasi', $s))
            ->when($request->search, fn($q, $s) => $q->search($s))
            ->orderBy('tanggal_pengembalian_aktual', 'desc');

        $pengembalianbarang = $query->paginate(10)->withQueryString();
        
        return view('adminasettetap.pengembalian_barang', compact('pengembalianbarang'));
    }

    // ========== PENGEMBALIAN KENDARAAN ==========
    public function PengembalianKendaraan(Request $request)
    {
        $query = PengembalianKendaraan::with([
                'peminjamanKendaraan.kendaraan', 
                'peminjamanKendaraan.user',
                'user',
                'admin' // verified_by_admin_id
            ])
            ->when($request->kondisi, function($q, $kondisi) {
                $q->where('kondisi_kendaraan', $kondisi);
            })
            ->when($request->status, function($q, $status) { // ✅ Ganti status_verifikasi → status_pengembalian
                $q->where('status_pengembalian', $status);
            })
            ->when($request->search, function($q, $search) {
                $q->whereHas('peminjamanKendaraan.kendaraan', function($qb) use ($search) {
                    $qb->where('nopol', 'like', "%{$search}%")
                       ->orWhere('merk', 'like', "%{$search}%")
                       ->orWhere('tipe', 'like', "%{$search}%");
                })
                ->orWhereHas('peminjamanKendaraan.user', function($qb) use ($search) {
                    $qb->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('catatan', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_pengembalian_aktual', 'desc');

        $pengembalianKendaraan = $query->paginate(10)->withQueryString();
        
        return view('adminasettetap.pengembalian_kendaraan', compact('pengembalianKendaraan'));
    }

    // ========== LAPORAN PEMINJAMAN KENDARAAN ==========
    public function laporanPeminjamanKendaraan(Request $request)
    {
        $query = PeminjamanKendaraan::with(['kendaraan', 'user', 'sopir'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_pinjam', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanPeminjamanKendaraan = $query->get();
        return view('adminasettetap.laporan_peminjaman_kendaraan', compact('laporanPeminjamanKendaraan'));
    }

    // ========== LAPORAN PENGEMBALIAN KENDARAAN ==========
    public function laporanPengembalianKendaraan(Request $request)
    {
        $query = PengembalianKendaraan::with([
            'peminjamanKendaraan.kendaraan', 
            'peminjamanKendaraan.user',
            'user'
        ])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_pengembalian_aktual', [Carbon::parse($start), Carbon::parse($end)]);
            })
            ->when($request->status, fn($q, $s) => $q->where('status_pengembalian', $s));

        $laporanPengembalianKendaraan = $query->get();
        return view('adminasettetap.laporan_pengembalian_kendaraan', compact('laporanPengembalianKendaraan'));
    }

    // ========== COMMON: Update Status (UPDATED) ==========
    public function updateStatus(Request $request, $id)
    {
        $model = match($request->type) {
            'peminjaman-barang' => PeminjamanBarang::findOrFail($id),
            'pengembalian-barang' => PengembalianBarang::findOrFail($id),
            'peminjaman-kendaraan' => PeminjamanKendaraan::findOrFail($id),
            'pengembalian-kendaraan' => PengembalianKendaraan::findOrFail($id), // ✅ FIXED
            default => abort(404)
        };

        // Handle different status fields
        $updateData = [
            'catatan_admin' => $request->catatan,
            'verified_at' => now(),
            // 'verified_by_admin_id' => auth()->id(), // ✅ Tambah verifier
        ];

        if (in_array($model->getTable(), ['pengembalian_barang', 'pengembalian_kendaraan'])) {
            $updateData['status_verifikasi'] = $request->status ?? $request->status_verifikasi;
        } else {
            $updateData['status'] = $request->status;
        }

        // Untuk pengembalian kendaraan, update juga status peminjaman
        if ($request->type === 'pengembalian-kendaraan') {
            $pengembalian = PengembalianKendaraan::findOrFail($id);
            $pengembalian->peminjamanKendaraan->update(['status' => 'dikembalikan']);
        }

        $model->update($updateData);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    // ========== VERIFIKASI PENGEMBALIAN KENDARAAN ==========
    public function verifikasiPengembalianKendaraan(Request $request, $id)
    {
        $pengembalian = PengembalianKendaraan::findOrFail($id);
        
        $request->validate([
            'status_pengembalian' => 'required|in:diterima,ditolak',
            'komentar_admin' => 'nullable|string|max:500',
            'biaya_denda' => 'nullable|numeric|min:0'
        ]);

        $pengembalian->update([
            'status_pengembalian' => $request->status_pengembalian,
            'komentar_admin' => $request->komentar_admin,
            'biaya_denda' => $request->biaya_denda ?? 0,
            'verified_at' => now(),
            'verified_by_admin_id' => Auth::id() ?? null,
        ]);

        // Update status peminjaman kendaraan
        $pengembalian->peminjamanKendaraan->update([
            'status' => $request->status_pengembalian === 'diterima' ? 'dikembalikan' : 'ditolak'
        ]);

        return back()->with('success', 'Pengembalian kendaraan berhasil diverifikasi!');
    }

    // ========== LAPORAN ==========
    public function laporanPeminjamanBarang(Request $request)
    {
        $query = PeminjamanBarang::with(['barang', 'user'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_peminjaman', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanPeminjamanBarang = $query->get();
        return view('adminasettetap.laporan_peminjaman_barang', compact('laporanPeminjamanBarang'));
    }

    public function laporanTransaksiMasuk(Request $request)
    {
        $query = TransaksiMasukAsetTetap::with(['aset', 'pemasok'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_transaksi', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanTransaksiMasuk = $query->get();
        return view('adminasettetap.laporan_transaksimasuk', compact('laporanTransaksiMasuk'));
    }

    public function laporanTransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarAsetTetap::with(['aset', 'penerima'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_transaksi', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanTransaksiKeluar = $query->get();
        return view('adminasettetap.laporan_transaksikeluar', compact('laporanTransaksiKeluar'));
    }

    public function laporanMutasiAsetTetap(Request $request)
    {
        $query = MutasiBarang::with(['barangAsal', 'barangTujuan'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_mutasi', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanMutasiAsetTetap = $query->get();
        return view('adminasettetap.laporan_mutasibarang', compact('laporanMutasiAsetTetap'));
    }

}