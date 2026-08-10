<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetTetap;
use App\Models\Persediaan;
use App\Models\TransaksiMasukAssetTetap;
use App\Models\TransaksiKeluarAssetTetap;
use App\Models\TransaksiMasukPersediaan;
use App\Models\TransaksiKeluarPersediaan;

class SaktiIntegrationController extends Controller
{
    private function sendResponse($data, $message = 'Success')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public function getAsetTetap(Request $request)
    {
        $data = AssetTetap::paginate(100);
        return $this->sendResponse($data, 'Data Master Aset Tetap');
    }

    public function getPersediaan(Request $request)
    {
        $data = Persediaan::paginate(100);
        return $this->sendResponse($data, 'Data Master Persediaan');
    }

    public function getMasukAsetTetap(Request $request)
    {
        $data = TransaksiMasukAssetTetap::paginate(100);
        return $this->sendResponse($data, 'Data Transaksi Masuk Aset Tetap');
    }

    public function getKeluarAsetTetap(Request $request)
    {
        $data = TransaksiKeluarAssetTetap::paginate(100);
        return $this->sendResponse($data, 'Data Transaksi Keluar Aset Tetap');
    }

    public function getMasukPersediaan(Request $request)
    {
        $data = TransaksiMasukPersediaan::paginate(100);
        return $this->sendResponse($data, 'Data Transaksi Masuk Persediaan');
    }

    public function getKeluarPersediaan(Request $request)
    {
        $data = TransaksiKeluarPersediaan::paginate(100);
        return $this->sendResponse($data, 'Data Transaksi Keluar Persediaan');
    }
}