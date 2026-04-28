<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    AssetTetap,
    TransaksiMasukAssetTetap,
    TransaksiKeluarAssetTetap,
    MutasiBarang,
    Pengaduan,
    SurveyExport,
    SurveyKepuasan,
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
    
    // ========== TRANSAKSI KELUAR ASET TETAP ==========
    public function TransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarAssetTetap::with(['asetTetap', 'user'])
            ->when($request->filled('search'), function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('kode_barang', 'like', "%{$request->search}%")
                         ->orWhere('nup', 'like', "%{$request->search}%")
                         ->orWhere('nama_barang', 'like', "%{$request->search}%")
                         ->orWhere('nomor_sk', 'like', "%{$request->search}%")
                         ->orWhere('keterangan', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->orderBy('tanggal_input', 'desc');

        $transaksi = $query->paginate(15)->withQueryString();

        // Format untuk view (sama seperti TransaksiMasuk)
        $transaksi->getCollection()->transform(function ($item) {
            $item->tanggal_input_formatted = $item->tanggal_input?->format('d/m/Y');
            $item->tanggal_sk_formatted = $item->tanggal_sk?->format('d/m/Y');
            $item->tanggal_perolehan_formatted = $item->tanggal_perolehan?->format('d/m/Y');
            $item->nilai_perolehan_formatted = number_format($item->nilai_perolehan ?? 0, 0, ',', '.');
            return $item;
        });

        $asetTetapOptions = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup')
        ->orderBy('nama_barang')
        ->get();

        return view('adminasettetap.transaksi_keluar', compact('transaksi', 'asetTetapOptions'));
    }

    public function createTransaksiKeluar()
    {
        $asetTetap = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup')
        ->orderBy('nama_barang')
        ->get();

        return view('adminasettetap.transaksi_keluar_create', compact('asetTetap'));
    }

    public function storeTransaksiKeluar(Request $request)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'required|exists:aset_tetap,id',
            'tanggal_input' => 'required|date|before_or_equal:today',
            'nomor_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date|after_or_equal:tanggal_input',
            'keterangan' => 'nullable|string|max:1000'
        ]);

        try {
            $aset = AssetTetap::findOrFail($validated['aset_tetap_id']);
            
            // Pastikan aset masih tersedia
            if ($aset->status !== 'Tersedia') {
                return back()->withErrors(['aset_tetap_id' => 'Aset tidak tersedia untuk transaksi keluar']);
            }

            TransaksiKeluarAssetTetap::create([
                'tanggal_input' => $validated['tanggal_input'],
                'aset_tetap_id' => $validated['aset_tetap_id'],
                'kode_barang' => $aset->kode_barang,
                'nup' => $aset->nup,
                'nama_barang' => $aset->nama_barang,
                'merek' => $aset->merek,
                'tanggal_perolehan' => $aset->tanggal_perolehan,
                'nilai_perolehan' => $aset->nilai_perolehan,
                'lokasi' => $aset->lokasi,
                'nomor_sk' => $validated['nomor_sk'],
                'tanggal_sk' => $validated['tanggal_sk'],
                'keterangan' => $validated['keterangan'],
                'user_id' => Auth::id(),
                'status' => 'aktif' // default status
            ]);

            // Update status aset
            $aset->update(['status' => 'Keluar']);

            return redirect()->route('adminasettetap.transaksi-keluar')
                ->with('success', 'Transaksi keluar aset tetap berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function showTransaksiKeluar(TransaksiKeluarAssetTetap $transaksi)
    {
        $transaksi->load(['asetTetap', 'user']);
        return view('adminasettetap.transaksi_keluar_show', compact('transaksi'));
    }

    public function editTransaksiKeluar(TransaksiKeluarAssetTetap $transaksi)
    {
        $asetTetapOptions = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup')
        ->orderBy('nama_barang')
        ->get();

        return view('adminasettetap.transaksi_keluar_edit', compact('transaksi', 'asetTetap'));
    }

    public function updateTransaksiKeluar(Request $request, TransaksiKeluarAssetTetap $transaksi)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'required|exists:aset_tetap,id',
            'tanggal_input' => 'required|date|before_or_equal:today',
            'nomor_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date|after_or_equal:tanggal_input',
            'keterangan' => 'nullable|string|max:1000',
            'status' => 'nullable|in:aktif,dibatalkan'
        ]);

        try {
            // Jika aset berubah, update data aset
            $aset = AssetTetap::find($validated['aset_tetap_id']);
            $updateData = [
                'aset_tetap_id' => $validated['aset_tetap_id'],
                'tanggal_input' => $validated['tanggal_input'],
                'nomor_sk' => $validated['nomor_sk'],
                'tanggal_sk' => $validated['tanggal_sk'],
                'keterangan' => $validated['keterangan'],
            ];

            if (isset($validated['status'])) {
                $updateData['status'] = $validated['status'];
            }

            if ($aset) {
                $updateData = array_merge($updateData, [
                    'kode_barang' => $aset->kode_barang,
                    'nup' => $aset->nup,
                    'nama_barang' => $aset->nama_barang,
                    'merek' => $aset->merek,
                    'tanggal_perolehan' => $aset->tanggal_perolehan,
                    'nilai_perolehan' => $aset->nilai_perolehan,
                    'lokasi' => $aset->lokasi,
                ]);
            }

            $transaksi->update($updateData);

            return redirect()->route('adminasettetap.transaksi-keluar')
                ->with('success', 'Transaksi keluar aset tetap berhasil diupdate!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    public function destroyTransaksiKeluar(TransaksiKeluarAssetTetap $transaksi)
    {
        try {
            // Restore status aset
            $aset = AssetTetap::find($transaksi->aset_tetap_id);
            if ($aset) {
                $aset->update(['status' => 'Tersedia']);
            }

            $transaksi->delete();

            return redirect()->route('adminasettetap.transaksi-keluar')
                ->with('success', 'Transaksi keluar aset tetap berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    // ========== AJAX Methods untuk Transaksi Keluar ==========
    public function getAsetKeluarData($id)
    {
        try {
            $aset = AssetTetap::select([
                'id', 'kode_barang', 'nup', 'nama_barang', 'merek', 
                'tanggal_perolehan', 'nilai_perolehan', 'lokasi'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'kode_barang' => $aset->kode_barang,
                    'nup' => $aset->nup,
                    'nama_barang' => $aset->nama_barang,
                    'merek' => $aset->merek,
                    'tanggal_perolehan' => $aset->tanggal_perolehan?->format('Y-m-d'),
                    'nilai_perolehan' => $aset->nilai_perolehan,
                    'lokasi' => $aset->lokasi
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Aset tidak ditemukan atau tidak tersedia'
            ], 404);
        }
    }

    // ========== MUTASI BARANG ==========
    public function mutasiBarang(Request $request)
    {
        $query = MutasiBarang::with(['asetTetap', 'user'])
            ->when($request->filled('search'), function($q) use ($request) {
                $q->search($request->search);
            })
            ->when($request->filled('lokasi_awal'), function($q) use ($request) {
                $q->where('lokasi_awal', $request->lokasi_awal);
            })
            ->when($request->filled('lokasi_akhir'), function($q) use ($request) {
                $q->where('lokasi_akhir', $request->lokasi_akhir);
            })
            ->when($request->filled('tanggal_awal'), function($q) use ($request) {
                $q->whereDate('tanggal_mutasi', '>=', $request->tanggal_awal);
            })
            ->when($request->filled('tanggal_akhir'), function($q) use ($request) {
                $q->whereDate('tanggal_mutasi', '<=', $request->tanggal_akhir);
            })
            ->orderBy('tanggal_mutasi', 'desc')
            ->orderBy('created_at', 'desc');

        $mutasiBarang = $query->paginate(15)->withQueryString();
        
        $mutasiBarang->getCollection()->transform(function ($item) {
            $item->tanggal_input = $item->tanggal_input;
            $item->tanggal_mutasi_formatted = $item->tanggal_mutasi_formatted;
            return $item;
        });

        $lokasiOptions = AssetTetap::distinct()->pluck('lokasi')->filter()->sort()->values();
        
        return view('adminasettetap.mutasi_barang', compact('mutasiBarang', 'lokasiOptions'));
    }

    public function createMutasi()
    {
        $asetTetap = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'lokasi')
            ->orderBy('nama_barang')
            ->get();
        
        $lokasiOptions = AssetTetap::distinct()->pluck('lokasi')->filter()->sort()->values();
            
        return view('adminasettetap.mutasi_barang.create', compact('asetTetap', 'lokasiOptions'));
    }

    public function storeMutasi(Request $request)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'nullable|exists:aset_tetap,id',
            'kode_barang' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'lokasi_awal' => 'required|string|max:100',
            'lokasi_akhir' => 'required|string|max:100|different:lokasi_awal',
            'tanggal_mutasi' => 'required|date|before_or_equal:today',
        ]);

        $validated['user_id'] = auth()->id();

        MutasiBarang::create($validated);

        return redirect()->route('adminasettetap.mutasi-barang')
            ->with('success', 'Mutasi barang berhasil ditambahkan!');
    }

    public function showMutasi(MutasiBarang $mutasi)
    {
        $mutasi->load(['asetTetap', 'user']);
        return view('adminasettetap.mutasi_barang.show', compact('mutasi'));
    }

    public function editMutasi(MutasiBarang $mutasi)
    {
        $asetTetap = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'lokasi')
            ->orderBy('nama_barang')
            ->get();
        
        $lokasiOptions = AssetTetap::distinct()->pluck('lokasi')->filter()->sort()->values();
        
        return view('adminasettetap.mutasi_barang.edit', compact('mutasi', 'asetTetap', 'lokasiOptions'));
    }

    public function updateMutasi(Request $request, MutasiBarang $mutasi)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'nullable|exists:aset_tetap,id',
            'kode_barang' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'lokasi_awal' => 'required|string|max:100',
            'lokasi_akhir' => 'required|string|max:100|different:lokasi_awal',
            'tanggal_mutasi' => 'required|date|before_or_equal:today',
        ]);

        $mutasi->update($validated);

        return redirect()->route('adminasettetap.mutasi-barang')
            ->with('success', 'Mutasi barang berhasil diupdate!');
    }

    public function destroyMutasi(MutasiBarang $mutasi)
    {
        $mutasi->delete();

        return redirect()->route('adminasettetap.mutasi-barang')
            ->with('success', 'Mutasi barang berhasil dihapus!');
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

        $peminjamanBarang = $query->paginate(15)->withQueryString();
        
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

    // ========== PEMINJAMAN KENDARAAN ==========
     public function peminjamanKendaraan(Request $request)
    {
        $query = PeminjamanKendaraan::with(['user', 'reviewedBy'])
            ->when($request->filled('search'), fn($q, $search) => $q->search($search))
            ->when($request->filled('status'), fn($q, $status) => $q->where('status', $status))
            ->orderBy('created_at', 'desc');

        $peminjamanKendaraan = $query->paginate(15)->withQueryString();

        return view('adminasettetap.peminjaman_kendaraan', compact('peminjamanKendaraan'));
    }

    // Approval workflow
    public function reviewPeminjaman(Request $request, PeminjamanKendaraan $peminjaman)
    {
        $request->validate([
            'action' => 'required|in:review,approve,reject',
            'komentar' => 'nullable|string|max:500'
        ]);

        $statusMap = [
            'review' => 'dalam_review',
            'approve' => 'disetujui_admin', 
            'reject' => 'ditolak'
        ];

        $peminjaman->update([
            'status' => $statusMap[$request->action],
            'reviewed_by_adminasettetap_id' => Auth::id(),
            'komentar' => $request->komentar
        ]);

        return back()->with('success', 'Status peminjaman diperbarui!');
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
        $query = TransaksiMasukAssetTetap::with(['aset', 'pemasok'])
            ->when($request->date_range, function($q, $range) {
                [$start, $end] = explode(' - ', $range);
                $q->whereBetween('tanggal_transaksi', [Carbon::parse($start), Carbon::parse($end)]);
            });

        $laporanTransaksiMasuk = $query->get();
        return view('adminasettetap.laporan_transaksimasuk', compact('laporanTransaksiMasuk'));
    }

    public function laporanTransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarAssetTetap::with(['aset', 'penerima'])
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


     // ========== PENGADUAN ==========
        public function pengaduan(Request $request)
    {
        $query = Pengaduan::query()
            ->when($request->filled('search'), function($q) use ($request) {
                $q->search($request->search);
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->status($request->status);
            })
            ->orderBy('created_at', 'desc');

        $pengaduan = $query->paginate(15)->withQueryString();

        return view('adminasettetap.pengaduan', compact('pengaduan'));
    }

    public function pengaduanShow(Pengaduan $pengaduan)
    {
        return view('adminasettetap.pengaduan_show', compact('pengaduan'));
    }

    public function pengaduanUpdate(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('adminasettetap.pengaduan')
            ->with('success', 'Status pengaduan #' . $pengaduan->id . ' berhasil diupdate!');
    }

    public function pengaduanDestroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return redirect()->route('adminasettetap.pengaduan')
            ->with('success', 'Pengaduan berhasil dihapus!');
    }
    
    //=======PENGADUAN STORE FRONDEND-=====
    public function pengaduanStore(Request $request)
    {
    $validated = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telepon' => 'required|string|max:20',
        'kategori' => 'required|in:peminjaman_barang,pengembalian_barang,peminjaman_kendaraan,pengembalian_kendaraan,peminjaman_gedung,pengembalian_gedung,persediaan,sistem,layanan,lainnya',
        'deskripsi' => 'required|string|max:5000',
        'setuju_kebijakan' => 'required|accepted',
    ], [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'telepon.required' => 'Nomor telepon wajib diisi',
        'kategori.required' => 'Pilih kategori pengaduan',
        'deskripsi.required' => 'Deskripsi pengaduan wajib diisi',
        'setuju_kebijakan.accepted' => 'Anda harus menyetujui kebijakan privasi',
    ]);

    try {
        Pengaduan::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dikirim! Kami akan memproses dalam 24 jam.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan pengaduan. Silakan coba lagi.'
        ], 500);
    }

    }

    // ========== SURVEY KEPUASAN ==========
