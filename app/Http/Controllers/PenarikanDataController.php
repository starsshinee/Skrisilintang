<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Inventaris; // Import Model yang sesuai dengan tabel database Anda

class PenarikanDataController extends Controller
{
    /**
     * Endpoint untuk menarik data ke sistem Sakti.
     * Fungsi ini HANYA akan tereksekusi jika request sudah lolos dari Middleware VerifyApiKey.
     */
    public function getData(Request $request)
    {
        try {
            // 1. Lakukan query data dari database
            // Contoh menggunakan Eloquent ORM:
            // $data = Inventaris::where('status_validasi', 'valid')->get();

            // Sebagai contoh, ini adalah data statis (mock data) yang merepresentasikan
            // data aset dan status mutasi barang untuk dikirim ke Sakti
            $dataSipandu = [
                [
                    'kode_aset' => 'BMN-2026-001',
                    'nama_barang' => 'Laptop Asus ExpertBook',
                    'kategori' => 'Elektronik',
                    'stok' => 15,
                    'status_mutasi' => 'Selesai divalidasi',
                    'lokasi' => 'Ruang Administrasi'
                ],
                [
                    'kode_aset' => 'BMN-2026-002',
                    'nama_barang' => 'Printer Epson L3210',
                    'kategori' => 'Elektronik',
                    'stok' => 5,
                    'status_mutasi' => 'Proses mutasi',
                    'lokasi' => 'Gudang Utama'
                ]
            ];

            // 2. Kembalikan data dalam format JSON beserta HTTP Status Code 200 (OK)
            return response()->json([
                'status' => 'success',
                'message' => 'Data dari Sipandu berhasil diambil',
                'jumlah_data' => count($dataSipandu),
                'data' => $dataSipandu
            ], 200);

        } catch (\Exception $e) {
            // 3. Tangkap error jika terjadi masalah pada server/database
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses penarikan data: ' . $e->getMessage()
            ], 500);
        }
    }
}