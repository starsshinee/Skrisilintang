<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SaktiApiService
{
    protected $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = env('SAKTI_API_BASE_URL');
    }

    public function syncMasterAsetTetap()
    {
        if (empty($this->baseUrl)) {
            return ['status' => 'error', 'message' => 'URL API Sakti belum dikonfigurasi.'];
        }

        try {
            $response = Http::timeout(10)->get($this->baseUrl . '/api/get-aset-tetap');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // --- LOGIKA SYNC (UPSERT) ---
                // Iterasi data dan simpan ke database SIPANDU
                // foreach($data['data'] as $item) {
                //    AssetTetap::updateOrCreate(['kode_barang' => $item['kode']], $item);
                // }

                return ['status' => 'success', 'message' => 'Sinkronisasi berhasil dilakukan.'];
            }

            return ['status' => 'error', 'message' => 'Gagal mengambil data dari Sakti.'];
        } catch (\Exception $e) {
            Log::error('Sakti API Sync Error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Terjadi kesalahan saat menghubungi API Sakti.'];
        }
    }
}