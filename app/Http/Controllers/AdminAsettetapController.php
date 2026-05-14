<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log; // ✅ ADD
use Illuminate\Support\Facades\DB;
use App\Models\{
    User,
    AssetTetap,
    TransaksiMasukAssetTetap,
    TransaksiKeluarAssetTetap,
    MutasiBarang,
    Pengaduan,
    SurveyKepuasan,
    PeminjamanBarang,
    PengembalianBarang,
    PeminjamanKendaraan,
    PengembalianKendaraan,
};

class AdminAsettetapController extends Controller
{
    // ========== DASHBOARD ==========
    public function dashboard()
    {
        // return view('adminasettetap.dashbord');
        $stats = [
            'totalAset' => AssetTetap::count(),
            'transaksiMasuk' => TransaksiMasukAssetTetap::count(),
            'peminjamanBarangAktif' => PeminjamanBarang::where('status', 'disetujui')->count(),
            'pengembalianPending' => PengembalianBarang::where('status_verifikasi', 'pending')->count(),
            'kendaraanDipinjam' => PeminjamanKendaraan::where('status', 'disetujui')->count(),
        ];

        $recentPengembalian = PengembalianBarang::with('peminjamanBarang', 'user')
        ->where('status_verifikasi', 'pending')
        ->latest()
        ->limit(5)
        ->get();

        return view('adminasettetap.dashbord', compact('stats', 'recentPengembalian'));
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

        $asetTetapOptions = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup', 'lokasi', 'kondisi', 'merek', 'tanggal_perolehan', 'nilai_perolehan')
            ->where(function($q) {
                $q->where('status', 'Tersedia')
                ->orWhereNull('status');
            })
            ->orderBy('nama_barang', 'asc')
            ->orderBy('kode_barang', 'asc')
            ->get();

        // ✅ FIXED: Pass asetTetapOptions to view
        return view('adminasettetap.data_asettetap', compact('asetTetap', 'asetTetapOptions'));
    }

    // ========== CREATE ==========
    public function create()
    {
        return view('adminasettetap.data_asettetap_create');
    }

    // ========== STORE DATA ASET TETAP (Method yang hilang) ==========
    public function storeDataAsetTetap(Request $request)
    {
        $validated = $request->validate([
            'tanggal_input' => 'required|date|before_or_equal:today',
            'kode_barang' => 'required|string|max:50|unique:aset_tetap,kode_barang',
            'nup' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Keluar,Rusak,Dipinjam',
        ]);

        AssetTetap::create($validated);

        return redirect()->route('adminasettetap.data-aset-tetap')
            ->with('success', 'Aset tetap berhasil ditambahkan!');
    }

        // ========== SHOW (Detail) ==========
    public function showDataAsetTetap(AssetTetap $aset)
    {
        return view('adminasettetap.data_asettetap_show', compact('aset'));
    }

    // ========== EDIT ==========
    public function edit(AssetTetap $aset)
    {
        return view('adminasettetap.data_asettetap_edit', compact('aset'));
    }

