<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Models\AssetTetap;
use App\Models\TransaksiMasukAssetTetap;
use App\Models\TransaksiKeluarAssetTetap;
use App\Models\Persediaan;
use App\Models\TransaksiMasukPersediaan;
use App\Models\TransaksiKeluarPersediaan;
use App\Models\MutasiBarang;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanKendaraan;
use App\Models\PeminjamanGedung;
use App\Models\PermintaanPersediaan;
use App\Models\PengembalianBarang;
use App\Models\PengembalianKendaraan;
use App\Models\Kerusakan;

class PenarikanDataController extends Controller
{
    private function paginate(Request $request, $query)
    {
        return $query->paginate($request->query('limit', 20));
    }

    private function ok($data)
    {
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    private function fail(Exception $e)
    {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }

    // ==========================================
    // 1. ASET TETAP — MASTER
    // ==========================================

    public function getMasterAssetTetap(Request $request)
    {
        try {
            $data = AssetTetap::query()
                ->when($request->query('nama'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('nup'), fn($q, $v) => $q->where('nup', $v))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('kategori'), fn($q, $v) => $q->where('kategori', 'like', "%{$v}%"))
                ->when($request->query('lokasi'), fn($q, $v) => $q->where('lokasi', 'like', "%{$v}%"));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    public function getMasukAssetTetap(Request $request)
    {
        try {
            $data = TransaksiMasukAssetTetap::with('asetTetap')
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_input', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_input', $v))
                ->whereHas('asetTetap', fn($q) => $q
                    ->when($request->query('nama'), fn($q2, $v) => $q2->where('nama_barang', 'like', "%{$v}%"))
                    ->when($request->query('nup'), fn($q2, $v) => $q2->where('nup', $v))
                );
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    public function getKeluarAssetTetap(Request $request)
    {
        try {
            $data = TransaksiKeluarAssetTetap::with('asetTetap')
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_input', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_input', $v))
                ->whereHas('asetTetap', fn($q) => $q
                    ->when($request->query('nama'), fn($q2, $v) => $q2->where('nama_barang', 'like', "%{$v}%"))
                    ->when($request->query('nup'), fn($q2, $v) => $q2->where('nup', $v))
                );
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 2. PERSEDIAAN — MASTER
    // ==========================================

    public function getMasterPersediaan(Request $request)
    {
        try {
            $data = Persediaan::query()
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('kode_kategori'), fn($q, $v) => $q->where('kode_kategori', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    public function getMasukPersediaan(Request $request)
    {
        try {
            $data = TransaksiMasukPersediaan::query()
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_input', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_input', $v))
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('kode_kategori'), fn($q, $v) => $q->where('kode_kategori', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    public function getKeluarPersediaan(Request $request)
    {
        try {
            $data = TransaksiKeluarPersediaan::query()
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_input', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_input', $v))
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('kode_kategori'), fn($q, $v) => $q->where('kode_kategori', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 3. MUTASI BARANG
    // ==========================================

    public function getMutasiBarang(Request $request)
    {
        try {
            $data = MutasiBarang::with('asetTetap')
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_mutasi', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_mutasi', $v))
                ->when($request->query('nama'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('nup'), fn($q, $v) => $q->where('nup', $v))
                ->when($request->query('kondisi'), fn($q, $v) => $q->where('kondisi', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 4. PEMINJAMAN BARANG
    // ==========================================

    public function getPeminjamanBarang(Request $request)
    {
        try {
            $data = PeminjamanBarang::with('user')
                ->when($request->query('status'), fn($q, $v) => $q->where('status', $v))
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('nup'), fn($q, $v) => $q->where('nup', $v))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('request_date', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('request_date', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 5. PEMINJAMAN KENDARAAN
    // ==========================================

    public function getPeminjamanKendaraan(Request $request)
    {
        try {
            $data = PeminjamanKendaraan::with('user')
                ->when($request->query('status'), fn($q, $v) => $q->where('status', $v))
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('nup'), fn($q, $v) => $q->where('nup', $v))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('request_date', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('request_date', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 6. PEMINJAMAN GEDUNG
    // ==========================================

    public function getPeminjamanGedung(Request $request)
    {
        try {
            $data = PeminjamanGedung::with('user', 'gedung')
                ->when($request->query('status'), fn($q, $v) => $q->where('status', $v))
                ->when($request->query('nama'), fn($q, $v) => $q->where('nama_lengkap', 'like', "%{$v}%"))
                ->when($request->query('fasilitas'), fn($q, $v) => $q->where('fasilitas', 'like', "%{$v}%"))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_pinjam', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_pinjam', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 7. PERMINTAAN PERSEDIAAN
    // ==========================================

    public function getPermintaanPersediaan(Request $request)
    {
        try {
            $data = PermintaanPersediaan::with('user', 'persediaan')
                ->when($request->query('status'), fn($q, $v) => $q->where('status', $v))
                ->when($request->query('nama_barang'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_permintaan', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_permintaan', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 8. PENGEMBALIAN BARANG
    // ==========================================

    public function getPengembalianBarang(Request $request)
    {
        try {
            $data = PengembalianBarang::with('peminjamanBarang', 'user')
                ->when($request->query('status'), fn($q, $v) => $q->where('status_verifikasi', $v))
                ->when($request->query('kondisi'), fn($q, $v) => $q->where('kondisi_barang', $v))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_pengembalian_aktual', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_pengembalian_aktual', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 9. PENGEMBALIAN KENDARAAN
    // ==========================================

    public function getPengembalianKendaraan(Request $request)
    {
        try {
            $data = PengembalianKendaraan::with('peminjamanKendaraan', 'user')
                ->when($request->query('status'), fn($q, $v) => $q->where('status_verifikasi', $v))
                ->when($request->query('kondisi'), fn($q, $v) => $q->where('kondisi_kendaraan', $v))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_pengembalian_aktual', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_pengembalian_aktual', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }

    // ==========================================
    // 10. KERUSAKAN
    // ==========================================

    public function getKerusakan(Request $request)
    {
        try {
            $data = Kerusakan::query()
                ->when($request->query('kondisi'), fn($q, $v) => $q->where('kondisi', $v))
                ->when($request->query('nama'), fn($q, $v) => $q->where('nama_barang', 'like', "%{$v}%"))
                ->when($request->query('kode_barang'), fn($q, $v) => $q->where('kode_barang', $v))
                ->when($request->query('nup'), fn($q, $v) => $q->where('nup', $v))
                ->when($request->query('lokasi'), fn($q, $v) => $q->where('lokasi', 'like', "%{$v}%"))
                ->when($request->query('bulan'), fn($q, $v) => $q->whereMonth('tanggal_input', $v))
                ->when($request->query('tahun'), fn($q, $v) => $q->whereYear('tanggal_input', $v));
            return $this->ok($this->paginate($request, $data));
        } catch (Exception $e) { return $this->fail($e); }
    }
}