<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SaktiApiService;
use App\Models\AssetTetap;
use App\Models\Persediaan;

class AdminSaktiController extends Controller
{
    protected $saktiApi;

    public function __construct(SaktiApiService $saktiApi)
    {
        $this->saktiApi = $saktiApi;
    }

    public function indexAsetTetap()
    {
        // Ambil data aset tetap dari database lokal untuk ditampilkan
        $data_aset = AssetTetap::all();
        return view('adminsakti.sakti_aset_tetap', compact('data_aset'));
    }

    public function indexPersediaan()
    {
        // Ambil data persediaan dari database lokal untuk ditampilkan
        $data_persediaan = Persediaan::all();
        return view('adminsakti.sakti_persediaan', compact('data_persediaan'));
    }

    public function sync(Request $request)
    {
        // Cek input hidden 'jenis_data' dari form
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

        // Redirect kembali ke halaman yang sesuai dengan pesan sukses/error
        if ($result['status'] == 'success') {
            return redirect()->route($route)->with('success', $result['message']);
        }

        return redirect()->route($route)->with('error', $result['message']);
    }
}