    // ========== UPDATE ==========
    public function updateDataAsetTetap(Request $request, AssetTetap $aset)
    {
        $validated = $request->validate([
            'tanggal_input' => 'required|date|before_or_equal:today',
            'kode_barang' => 'required|string|max:50|unique:aset_tetap,kode_barang,' . $aset->id,
            'nup' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Keluar,Rusak,Dipinjam',
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


     // ========== TRANSAKSI MASUK ✅ FIXED ==========
    public function TransaksiMasuk(Request $request)
    {
        $kondisiOptions = ['baik', 'rusak_ringan', 'rusak_berat'];
        $kategoriOptions = AssetTetap::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->pluck('kategori')
            ->filter()
            ->values();

        // ✅ FIXED: Filter null + eager loading + whereNotNull
        $query = TransaksiMasukAssetTetap::with(['user'])
            ->whereNotNull('id') // Pastikan ada data
            ->when($request->filled('search'), function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('kode_barang', 'like', "%{$request->search}%")
                         ->orWhere('nup', 'like', "%{$request->search}%")
                         ->orWhere('nama_barang', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('kondisi'), function($q) use ($request) {
                $q->where('kondisi', $request->kondisi);
            })
            ->when($request->filled('kategori'), function($q) use ($request) {
                $q->where('kategori', 'like', "%{$request->kategori}%");
            })
            ->orderBy('created_at', 'desc');

        $transaksi = $query->paginate(15)->withQueryString();

        // ✅ FIXED: Transform dengan null safety
        $transaksi->getCollection()->transform(function ($item) {
            if (!$item) return null;
            
            $tanggalInput = $item->tanggal_input ?? $item->created_at;
            $item->tanggal_input_formatted = $tanggalInput 
            ? Carbon::parse($tanggalInput)->format('d/m/Y'): '-';
            
            try {
                $item->tanggal_perolehan_formatted = $item->tanggal_perolehan 
                    ? Carbon::parse($item->tanggal_perolehan)->format('d/m/Y')
                    : '-';
            } catch (\Exception $e) {
                $item->tanggal_perolehan_formatted = '-';
                Log::warning("Error parsing tanggal_perolehan: " . $item->id, ['error' => $e->getMessage()]);
            }
            
            $item->nilai_format = $item->nilai_perolehan 
                ? 'Rp ' . number_format($item->nilai_perolehan, 0, ',', '.')
                : '-';
            
            // Kondisi badge
            $kondisi = $item->kondisi ?? 'unknown';
            $item->kondisi_badge = match($kondisi) {
                'baik' => ['color' => 'success', 'icon' => 'fa-check-circle', 'text' => 'Baik'],
                'rusak_ringan' => ['color' => 'warning', 'icon' => 'fa-exclamation-triangle', 'text' => 'Rusak Ringan'],
                'rusak_berat' => ['color' => 'danger', 'icon' => 'fa-times-circle', 'text' => 'Rusak Berat'],
                default => ['color' => 'secondary', 'icon' => 'fa-question-circle', 'text' => 'Tidak Diketahui']
            };
            
            return $item;
        })->reject(fn($item) => is_null($item)); // ✅ Remove null items

        return view('adminasettetap.transaksi_masuk', compact('transaksi', 'kondisiOptions', 'kategoriOptions'));
    }

    // CRUD Transaksi Masuk
    public function createTransaksiMasuk()
    {
        return view('adminasettetap.transaksi_masuk_create');
    }

    public function storeTransaksiMasuk(Request $request)
    {
        $validated = $request->validate([
            
            'kode_barang' => 'required|string|max:100',
            'nup' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nup',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
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
            'kode_barang' => 'required|string|max:100',
            'nup' => 'required|string|max:100|unique:transaksi_masuk_aset_tetap,nup,' . $transaksi->id,
            'nama_barang' => 'required|string|max:255',
            'merek' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
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
        $asetTetap = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup', 'lokasi', 'kondisi')
            ->where(function($q) {
                $q->where('status', 'Tersedia')
                ->orWhereNull('status');
            })
            ->orderBy('nama_barang', 'asc')
            ->orderBy('kode_barang', 'asc')
            ->get();

        return view('adminasettetap.transaksi_keluar_create', compact('asetTetap'));
    }

    public function editTransaksiKeluar(TransaksiKeluarAssetTetap $transaksi)
    {
        $asetTetapOptions = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'nup', 'lokasi', 'kondisi')
            ->where(function($q) {
                $q->where('status', 'Tersedia')
                ->orWhereNull('status');
            })
            ->orWhere('id', $transaksi->aset_tetap_id)
            ->orderBy('nama_barang', 'asc')
            ->get();

        return view('adminasettetap.transaksi_keluar_edit', compact('transaksi', 'asetTetapOptions'));
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
            DB::beginTransaction();
            
            // 1. Restore status aset menjadi 'Tersedia'
            $aset = AssetTetap::find($transaksi->aset_tetap_id);
            if ($aset) {
                $aset->update(['status' => 'Tersedia']);
            }
            
            // 2. Hapus transaksi keluar
            $transaksi->delete();
            
            DB::commit();
            
            return redirect()->route('adminasettetap.transaksi-keluar')
                ->with('success', 'Transaksi keluar aset tetap berhasil dihapus! Aset telah dikembalikan ke status Tersedia.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error delete transaksi keluar: ' . $e->getMessage(), [
                'transaksi_id' => $transaksi->id,
                'aset_id' => $transaksi->aset_tetap_id
            ]);
            
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    // ========== AJAX Methods untuk Transaksi Keluar ==========
    // ========== AJAX Methods untuk Transaksi Keluar ==========
    public function getAsetData($id)
    {
        
        try {
            $aset = AssetTetap::select([
                'id', 'kode_barang', 'nup', 'nama_barang', 'merek', 
                'tanggal_perolehan', 'nilai_perolehan', 'lokasi'
            ])->findOrFail($id);

            return response()->json([
                'kode_barang' => $aset->kode_barang,
                'nup' => $aset->nup,
                'nama_barang' => $aset->nama_barang,
                'merek' => $aset->merek ?? '',
                'tanggal_perolehan' => $aset->tanggal_perolehan?->format('Y-m-d'),
                'nilai_perolehan' => $aset->nilai_perolehan,
                'lokasi' => $aset->lokasi ?? ''
            ]);
        } catch (\Exception $e) {
            Log::error('getAsetData error: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['error' => 'Aset tidak ditemukan'], 404);
        }
    }

    public function editJson($id)  // ✅ RENAME dari editTransaksiKeluarJson
    {
        $transaksi = TransaksiKeluarAssetTetap::with('asetTetap')->findOrFail($id);
        
        return response()->json([
            'aset_tetap_id' => $transaksi->aset_tetap_id,
            'tanggal_input' => $transaksi->tanggal_input?->format('Y-m-d'),
            'nomor_sk' => $transaksi->nomor_sk,
            'tanggal_sk' => $transaksi->tanggal_sk?->format('Y-m-d'),
            'keterangan' => $transaksi->keterangan,
        ]);
    }

    // ✅ TAMBAH METHOD INI (showWithAset)
    public function showWithAset($transaksiId)
    {
        try {
            $transaksi = TransaksiKeluarAssetTetap::with('asetTetap')->findOrFail($transaksiId);
            
            return response()->json([
                'kode_barang' => $transaksi->asetTetap->kode_barang ?? '-',
                'nup' => $transaksi->asetTetap->nup ?? '-',
                'nama_barang' => $transaksi->asetTetap->nama_barang ?? '-',
                'merek' => $transaksi->asetTetap->merek ?? '-',
                'tanggal_perolehan_format' => $transaksi->asetTetap->tanggal_perolehan?->format('d/m/Y') ?? '-',
                'nilai_format' => $transaksi->asetTetap->nilai_perolehan ? 'Rp ' . number_format($transaksi->asetTetap->nilai_perolehan, 0, ',', '.') : '-',
                'lokasi' => $transaksi->asetTetap->lokasi ?? '-',
                'tanggal_input_format' => $transaksi->tanggal_input?->format('d/m/Y') ?? '-',
                'nomor_sk' => $transaksi->nomor_sk ?? '-',
                'tanggal_sk_format' => $transaksi->tanggal_sk?->format('d/m/Y') ?? '-',
                'keterangan' => $transaksi->keterangan ?? '-',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function editTransaksiKeluarJson(TransaksiKeluarAssetTetap $transaksi)
    {
        $transaksi->load('asetTetap');
        
        return response()->json([
            'aset_tetap_id' => $transaksi->aset_tetap_id,
            'tanggal_input' => $transaksi->tanggal_input?->format('Y-m-d'),
            'kode_barang' => $transaksi->kode_barang,
            'nup' => $transaksi->nup,
            'nama_barang' => $transaksi->nama_barang,
            'merek' => $transaksi->merek,
            'tanggal_perolehan' => $transaksi->tanggal_perolehan?->format('Y-m-d'),
            'nilai_perolehan' => $transaksi->nilai_perolehan,
            'lokasi' => $transaksi->lokasi,
            'nomor_sk' => $transaksi->nomor_sk,
            'tanggal_sk' => $transaksi->tanggal_sk?->format('Y-m-d'),
            'keterangan' => $transaksi->keterangan,
        ]);
    }

    // ========== MUTASI BARANG ==========
    public function mutasiBarang(Request $request)
    {
        $query = MutasiBarang::with(['asetTetap', 'user'])
            ->when($request->filled('search'), function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->where('no_mutasi', 'like', "%{$request->search}%")
                        ->orWhereHas('asetTetap', function($asetQ) use ($request) {
                            $asetQ->where('kode_barang', 'like', "%{$request->search}%")
                                ->orWhere('nama_barang', 'like', "%{$request->search}%");
                        })
                        ->orWhere('lokasi_awal', 'like', "%{$request->search}%")
                        ->orWhere('lokasi_akhir', 'like', "%{$request->search}%");
                });
            })
            ->orderBy('tanggal_mutasi', 'desc');

        $mutasi_barang = $query->paginate(15)->withQueryString();

        // Transform data untuk view
        $mutasi_barang->getCollection()->transform(function ($item) {
            $item->tanggal_mutasi_formatted = $item->tanggal_mutasi?->format('d/m/Y');
            $item->tanggal_input = $item->created_at?->format('d/m/Y H:i');
            return $item;
        });

        // Aset tetap untuk dropdown
        $asetTetap = AssetTetap::select('id', 'kode_barang', 'nama_barang', 'lokasi')
            ->orderBy('nama_barang', 'asc')
            ->orderBy('kode_barang', 'asc')
            ->get();

        return view('adminasettetap.mutasi_barang', compact('mutasi_barang', 'asetTetap'));
    }

    // ✅ FIXED: Store (POST /mutasi-barang)
    public function mutasiBarangStore(Request $request)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'required|exists:aset_tetap,id',
            'lokasi_awal' => 'required|string|max:255',
            'lokasi_akhir' => 'required|string|max:255',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $aset = AssetTetap::findOrFail($validated['aset_tetap_id']);
            
            $noMutasi = 'MUT-' . now()->format('Ymd') . '-' . str_pad(MutasiBarang::count() + 1, 4, '0', STR_PAD_LEFT);
            
            MutasiBarang::create([
                'no_mutasi' => $noMutasi,
                'aset_tetap_id' => $validated['aset_tetap_id'],
                'kode_barang' => $aset->kode_barang,
                'nama_barang' => $aset->nama_barang,
                'lokasi_awal' => $validated['lokasi_awal'],
                'lokasi_akhir' => $validated['lokasi_akhir'],
                'tanggal_mutasi' => $validated['tanggal_mutasi'],
                'keterangan' => $validated['keterangan'],
                'user_id' => Auth::id(),
            ]);

            // Update lokasi aset
            $aset->update(['lokasi' => $validated['lokasi_akhir']]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Mutasi barang berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Mutasi store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan mutasi: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ FIXED: Show/Detail (GET /mutasi-barang/{id})
    public function mutasiBarangShow($id)
    {
        $mutasi = MutasiBarang::with(['asetTetap', 'user'])->findOrFail($id);
        
        $mutasi->tanggal_mutasi_formatted = $mutasi->tanggal_mutasi?->format('d/m/Y');
        $mutasi->tanggal_input = $mutasi->created_at?->format('d/m/Y H:i');
        
        return response()->json($mutasi);
    }

    // ✅ FIXED: Edit (GET /mutasi-barang/{id}/edit)
    public function mutasiBarangEdit($id)
    {
        $mutasi = MutasiBarang::with('asetTetap')->findOrFail($id);
        
        return response()->json([
            'id' => $mutasi->id,
            'aset_tetap_id' => $mutasi->aset_tetap_id,
            'lokasi_awal' => $mutasi->lokasi_awal,
            'lokasi_akhir' => $mutasi->lokasi_akhir,
            'tanggal_mutasi' => $mutasi->tanggal_mutasi?->format('Y-m-d'),
            'keterangan' => $mutasi->keterangan ?? '',
            'kode_barang' => $mutasi->kode_barang,
            'nama_barang' => $mutasi->nama_barang
        ]);
    }

    // ✅ FIXED: Update (PUT /mutasi-barang/{id})
    public function mutasiBarangUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'aset_tetap_id' => 'required|exists:aset_tetap,id',
            'lokasi_awal' => 'required|string|max:255',
            'lokasi_akhir' => 'required|string|max:255',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $mutasi = MutasiBarang::findOrFail($id);
            $aset = AssetTetap::findOrFail($validated['aset_tetap_id']);
            
            $mutasi->update([
                'aset_tetap_id' => $validated['aset_tetap_id'],
                'kode_barang' => $aset->kode_barang,
                'nama_barang' => $aset->nama_barang,
                'lokasi_awal' => $validated['lokasi_awal'],
                'lokasi_akhir' => $validated['lokasi_akhir'],
                'tanggal_mutasi' => $validated['tanggal_mutasi'],
                'keterangan' => $validated['keterangan'],
            ]);

            // Update lokasi aset
            $aset->update(['lokasi' => $validated['lokasi_akhir']]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Mutasi barang berhasil diupdate!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate mutasi'
            ], 500);
        }
    }

    // ✅ FIXED: Delete (DELETE /mutasi-barang/{id})
    public function mutasiBarangDestroy($id)
    {
        DB::beginTransaction();
        try {
            $mutasi = MutasiBarang::with('asetTetap')->findOrFail($id);
            
            // Rollback lokasi aset ke lokasi awal
            if ($mutasi->asetTetap) {
                $mutasi->asetTetap->update(['lokasi' => $mutasi->lokasi_awal]);
            }
            
            $mutasi->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Mutasi barang berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus mutasi'
            ], 500);
        }
    }

    // ✅ FIXED: Get Aset Data (GET /mutasi-barang/aset/{id})
    public function getAsetTetapData($id)
    {
        $aset = AssetTetap::select(['id', 'kode_barang', 'nama_barang', 'lokasi'])->findOrFail($id);
        
        return response()->json([
            'kode_barang' => $aset->kode_barang,
            'nama_barang' => $aset->nama_barang,
            'lokasi_sekarang' => $aset->lokasi
        ]);
    }
    

    // ========== PEMINJAMAN BARANG ==========
    // Tampilan Peminjaman Barang Admin
    public function PeminjamanBarang(Request $request)
    {
        $query = PeminjamanBarang::with(['user'])
            ->when($request->search, function($q, $search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($qb) => $qb->where('name', 'like', "%{$search}%"));
            });

        // Filter status (contoh: Semua Status, Diterima, Pending, Ditolak)
        if ($request->status && $request->status !== 'Semua Status') {
            $statusMap = [
                'Diterima' => ['disetujui', 'disetujui_admin'],
                'Pending'  => ['pending', 'dalam_review', 'diteruskan_kasubag'],
                'Ditolak'  => ['ditolak']
            ];
            $selectedStatuses = $statusMap[$request->status] ?? [];
            if (!empty($selectedStatuses)) {
                $query->whereIn('status', $selectedStatuses);
            }
        }

        $peminjamanBarang = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('adminasettetap.peminjaman_barang', compact('peminjamanBarang'));
    }

    // Aksi: Teruskan / Tolak Permintaan
    public function reviewPeminjaman(Request $request, $id)
    {
        $peminjaman = PeminjamanBarang::findOrFail($id);
        
        if ($request->action == 'teruskan') {
            // 🔥 KITA UBAH CARANYA JADI MANUAL SEPERTI INI (Pasti Tembus)
            $peminjaman->status = 'diteruskan_kasubag';
            $peminjaman->reviewed_by_adminasettetap_id = auth()->id();
            $peminjaman->diteruskan_ke_kasubag_date = now();
            $peminjaman->save(); // Simpan paksa ke database

            $pesan = 'Peminjaman diteruskan ke Kasubag untuk persetujuan.';
            
        } elseif ($request->action == 'tolak') {
            // 🔥 CARA MANUAL UNTUK TOLAK
            $peminjaman->status = 'ditolak';
            $peminjaman->reviewed_by_adminasettetap_id = auth()->id();
            $peminjaman->komentar = $request->komentar;
            $peminjaman->save(); // Simpan paksa ke database

            $pesan = 'Peminjaman berhasil ditolak.';
        }

        return back()->with('success', $pesan);
    }

    // Aksi: Upload Surat BAST
    public function uploadSuratBast(Request $request, $id)
    {
        $request->validate([
            'surat_bast' => 'required|mimes:pdf|max:2048', // Maksimal 2MB, hanya PDF
        ]);

        $peminjaman = PeminjamanBarang::findOrFail($id);

        if ($request->hasFile('surat_bast')) {
            // Hapus file lama jika ada
            if ($peminjaman->surat_bast_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($peminjaman->surat_bast_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($peminjaman->surat_bast_path);
            }

            $file = $request->file('surat_bast');
            $filename = 'BAST_Pinjam_' . $peminjaman->kode_barang . '_' . time() . '.pdf';
            
            // Simpan ke storage/app/public/surat_peminjaman
            $path = $file->storeAs('surat_peminjaman', $filename, 'public');

            $peminjaman->update([
                'surat_bast_path' => $path
            ]);

            return back()->with('success', 'Surat BAST berhasil diunggah! Dokumen dapat diunduh oleh peminjam.');
        }

        return back()->withErrors(['error' => 'Gagal mengunggah surat.']);
    }

    // Method untuk Generate/Print Surat Peminjaman
    public function generateSuratPeminjaman(PeminjamanBarang $peminjaman)
    {
        // 1. Ambil data pihak terkait
        $peminjam = $peminjaman->user; // Pegawai yang meminjam
        $admin = auth()->user(); // Admin yang sedang login dan memproses
        $kasubag = User::where('role', 'kasubag')->first(); // Akun Kasubag untuk tanda tangan
        $kepala = User::where('role', 'kepalabpmp')->first(); // Akun Kepala BPMP

        // 2. Fungsi bantuan untuk mengubah tanda tangan (lokal) menjadi Base64 agar tampil di PDF
        $getBase64 = function ($path) {
            if ($path && Storage::disk('public')->exists($path)) {
                $type = pathinfo(storage_path('app/public/' . $path), PATHINFO_EXTENSION);
                $data = Storage::disk('public')->get($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return null;
        };

        // 3. Siapkan gambar tanda tangan (Signature) masing-masing pihak
        $ttdPeminjam = $peminjam ? $getBase64($peminjam->signature) : null;
        $ttdAdmin = $admin ? $getBase64($admin->signature) : null;
        $ttdKasubag = $kasubag ? $getBase64($kasubag->signature) : null;
        $ttdKepala = $kepala ? $getBase64($kepala->signature) : null;

        // 4. Load View khusus untuk Surat Peminjaman Barang
        // Pastikan file view ini ada di resources/views/surat/peminjaman_barang.blade.php
        $pdf = Pdf::loadView('surat.peminjaman_barang', compact(
            'peminjaman', 
            'peminjam', 
            'admin', 
            'kasubag', 
            'kepala',
            'ttdPeminjam', 
            'ttdAdmin', 
            'ttdKasubag', 
            'ttdKepala'
        ))->setPaper('a4', 'portrait');

        // 5. Download otomatis dengan nama file yang rapi
        $fileName = 'Berita_Acara_Peminjaman_' . $peminjaman->kode_barang . '_' . time() . '.pdf';
        return $pdf->download($fileName);
    }

    // ========== PENGEMBALIAN BARANG ==========
        public function PengembalianBarang(Request $request)
    {
        $query = PengembalianBarang::with([
                'peminjamanBarang', 
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


    public function verifikasiPengembalianBarang(Request $request, $id)
    {
        $pengembalian = PengembalianBarang::findOrFail($id);
        
        $request->validate([
            'status_verifikasi' => 'required|in:diterima,ditolak',
            'komentar_admin' => 'nullable|string'
        ]);

        $pengembalian->update([
            'status_verifikasi' => $request->status_verifikasi,
            'komentar_admin' => $request->komentar_admin,
            'verified_by_adminAsetTetap_id' => auth()->id(),
            'verified_at' => now()
        ]);

        // Update status tabel peminjaman utama
        if ($request->status_verifikasi === 'diterima') {
            $pengembalian->peminjamanBarang->update(['status' => 'dikembalikan']);
            
            // Kembalikan stok jika diperlukan
            $aset = $pengembalian->peminjamanBarang->barang;
            if($aset) {
                $aset->status = 'Tersedia'; // Sesuaikan dengan alur bisnis Anda
                $aset->save();
            }
        } else {
            // Jika ditolak, kembalikan status ke disetujui agar pegawai merevisi pengembalian
            $pengembalian->peminjamanBarang->update(['status' => 'disetujui']);
        }

        return back()->with('success', 'Verifikasi pengembalian berhasil disimpan!');
    }

    public function showPengembalianJsonAdmin($id)
    {
        $data = PengembalianBarang::with(['peminjamanBarang', 'user'])->find($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function cetakSuratPengembalianBarang($id)
    {
        $pengembalian = PengembalianBarang::with(['peminjamanBarang', 'user', 'adminVerifier'])->findOrFail($id);
        
        // Pastikan status sudah diterima agar bisa dicetak
        if ($pengembalian->status_verifikasi !== 'diterima') {
            abort(403, 'Hanya pengembalian yang disetujui yang dapat dicetak.');
        }

        $pdf = Pdf::loadView('surat.pengembalian_barang', compact('pengembalian'))->setPaper('a4', 'portrait');
        
        $fileName = 'Surat_Pengembalian_' . $pengembalian->peminjamanBarang->kode_barang . '.pdf';
        return $pdf->stream($fileName);
    }

    // ========== PEMINJAMAN KENDARAAN ==========
     public function PeminjamanKendaraan(Request $request)
    {
        $peminjamanKendaraan = PeminjamanKendaraan::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('adminasettetap.peminjaman_kendaraan', compact('peminjamanKendaraan'));
    }

    public function reviewPeminjamanKendaraan(Request $request, $id)
    {
        $peminjaman = PeminjamanKendaraan::findOrFail($id);
        
        if ($request->action == 'teruskan') {
            $peminjaman->status = 'dalam_review';
            $peminjaman->reviewed_by_adminasettetap_id = auth()->id();
            $peminjaman->diteruskan_ke_kasubag_date = now();
            $peminjaman->save();
            $msg = 'Permintaan diteruskan ke Kasubag.';
        } else {
            $peminjaman->status = 'ditolak';
            $peminjaman->komentar = $request->komentar;
            $peminjaman->save();
            $msg = 'Permintaan ditolak.';
        }

        return back()->with('success', $msg);
    }

    public function uploadBastKendaraan(Request $request, $id)
    {
        $request->validate(['surat_bast' => 'required|mimes:pdf|max:2048']);
        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        if ($request->hasFile('surat_bast')) {
            $path = $request->file('surat_bast')->store('surat_peminjaman_kendaraan', 'public');
            $peminjaman->update(['surat_bast_path' => $path]);
        }

        return back()->with('success', 'Surat persetujuan berhasil diunggah.');
    }

    public function generateSuratPeminjamanKendaraan(PeminjamanKendaraan $peminjaman)
    {
        // 1. Ambil data pihak terkait
        // Data peminjam sudah otomatis terambil dari relasi (jika sudah diset di model)
        $peminjam = $peminjaman->user; 
        $admin = auth()->user(); // Admin yang sedang login dan mencetak surat
        $kasubag = User::where('role', 'kasubag')->first(); 
        $kepala = User::where('role', 'kepalabpmp')->first(); // Pastikan rolenya sesuai dengan database Anda

        // 2. Fungsi bantuan untuk mengubah tanda tangan (lokal) menjadi Base64 agar bisa dirender DomPDF
        $getBase64 = function ($path) {
            if ($path && Storage::disk('public')->exists($path)) {
                $type = pathinfo(storage_path('app/public/' . $path), PATHINFO_EXTENSION);
                $data = Storage::disk('public')->get($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return null;
        };

        // 3. Siapkan gambar tanda tangan (Signature) masing-masing pihak
        $ttdPeminjam = $peminjam ? $getBase64($peminjam->signature) : null;
        $ttdAdmin = $admin ? $getBase64($admin->signature) : null;
        $ttdKasubag = $kasubag ? $getBase64($kasubag->signature) : null;
        $ttdKepala = $kepala ? $getBase64($kepala->signature) : null;

        // 4. Load View khusus untuk Surat Peminjaman Kendaraan
        // Sesuaikan path 'surat.peminjaman_kendaraan' dengan lokasi file blade Berita Acara Anda
        $pdf = Pdf::loadView('surat.peminjaman_kendaraan', compact(
            'peminjaman', 
            'peminjam', 
            'admin', 
            'kasubag', 
            'kepala',
            'ttdPeminjam', 
            'ttdAdmin', 
            'ttdKasubag', 
            'ttdKepala'
        ))->setPaper('a4', 'portrait');

        // 5. Tampilkan PDF (Stream) atau Download Otomatis
        $fileName = 'BA_Pinjam_Kendaraan_' . ($peminjaman->kode_barang ?? $peminjaman->id) . '_' . time() . '.pdf';
        
        // Gunakan ->stream() jika ingin melihat preview di browser dulu
        // Gunakan ->download() jika ingin file langsung terunduh ke komputer
        return $pdf->stream($fileName); 
    }

    public function showJsonKendaraan($id)
    {
        // Mengambil data peminjaman beserta nama user
        $data = PeminjamanKendaraan::with('user')->find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    
    // ========== PENGEMBALIAN KENDARAAN ==========
    public function PengembalianKendaraan(Request $request)
    {
        $query = PengembalianKendaraan::with([
                'peminjamanKendaraan', 
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


    public function verifikasiPengembalianKendaraan(Request $request, $id)
    {
        $pengembalian = PengembalianKendaraan::findOrFail($id);
        
        $request->validate([
            'status_pengembalian' => 'required|in:diterima,ditolak',
            'komentar_admin' => 'nullable|string'
        ]);

        $pengembalian->update([
            'status_pengembalian' => $request->status_pengembalian,
            'komentar_admin' => $request->komentar_admin,
            'verified_by_admin_id' => auth()->id(),
            'verified_at' => now()
        ]);

        if ($request->status_pengembalian === 'diproses') {
            $pengembalian->peminjamanKendaraan()->update(['status' => 'diterima']);
            
            // Kembalikan stok jika diperlukan
            $aset = $pengembalian->peminjamanKendaraan()->barang;
            if($aset) {
                $aset->status = 'Tersedia'; // Sesuaikan dengan alur bisnis Anda
                $aset->save();
            }
        } else {
            // Jika ditolak, kembalikan status ke disetujui agar pegawai merevisi pengembalian
            $pengembalian->peminjamanKendaraan->update(['status' => 'disetujui']);
        }

        return back()->with('success', 'Verifikasi pengembalian kendaraan berhasil disimpan!');

        
    }

    public function showPengembalianKendaraanJsonAdmin($id)
    {
        $data = PengembalianKendaraan::with(['peminjamanKendaraan', 'user'])->find($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function cetakSuratPengembalianKendaraan($id)
    {
        $pengembalian = PengembalianKendaraan::with(['peminjamanKendaraan', 'user', 'admin'])->findOrFail($id);
        
        // Ambil data user admin dan kepala dari tabel users
        $admin = auth()->user();
        $kepala = \App\Models\User::where('role', 'kepalabpmp')->first();

        $pdf = Pdf::loadView('surat.pengembalian_kendaraan', compact('pengembalian', 'admin', 'kepala'))
                ->setPaper('a4', 'portrait');
        
        $kodeBarang = $pengembalian->peminjamanKendaraan->nama_barang ?? 'Kendaraan';
        return $pdf->stream('Surat_Pengembalian_' . $kodeBarang . '.pdf');
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

    public function pengaduanDestroy(Pengaduan $pengaduan)  // ✅ Changed name
    {
        $pengaduan->delete();
        return redirect()->route('adminasettetap.pengaduan')
            ->with('success', 'Pengaduan berhasil dihapus!');
    }

    public function pengaduanUpdate(Request $request, Pengaduan $pengaduan)  // ✅ Changed name
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('adminasettetap.pengaduan')
            ->with('success', 'Status pengaduan #' . $pengaduan->id . ' berhasil diupdate!');
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
        
        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim! ');

    } catch (\Exception $e) {
        // Mengubah response JSON menjadi Redirect dengan Session Error dan menyimpan input lama
        return redirect()->back()->with('error', 'Gagal menyimpan pengaduan. Silakan coba lagi.')->withInput();
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

       return redirect()->back()->with('success', 'Terima kasih atas feedback Anda! Survey berhasil dikirim.');

    } catch (\Exception $e) {
        // Mengubah response JSON menjadi Redirect dengan Session Error dan menyimpan input lama
        return redirect()->back()->with('error', 'Gagal menyimpan survey. Silakan coba lagi.')->withInput();
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

    // public function exportExcel(Request $request)
    // {
    // return Excel::download(new SurveyExport($request), 'survey.excel-export' . now()->format('d-m-Y') . '.xlsx');
    // }
    
}
