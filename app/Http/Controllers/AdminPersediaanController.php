<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\{
    User,
    Persediaan,
    PermintaanPersediaan,
    TransaksiKeluarPersediaan,
    TransaksiMasukPersediaan,
};
  

class AdminPersediaanController extends Controller
{
    public function dashboard()
    {
        
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // 1. Hitung Total & Nilai Persediaan
        $totalPersediaan = \App\Models\Persediaan::count();
        $totalNilaiPersediaan = \App\Models\Persediaan::sum('harga_total') ?? 0;

        // 2. Transaksi Bulan Ini
        $masukBulanIni = \App\Models\TransaksiMasukPersediaan::whereMonth('tanggal_input', $bulanIni)
                            ->whereYear('tanggal_input', $tahunIni)->count();
        $keluarBulanIni = \App\Models\TransaksiKeluarPersediaan::whereMonth('tanggal_input', $bulanIni)
                            ->whereYear('tanggal_input', $tahunIni)->count();

        // 3. Status Permintaan Persediaan
        $permintaanPending = \App\Models\PermintaanPersediaan::whereIn('status', ['pending', 'dalam_review'])->count();
        $permintaanDisetujui = \App\Models\PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count();
        $permintaanDitolak = \App\Models\PermintaanPersediaan::whereIn('status', ['ditolak', 'ditolak_kasubag'])->count();
        $totalPermintaan = \App\Models\PermintaanPersediaan::count();

        // 4. Data Grafik: Tren Transaksi Keluar Bulanan (Tahun ini)
        $chartData = [];
        $maxChart = 1; // Mencegah division by zero
        for ($i = 1; $i <= 12; $i++) {
            $count = \App\Models\TransaksiKeluarPersediaan::whereMonth('tanggal_input', $i)
                        ->whereYear('tanggal_input', $tahunIni)->count();
            $chartData[$i] = $count;
            if ($count > $maxChart) {
                $maxChart = $count;
            }
        }

        return view('adminpersediian.dashbord', compact(
            'totalPersediaan', 'totalNilaiPersediaan', 'masukBulanIni', 'keluarBulanIni',
            'permintaanPending', 'permintaanDisetujui', 'permintaanDitolak', 'totalPermintaan',
            'chartData', 'maxChart', 'tahunIni'
        ));
    }

    // 📋 DATA PERSEDIAAN
    public function dataPersediaan(Request $request)
    {
        $query = Persediaan::query();
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('kategori', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kode_kategori', $request->kategori);
        }

        $persediaan = $query->latest()->paginate(10);

        return view('adminpersediian.data_persediaan', compact('persediaan'));
    }

