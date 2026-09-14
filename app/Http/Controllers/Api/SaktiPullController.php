<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Exception;

class SaktiPullController extends Controller
{
    public function tarikDataDariSakti()
    {
        try {
            // Mengecek apakah konfigurasi URL Sakti sudah ada di .env
            if (!env('SAKTI_ENDPOINT')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'URL API Sakti belum dikonfigurasi di .env',
                    'data' => null
                ], 500);
            }

            // Melakukan request ke API Sakti dengan menyertakan Header X-API-KEY
            $response = Http::withHeaders([
                'X-API-KEY' => config('services.sakti_api_key')
                ])->timeout(30)
                ->withOptions(['verify' => true])
                ->get(config('services.sakti_endpoint'));

            if ($response->successful()) {
                $data = $response->json();
                
                // TODO: Proses penyimpanan data Sakti ke database Sipandu dilakukan di sini
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menarik data dari Sakti',
                    'data' => $data['data']
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menarik data dari Sakti. Status: ' . $response->status()
            ], $response->status());

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}