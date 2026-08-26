<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

// Import Model berdasarkan struktur sistem SIPANDU 
use App\Models\AssetTetap;
use App\Models\TransaksiMasukAssetTetap;
use App\Models\TransaksiKeluarAssetTetap;
use App\Models\Persediaan;
use App\Models\TransaksiMasukPersediaan;
use App\Models\TransaksiKeluarPersediaan;

class PenarikanDataController extends Controller
{
    // ==========================================
    // BAGIAN 1: ASET TETAP
    // ==========================================

    public function getMasterAssetTetap(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);
            
            $data = AssetTetap::query()
                ->when($request->query('nama'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                ->when($request->query('nup'), fn($q, $nup) => $q->where('nup', $nup))
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getMasukAssetTetap(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);

            $data = TransaksiMasukAssetTetap::with('assetTetap')
                // Filter waktu transaksi
                ->when($request->query('bulan'), fn($q, $bulan) => $q->whereMonth('tanggal_transaksi', $bulan))
                ->when($request->query('tahun'), fn($q, $tahun) => $q->whereYear('tanggal_transaksi', $tahun))
                // Filter relasi ke data master
                ->whereHas('assetTetap', function ($query) use ($request) {
                    $query->when($request->query('nama'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                          ->when($request->query('nup'), fn($q, $nup) => $q->where('nup', $nup));
                })
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getKeluarAssetTetap(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);

            $data = TransaksiKeluarAssetTetap::with('assetTetap')
                // Filter waktu transaksi
                ->when($request->query('bulan'), fn($q, $bulan) => $q->whereMonth('tanggal_transaksi', $bulan))
                ->when($request->query('tahun'), fn($q, $tahun) => $q->whereYear('tanggal_transaksi', $tahun))
                // Filter relasi ke data master
                ->whereHas('assetTetap', function ($query) use ($request) {
                    $query->when($request->query('nama'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                          ->when($request->query('nup'), fn($q, $nup) => $q->where('nup', $nup));
                })
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // BAGIAN 2: PERSEDIAAN
    // ==========================================

    public function getMasterPersediaan(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);

            $data = Persediaan::query()
                ->when($request->query('nama_barang'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                ->when($request->query('kode_barang'), fn($q, $kode) => $q->where('kode_barang', $kode))
                ->when($request->query('kode_kategori'), fn($q, $kategori) => $q->where('kode_kategori', $kategori))
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getMasukPersediaan(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);

            $data = TransaksiMasukPersediaan::with('persediaan')
                ->when($request->query('bulan'), fn($q, $bulan) => $q->whereMonth('tanggal_transaksi', $bulan))
                ->when($request->query('tahun'), fn($q, $tahun) => $q->whereYear('tanggal_transaksi', $tahun))
                ->whereHas('persediaan', function ($query) use ($request) {
                    $query->when($request->query('nama_barang'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                          ->when($request->query('kode_barang'), fn($q, $kode) => $q->where('kode_barang', $kode))
                          ->when($request->query('kode_kategori'), fn($q, $kategori) => $q->where('kode_kategori', $kategori));
                })
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getKeluarPersediaan(Request $request)
    {
        try {
            $limit = $request->query('limit', 20);

            $data = TransaksiKeluarPersediaan::with('persediaan')
                ->when($request->query('bulan'), fn($q, $bulan) => $q->whereMonth('tanggal_transaksi', $bulan))
                ->when($request->query('tahun'), fn($q, $tahun) => $q->whereYear('tanggal_transaksi', $tahun))
                ->whereHas('persediaan', function ($query) use ($request) {
                    $query->when($request->query('nama_barang'), fn($q, $nama) => $q->where('nama_barang', 'like', "%{$nama}%"))
                          ->when($request->query('kode_barang'), fn($q, $kode) => $q->where('kode_barang', $kode))
                          ->when($request->query('kode_kategori'), fn($q, $kategori) => $q->where('kode_kategori', $kategori));
                })
                ->paginate($limit);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}