    public function create()
    {
        return view('adminpersediian.form_persediaan');
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga_satuan' => str_replace('.', '', $request->harga_satuan)
        ]);

        $request->validate([
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50|unique:persediaan,kode_barang',
            'nama_barang' => 'required|string|max:200',
            'tanggal_masuk' => 'required|date',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
        ]);

        Persediaan::create($request->all() + [
            'harga_total' => $request->harga_satuan * $request->jumlah,
        ]);

        return redirect()->route('adminpersediaan.data-persediaan')
            ->with('success', 'Data persediaan berhasil ditambahkan!');
    }

    public function show(Persediaan $persediaan)
    {
        return view('adminpersediian.detail_persediaan', compact('persediaan'));
    }

    public function edit(Persediaan $persediaan)
    {
        return view('adminpersediian.form_persediaan', compact('persediaan'));
    }

    public function update(Request $request, Persediaan $persediaan)
    {
        $request->merge([
            'harga_satuan' => str_replace('.', '', $request->harga_satuan)
        ]);

        $request->validate([
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => ['required', 'string', 'max:50', Rule::unique('persediaan')->ignore($persediaan)],
            'nama_barang' => 'required|string|max:200',
            'tanggal_masuk' => 'required|date',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
        ]);

        $persediaan->update($request->all() + [
            'harga_total' => $request->harga_satuan * $request->jumlah,
        ]);

        return redirect()->route('adminpersediaan.data-persediaan')
            ->with('success', 'Data persediaan berhasil diupdate!');
    }

    public function destroy(Persediaan $persediaan)
    {
        $persediaan->delete();
        return redirect()->route('adminpersediaan.data-persediaan')
            ->with('success', 'Data persediaan berhasil dihapus!');
    }

    // 📤 Transaksi Keluar
    //=========TRANSAKSI KELUAR PERSEDIAAN========//
    
    /** INDEX - Tampilkan daftar transaksi keluar */
    public function transaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarPersediaan::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
                  ->orWhere('nomor_transaksi', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_kategori', 'like', '%'.$request->search.'%')
                  ->orWhere('kategori', 'like', '%'.$request->search.'%');
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal_input')) {
            $query->whereDate('tanggal_input', $request->tanggal_input);
        }

        // Filter kode kategori
        if ($request->filled('kode_kategori')) {
            $query->where('kode_kategori', $request->kode_kategori);
        }

        $transaksi = $query->latest('tanggal_input')->paginate(10);
        
        return view('adminpersediian.transaksi_keluar', compact('transaksi'));
    }

    /** CREATE - Tampilkan form tambah */
    public function createTransaksiKeluar()
    {
        $persediaan = Persediaan::select('kode_barang', 'nama_barang')
                               ->orderBy('kategori')
                               ->get();
        
        return view('adminpersediian.form_transaksi_keluar', compact('persediaan'));
    }

    /** STORE - Simpan transaksi keluar */
    public function storeTransaksiKeluar(Request $request)
    {
        $request->validate([
            'nomor_transaksi' => 'required|string|max:50|unique:transaksi_keluar_persediaan,nomor_transaksi',
            'tanggal_input' => 'required|date',
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'jumlah_keluar' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cek stok persediaan
        $persediaan = Persediaan::where('kode_barang', $request->kode_barang)->first();
        if (!$persediaan || $persediaan->jumlah < $request->jumlah_keluar) {
            return back()->withErrors(['jumlah_keluar' => 'Stok persediaan tidak mencukupi!'])
                        ->withInput();
        }

        // Simpan transaksi
        TransaksiKeluarPersediaan::create($request->all());

        // Kurangi stok persediaan
        $persediaan->decrement('jumlah', $request->jumlah_keluar);

        return redirect()->route('adminpersediaan.transaksi-keluar')
            ->with('success', 'Transaksi keluar berhasil disimpan!');
    }

    /** SHOW - Detail transaksi */
    public function showTransaksiKeluar(TransaksiKeluarPersediaan $transaksiKeluar)
    {
        return response()->json($transaksiKeluar);
    }

    /** EDIT - Form edit */
    public function editTransaksiKeluar(TransaksiKeluarPersediaan $transaksiKeluar)
    {
        $persediaan = Persediaan::select('kode_barang', 'nama_barang')
                               ->orderBy('kategori')
                               ->get();
        
        return view('adminpersediian.form_transaksi_keluar', [
            'transaksi' => $transaksiKeluar,
            'persediaan' => $persediaan
        ]);
    }

    /** UPDATE - Update transaksi */
    public function updateTransaksiKeluar(Request $request, TransaksiKeluarPersediaan $transaksiKeluar)
    {
        $request->validate([
            'nomor_transaksi' => ['required', 'string', 'max:50', Rule::unique('transaksi_keluar_persediaan', 'nomor_transaksi')->ignore($transaksiKeluar->id)],
            'tanggal_input' => 'required|date',
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'jumlah_keluar' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // 🔥 VALIDASI STOK: Cek apakah kode barang berubah
    $persediaanLama = Persediaan::where('kode_barang', $transaksiKeluar->kode_barang)->first();
    $persediaanBaru = Persediaan::where('kode_barang', $request->kode_barang)->first();

    // Cek stok persediaan BARU
    if (!$persediaanBaru || $persediaanBaru->jumlah < $request->jumlah_keluar) {
        return back()->withErrors(['jumlah_keluar' => 'Stok persediaan tidak mencukupi!'])
                    ->withInput();
    }

    // 🔥 Backup data lama untuk adjust stok
    $oldJumlahKeluar = $transaksiKeluar->jumlah_keluar;
    $oldKodeBarang = $transaksiKeluar->kode_barang;
    $kodeBarangBerubah = $oldKodeBarang !== $request->kode_barang;

    // 🔥 SATU KALI UPDATE SAJA - Biarkan mutator handle total
    $transaksiKeluar->update($request->all());

    //🔥 Adjust stok persediaan
    if ($kodeBarangBerubah) {
        // Kembalikan stok BARANG LAMA
        if ($persediaanLama) {
            $persediaanLama->increment('jumlah', $oldJumlahKeluar);
        }
        // Kurangi stok BARANG BARU
        $persediaanBaru->decrement('jumlah', $request->jumlah_keluar);
    } else {
        // Sama barang, adjust selisih jumlah
        $selisih = $oldJumlahKeluar - $request->jumlah_keluar;
        if ($selisih > 0) {
            $persediaanBaru->increment('jumlah', $selisih);
        } elseif ($selisih < 0) {
            $persediaanBaru->decrement('jumlah', abs($selisih));
        }
    }

    return redirect()->route('adminpersediaan.transaksi-keluar')
        ->with('success', 'Transaksi keluar berhasil diupdate!');
    }

    /** DESTROY - Hapus transaksi keluar */
    public function destroyTransaksiKeluar(TransaksiKeluarPersediaan $transaksiKeluar)
    {
        // Kembalikan stok persediaan
        $persediaan = Persediaan::where('kode_barang', $transaksiKeluar->kode_barang)->first();
        if ($persediaan) {
            $persediaan->increment('jumlah', $transaksiKeluar->jumlah_keluar);
        }

        $transaksiKeluar->delete();

        return redirect()->route('adminpersediaan.transaksi-keluar')
            ->with('success', 'Transaksi keluar berhasil dihapus!');
    }

    // 📥 Transaksi Masuk Persediaan
/** INDEX - Tampilkan daftar transaksi masuk */
    public function transaksiMasuk(Request $request)
    {
        $query = TransaksiMasukPersediaan::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
                ->orWhere('no', 'like', '%'.$request->search.'%')
                ->orWhere('kode_kategori', 'like', '%'.$request->search.'%')
                ->orWhere('kategori', 'like', '%'.$request->search.'%');
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal_input')) {
            $query->whereDate('tanggal_input', $request->tanggal_input);
        }

        // Filter kategori
        if ($request->filled('kode_kategori')) {
            $query->where('kode_kategori', $request->kode_kategori);
        }

        $transaksi = $query->latest('tanggal_input')->paginate(10);
        
        return view('adminpersediian.transaksi_masuk', compact('transaksi'));
    }

    /** CREATE - Tampilkan form tambah */
    public function createTransaksiMasuk()
    {
        return view('adminpersediian.form_transaksi_masuk');
    }

    /** STORE - Simpan transaksi masuk */
    public function storeTransaksiMasuk(Request $request)
    {
        $request->validate([
            'tanggal_input' => 'required|date',
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'jumlah_masuk' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'created_by' => 'nullable|string|max:100',
        ]);

        // Cek apakah barang sudah ada di persediaan
        $persediaan = Persediaan::where('kode_barang', $request->kode_barang)->first();

        if ($persediaan) {
            // Update persediaan yang sudah ada
            $persediaan->setRawAttributes([
                'harga_total' => ($persediaan->getRawOriginal('harga_total') ?? 0) + ($request->harga_satuan * $request->jumlah_masuk)
            ]);
            $persediaan->save();
        } else {
            // Buat persediaan baru
            Persediaan::create([
                'kode_kategori' => $request->kode_kategori,
                'kategori' => $request->kategori,
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'tanggal_masuk' => $request->tanggal_input,
                'harga_satuan' => $request->harga_satuan,
                'jumlah' => $request->jumlah_masuk,
                'harga_total' => $request->harga_satuan * $request->jumlah_masuk,
            ]);
        }

        // Simpan transaksi masuk
        TransaksiMasukPersediaan::create($request->all() + [
            'total' => $request->harga_satuan * $request->jumlah_masuk,
            'user_id' => auth()->id() ?? null,
        ]);

        return redirect()->route('adminpersediaan.transaksi-masuk')
            ->with('success', 'Transaksi masuk berhasil disimpan!');
    }

    /** SHOW - Detail transaksi */
    public function showTransaksiMasuk(TransaksiMasukPersediaan $transaksiMasuk)
    {
        return view('adminpersediian.detail_transaksi_masuk', compact('transaksiMasuk'));
    }

    /** EDIT - Form edit */
    public function editTransaksiMasuk(TransaksiMasukPersediaan $transaksiMasuk)
    {
        return view('adminpersediian.form_transaksi_masuk', compact('transaksiMasuk'));
    }

    /** UPDATE - Update transaksi */
    public function updateTransaksiMasuk(Request $request, TransaksiMasukPersediaan $transaksiMasuk)
    {
        $request->validate([
            'tanggal_input' => 'required|date',
            'kode_kategori' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'jumlah_masuk' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'created_by' => 'nullable|string|max:100',
        ]);

        // Backup data lama untuk adjust persediaan
        $oldJumlah = $transaksiMasuk->jumlah_masuk;
        $oldKodeBarang = $transaksiMasuk->kode_barang;

        // Update transaksi
        $transaksiMasuk->update($request->all() + [
            'total' => $request->harga_satuan * $request->jumlah_masuk,
        ]);

        // Adjust persediaan lama (kurangi jumlah lama)
        $persediaanLama = Persediaan::where('kode_barang', $oldKodeBarang)->first();
        if ($persediaanLama) {
            $persediaanLama->decrement('jumlah', $oldJumlah);
            if ($persediaanLama->jumlah == 0) {
                $persediaanLama->delete();
            }
        }

        // Update persediaan baru
        $persediaanBaru = Persediaan::where('kode_barang', $request->kode_barang)->first();
        if ($persediaanBaru) {
            $persediaanBaru->increment('jumlah', $request->jumlah_masuk);
        } else {
            Persediaan::create([
                'kode_kategori' => $request->kode_kategori,
                'kategori' => $request->kategori,
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'tanggal_masuk' => $request->tanggal_input,
                'harga_satuan' => $request->harga_satuan,
                'jumlah' => $request->jumlah_masuk,
                'harga_total' => $request->harga_satuan * $request->jumlah_masuk,
            ]);
        }

        return redirect()->route('adminpersediaan.transaksi-masuk')
            ->with('success', 'Transaksi masuk berhasil diupdate!');
    }

    /** DESTROY - Hapus transaksi */
    public function destroyTransaksiMasuk(TransaksiMasukPersediaan $transaksiMasuk)
    {
        // Kurangi stok persediaan
        $persediaan = Persediaan::where('kode_barang', $transaksiMasuk->kode_barang)->first();
        if ($persediaan) {
            $persediaan->decrement('jumlah', $transaksiMasuk->jumlah_masuk);
            if ($persediaan->jumlah == 0) {
                $persediaan->delete();
            }
        }

        $transaksiMasuk->delete();

        return redirect()->route('adminpersediaan.transaksi-masuk')
            ->with('success', 'Transaksi masuk berhasil dihapus!');
    }
    
    //PERMINTAAN PERSEDIAAN
    public function permintaanPersediaan(Request $request)
    {
       $query = PermintaanPersediaan::with(['user', 'persediaan', 'reviewedBy'])
                               ->latest();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->whereHas('persediaan', fn($x) => $x->where('nama_barang', 'like', '%'.$request->search.'%'))
              ->orWhere('nama_lengkap', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $permintaan = PermintaanPersediaan::with(['user', 'persediaan'])
                    ->latest()
                    ->get();

    $permintaan = $query->paginate(10);
    return view('adminpersediian.permintaan_persediaan', compact('permintaan'));
    }

    public function showPermintaan($id)
    {
        $permintaan = PermintaanPersediaan::with(['persediaan', 'user', 'reviewedBy', 'approvedByKasubag'])
                        ->findOrFail($id);

        return view('adminpersediian.detail_permintaan', compact('permintaan'));
    }

    public function reviewPermintaan(Request $request, PermintaanPersediaan $permintaan)
    {
        if (!in_array($permintaan->status, ['pending'])) {
            return back()->with('error', 'Permintaan sudah diproses!');
        }

        if ($request->action === 'teruskan') {
            $permintaan->update([
                'status' => 'dalam_review',
                'reviewed_by_adminpersediaan_id' => Auth::id(),
            ]);
            
            return back()->with('success', 'Permintaan diteruskan ke Kasubag!');
        }

        $permintaan->update([
            'status' => 'ditolak',
            'reviewed_by_adminpersediaan_id' => Auth::id(),
        ]);

        return back()->with('success', 'Permintaan ditolak!');
    }

    // 1. FUNGSI GENERATE SURAT (Dilengkapi TTD Base64)
    public function generateSuratPermintaan(PermintaanPersediaan $permintaan)
    {
        // Ambil data user terkait
        $peminjam = $permintaan->user;
        $admin = Auth::user(); 
        $kasubag = User::where('role', 'kasubag')->first(); // Ambil akun kasubag
        $kepala = User::where('role', 'kepalabpmp')->first(); // Ambil akun kepala

        // Fungsi bantuan untuk mengubah gambar lokal menjadi Base64
        $getBase64 = function ($path) {
            if ($path && Storage::disk('public')->exists($path)) {
                $type = pathinfo(storage_path('app/public/' . $path), PATHINFO_EXTENSION);
                $data = Storage::disk('public')->get($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return null;
        };

        // Siapkan TTD (Gunakan properti ->signature sesuai nama di db mu)
        $ttdPeminjam = $peminjam ? $getBase64($peminjam->signature) : null;
        $ttdAdmin = $getBase64($admin->signature);
        $ttdKasubag = $kasubag ? $getBase64($kasubag->signature) : null;
        $ttdKepala = $kepala ? $getBase64($kepala->signature) : null;

        // Load View PDF
        $pdf = PDF::loadView('surat.permintaan_persediaan', compact(
            'permintaan', 'peminjam', 'admin', 'kasubag', 'kepala',
            'ttdPeminjam', 'ttdAdmin', 'ttdKasubag', 'ttdKepala'
        ));

        return $pdf->download('Berita_Acara_Permintaan_' . $permintaan->id . '.pdf');
    }

    // 2. FUNGSI UPLOAD SURAT BAST FINAL OLEH ADMIN
    public function uploadSuratBast(Request $request, PermintaanPersediaan $permintaan)
    {
        $request->validate([
            'surat_bast' => 'required|mimes:pdf|max:2048' // Wajib PDF, max 2MB
        ]);

        if ($request->hasFile('surat_bast')) {
            // Hapus file lama jika admin mengupload ulang
            if ($permintaan->surat_bast_path && Storage::disk('public')->exists($permintaan->surat_bast_path)) {
                Storage::disk('public')->delete($permintaan->surat_bast_path);
            }

            $filename = 'BAST_Persediaan_' . $permintaan->id . '_' . time() . '.pdf';
            $path = $request->file('surat_bast')->storeAs('surat_bast', $filename, 'public');

            $permintaan->update([
                'surat_bast_path' => $path,
                // 'status' => 'selesai' // Opsional, update status menjadi selesai
            ]);

            return back()->with('success', 'Surat Persetujuan Final berhasil diunggah!');
        }

        return back()->with('error', 'Gagal mengunggah surat.');
    }

    public function laporanPermintaanPersediaan()
    {
        // 1. Ambil SEMUA data permintaan
        $permintaan = PermintaanPersediaan::with(['user', 'persediaan'])->latest()->get();

        // 2. Statistik Keseluruhan
        $stats = [
            'total' => $permintaan->count(),
            'diproses' => $permintaan->whereIn('status', ['pending', 'dalam_review'])->count(),
            'ditolak' => $permintaan->whereIn('status', ['ditolak', 'ditolak_kasubag'])->count(),
            'disetujui' => $permintaan->whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
        ];

        // 3. Statistik Bulan Ini
        $bulanIni = $permintaan->filter(fn($item) => $item->created_at->isCurrentMonth());
        $statsBulanIni = [
            'total' => $bulanIni->count(),
            'disetujui' => $bulanIni->whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
            'pending' => $bulanIni->whereIn('status', ['pending', 'dalam_review'])->count(),
            'ditolak' => $bulanIni->whereIn('status', ['ditolak', 'ditolak_kasubag'])->count(),
        ];

        // 4. Perhitungan Lanjutan (Rata-rata & Persentase)
        $approvalRate = $stats['total'] > 0 ? round(($stats['disetujui'] / $stats['total']) * 100) : 0;
        $avgItems = $stats['total'] > 0 ? round($permintaan->avg('jumlah_diminta')) : 0;

        // 5. Data Grafik Bulanan (Januari - Desember Tahun Ini)
        $monthlyData = [];
        $maxMonth = 1; // Untuk rasio tinggi diagram batang
        for ($i = 1; $i <= 12; $i++) {
            $count = $permintaan->filter(fn($item) => $item->created_at->month == $i && $item->created_at->year == date('Y'))->count();
            $monthlyData[$i] = $count;
            if ($count > $maxMonth) $maxMonth = $count;
        }

        // 6. Data Tab Gabungan (Dikelompokkan berdasarkan Pemohon)
        $summaryData = $permintaan->groupBy('nama_lengkap')->map(function($group) {
            return [
                'total' => $group->count(),
                'disetujui' => $group->whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
                'pending' => $group->whereIn('status', ['pending', 'dalam_review'])->count(),
                'ditolak' => $group->whereIn('status', ['ditolak', 'ditolak_kasubag'])->count(),
            ];
        });

        return view('adminpersediian.laporan_permintaan_persediaan', compact(
            'permintaan', 'stats', 'statsBulanIni', 'approvalRate', 'avgItems', 'monthlyData', 'maxMonth', 'summaryData'
        ));
    }
    // LAPORAN TRANSAKSI MASUK

        public function laporanTransaksiMasuk(Request $request)
    {
        $query = TransaksiMasukPersediaan::query();
        
        // Filters...
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
                ->orWhere('kode_transaksi', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('tanggal_input')) {
            $query->whereDate('tanggal_input', $request->tanggal_input);
        }
        if ($request->filled('kode_kategori')) {
            $query->where('kode_kategori', $request->kode_kategori);
        }

        $transaksi = $query->latest()->paginate(10);

        return view('adminpersediian.laporan_transaksimasuk', compact('transaksi'));
    }

    /**
     * Download Laporan Transaksi Masuk PDF
     */
    public function downloadLaporanTransaksiMasuk(Request $request)
    {
        $query = TransaksiMasukPersediaan::query();

    // Filter sama persis
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('kode_barang', 'like', '%'.$request->search.'%')
              ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
              ->orWhere('kode_kategori', 'like', '%'.$request->search.'%')
              ->orWhere('kategori', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->filled('tanggal_input')) {
        $query->whereDate('tanggal_input', $request->tanggal_input);
    }

    if ($request->filled('kode_kategori')) {
        $query->where('kode_kategori', $request->kode_kategori);
    }

    $transaksi = $query->latest()->get(); // Semua data untuk PDF
    
    $stats = [
        'total_transaksi' => $transaksi->count(),
        'total_nilai' => $transaksi->sum('total'),
        'total_item' => $transaksi->sum('jumlah_masuk'),
    ];

    // ✅ PAKAI BLADE YANG SUDAH ADA!
    $pdf = PDF::loadView('adminpersediian.laporan_transaksimasuk_pdf', compact('transaksi', 'stats'));
    
    $filename = 'Laporan_Transaksi_Masuk_' . now()->format('d-m-Y_His') . '.pdf';
    
    return $pdf->download($filename);
    }
    /**
 * LAPORAN TRANSAKSI KELUAR - Index dengan chart & stats
 */
    public function laporanTransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarPersediaan::query();
        
        // Filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nomor_transaksi', 'like', '%'.$request->search.'%')
                ->orWhere('kode_kategori', 'like', '%'.$request->search.'%')
                ->orWhere('kategori', 'like', '%'.$request->search.'%');
            });
        }
        
        if ($request->filled('tanggal_input')) {
            $query->whereDate('tanggal_input', $request->tanggal_input);
        }
        
        if ($request->filled('kode_kategori')) {
            $query->where('kode_kategori', $request->kode_kategori);
        }

        $transaksi = $query->latest()->paginate(10);
        
        // 📊 CHART & STATS DATA
        $chartData = [];
        
        // 1. Chart: Total Keluar per Bulan (12 bulan terakhir)
        $startDate = now()->subMonths(11)->startOfMonth();
        $monthlyData = TransaksiKeluarPersediaan::selectRaw('
                DATE_FORMAT(tanggal_input, "%Y-%m") as bulan,
                SUM(jumlah_keluar) as total_jumlah,
                SUM(total) as total_nilai
            ')
            ->where('tanggal_input', '>=', $startDate)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');
        
        $chartData['monthly'] = [
            'labels' => [],
            'jumlah_data' => [],
            'nilai_data' => []
        ];
        
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i)->format('Y-m');
            $monthName = now()->subMonths($i)->translatedFormat('M Y');
            
            $chartData['monthly']['labels'][] = $monthName;
            $chartData['monthly']['jumlah_data'][] = (int)($monthlyData[$date]->total_jumlah ?? 0);
            $chartData['monthly']['nilai_data'][] = (int)($monthlyData[$date]->total_nilai ?? 0);
        }
        
        // 2. Top 5 Kategori (berdasarkan jumlah keluar)
        $chartData['top_kategori'] = TransaksiKeluarPersediaan::selectRaw('
                kode_kategori, kategori,
                COUNT(*) as total_transaksi,
                SUM(jumlah_keluar) as total_jumlah,
                SUM(total) as total_nilai
            ')
            ->where('tanggal_input', '>=', now()->subMonths(3))
            ->groupBy('kode_kategori', 'kategori')
            ->orderByDesc('total_jumlah')
            ->limit(5)
            ->get();
        
        // 3. Summary Stats
        $chartData['summary'] = [
            'total_transaksi' => TransaksiKeluarPersediaan::count(),
            'total_jumlah' => (int)TransaksiKeluarPersediaan::sum('jumlah_keluar'),
            'total_nilai' => (int)TransaksiKeluarPersediaan::sum('total'),
            'rata_rata_transaksi' => TransaksiKeluarPersediaan::avg('total'),
        ];

        return view('adminpersediian.laporan_transaksikeluar', compact('transaksi', 'chartData'));
    }

    /**
     * Download Laporan Transaksi Keluar PDF
     */
    public function downloadLaporanTransaksiKeluar(Request $request)
    {
        $query = TransaksiKeluarPersediaan::query();

        // Filter sama persis
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nama_barang', 'like', '%'.$request->search.'%')
                ->orWhere('nomor_transaksi', 'like', '%'.$request->search.'%')
                ->orWhere('kode_kategori', 'like', '%'.$request->search.'%')
                ->orWhere('kategori', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('tanggal_input')) {
            $query->whereDate('tanggal_input', $request->tanggal_input);
        }

        if ($request->filled('kode_kategori')) {
            $query->where('kode_kategori', $request->kode_kategori);
        }

        $transaksi = $query->latest()->get();
        
        $stats = [
            'total_transaksi' => $transaksi->count(),
            'total_nilai' => $transaksi->sum('total'),
            'total_item' => $transaksi->sum('jumlah_keluar'),
            'periode' => $request->tanggal_input ?? 'Semua Periode'
        ];

        $pdf = PDF::loadView('adminpersediian.laporan_pdf_transaksi_keluar', compact('transaksi', 'stats'));
        
        $filename = 'Laporan_Transaksi_Keluar_' . now()->format('d-m-Y_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}