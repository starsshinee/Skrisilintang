<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaktiProviderController extends Controller
{
    public function getAset()
    {
        // Contoh response data statis/query database dari Sakti
        $dataSakti = [
            [
                'kode_aset' => 'SAKTI-A001',
                'nama_barang' => 'Server Rak Dell',
                'kondisi' => 'Baik'
            ],
            [
                'kode_aset' => 'SAKTI-A002',
                'nama_barang' => 'Router Cisco',
                'kondisi' => 'Rusak Ringan'
            ]
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data dari Sakti berhasil ditarik',
            'data' => $dataSakti
        ], 200);
    }
}