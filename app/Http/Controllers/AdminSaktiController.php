<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\SaktiApiService;

class AdminSaktiController extends Controller
{
    protected $saktiApi;
    protected $baseUrl;

    public function __construct(SaktiApiService $saktiApi)
    {
        $this->saktiApi = $saktiApi;
        // Pastikan SAKTI_API_BASE_URL di .env sudah diisi (contoh: http://127.0.0.1:8000/api/mock-sakti)
        $this->baseUrl = env('SAKTI_API_BASE_URL'); 
    }

    /**
     * Jaring pengaman (Fallback): Jika route lama /admin/sakti/data terakses,
     * otomatis alihkan ke halaman Aset Tetap agar tidak error method undefined.
     */
    public function index()
    {
        return redirect()->route('admin.sakti.aset_tetap');
    }

    /**
     * Halaman Monitoring Aset Tetap (Tampil Dinamis/Live)
     */
    public function indexAsetTetap()
    {
        $data_aset = [];
        
        if (!empty($this->baseUrl)) {
            try {
                // Tembak API Sakti secara live
                $response = Http::timeout(10)->get($this->baseUrl . '/get-aset-tetap');
                if ($response->successful()) {
                    $data_aset = $response->json()['data'] ?? [];
                }
            } catch (\Exception $e) {
                // Jika error jaringan/API mati, array tetap kosong agar tidak crash
                $data_aset = []; 
            }
        }

        return view('adminsakti.sakti_aset_tetap', compact('data_aset'));
    }

    /**
     * Halaman Monitoring Persediaan (Tampil Dinamis/Live)
     */
    public function indexPersediaan()
    {
        $data_persediaan = [];
        
        if (!empty($this->baseUrl)) {
            try {
                // Tembak API Sakti secara live
                $response = Http::timeout(10)->get($this->baseUrl . '/get-persediaan');
                if ($response->successful()) {
                    $data_persediaan = $response->json()['data'] ?? [];
                }
            } catch (\Exception $e) {
                $data_persediaan = [];
            }
        }

        return view('adminsakti.sakti_persediaan', compact('data_persediaan'));
    }

    /**
     * Aksi Tombol Sinkronisasi Sekarang
     */
    public function sync(Request $request)
    {
        $jenis = $request->input('jenis_data');

        if ($jenis == 'aset_tetap') {
            $result = $this->saktiApi->syncMasterAsetTetap();
            $route = 'admin.sakti.aset_tetap';
        } elseif ($jenis == 'persediaan') {
            $result = $this->saktiApi->syncMasterPersediaan();
            $route = 'admin.sakti.persediaan';
        } else {
            return back()->with('error', 'Jenis data tidak valid.');
        }

        // Redirect kembali dengan pesan sukses/error
        if ($result['status'] == 'success') {
            return redirect()->route($route)->with('success', $result['message']);
        }

        return redirect()->route($route)->with('error', $result['message']);
    }
}