public function surveyKepuasan(Request $request)
{
    $query = SurveyKepuasan::query()
        ->when($request->filled('search'), function($q) use ($request) {
            $q->search($request->search);
        })
        ->when($request->filled('kepuasan'), function($q) use ($request) {
            $q->kepuasan($request->kepuasan);
        })
        ->orderBy('created_at', 'desc');

    $surveys = $query->paginate(15)->withQueryString();

    return view('adminasettetap.survey_kepuasan', compact('surveys'));
}

public function surveyShow(SurveyKepuasan $survey)
{
    return view('adminasettetap.survey_show', compact('survey'));
}

public function surveyDestroy(SurveyKepuasan $survey)
{
    $survey->delete();

    return redirect()->route('adminasettetap.survey-kepuasan')
        ->with('success', 'Survey kepuasan berhasil dihapus!');
}

// ========== FRONTEND SURVEY STORE ==========
public function surveyStore(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'kepuasan' => 'required|in:sangat_puas,puas,cukup,kurang_puas,tidak_puas',
        'aspek_memuaskan' => 'nullable|string|max:2000',
        'saran' => 'nullable|string|max:2000',
    ], [
        'nama.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'kepuasan.required' => 'Rating kepuasan wajib dipilih',
    ]);

    try {
        SurveyKepuasan::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kepuasan' => $validated['kepuasan'],
            'aspek_memuaskan' => $validated['aspek_memuaskan'],
            'saran' => $validated['saran'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas feedback Anda! Survey berhasil dikirim.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan survey. Silakan coba lagi.'
        ], 500);
    }
    }

    public function getSurveyStats()
    {
    $totalSurvey = SurveyKepuasan::count();
    
    // Rating mapping
    $ratings = [
        'sangat_puas' => 5, 'puas' => 4, 'cukup' => 3, 
        'kurang_puas' => 2, 'tidak_puas' => 1
    ];
    
    // Breakdown per tingkat
    $surveyStats = [];
    foreach($ratings as $label => $score) {
        $surveyStats[$label] = SurveyKepuasan::where('kepuasan', $label)->count();
    }
    
    // Rata-rata rating
    $rataRataRating = SurveyKepuasan::avg(DB::raw("
        CASE 
            WHEN kepuasan = 'sangat_puas' THEN 5
            WHEN kepuasan = 'puas' THEN 4
            WHEN kepuasan = 'cukup' THEN 3
            WHEN kepuasan = 'kurang_puas' THEN 2
            WHEN kepuasan = 'tidak_puas' THEN 1
            ELSE 0 
        END
    "));
    
    // Quote terbaik (sangat puas)
    $quoteTerbaik = SurveyKepuasan::where('kepuasan', 'sangat_puas')
        ->whereNotNull('aspek_memuaskan')
        ->orderBy('created_at', 'desc')
        ->first(['aspek_memuaskan', 'nama']);
    
    // Trend bulan ini (contoh)
    $trendBulanIni = '+12%';
    
    return compact(
        'totalSurvey', 'surveyStats', 'rataRataRating', 
        'quoteTerbaik', 'trendBulanIni'
    );
    }

    public function exportExcel(Request $request)
    {
    return Excel::download(new SurveyExport($request), 'survey.excel-export' . now()->format('d-m-Y') . '.xlsx');
    }
    
}
