<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SaktiApiService
{
    protected $baseUrl;
    
    public function __construct()
    {
        // Pastikan SAKTI_API_BASE_URL sudah ada di .env Anda
        $this->baseUrl = env('SAKTI_API_BASE_URL');
    }

    /**
     * Menarik Data Master Aset Tetap dari Sakti
     */
    public function pullMasterAsetTetap()
    {
        if (empty($this->baseUrl)) {
            return ['status' => false, 'message' => 'URL API Sakti belum dikonfigurasi di .env'];
        }

        try {
            // Asumsi endpoint Sakti adalah /master/aset-tetap (sesuaikan jika berbeda)
            $response = Http::timeout(10)->get($this->baseUrl . '/master/aset-tetap');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Jika Anda ingin langsung menyimpan ke DB SIPANDU, tulis logikanya di sini
                // foreach($data['data'] as $item) { ... }

                return [
                    'status' => true, 
                    'message' => 'Berhasil menarik data Aset Tetap dari Sakti.', 
                    'data' => $data['data'] ?? []
                ];
            }

            return ['status' => false, 'message' => 'Sakti API merespon dengan error HTTP: ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('Error Pull Aset Tetap Sakti: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Terjadi kesalahan saat menghubungi API Sakti.'];
        }
    }

    /**
     * Menarik Data Master Persediaan dari Sakti
     */
    public function pullMasterPersediaan()
    {
        if (empty($this->baseUrl)) {
            return ['status' => false, 'message' => 'URL API Sakti belum dikonfigurasi di .env'];
        }

        try {
            // Asumsi endpoint Sakti adalah /master/persediaan (sesuaikan jika berbeda)
            $response = Http::timeout(10)->get($this->baseUrl . '/master/persediaan');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Jika Anda ingin langsung menyimpan ke DB SIPANDU, tulis logikanya di sini
                
                return [
                    'status' => true, 
                    'message' => 'Berhasil menarik data Persediaan dari Sakti.', 
                    'data' => $data['data'] ?? []
                ];
            }

            return ['status' => false, 'message' => 'Sakti API merespon dengan error HTTP: ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('Error Pull Persediaan Sakti: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Terjadi kesalahan saat menghubungi API Sakti.'];
        }
    }
}