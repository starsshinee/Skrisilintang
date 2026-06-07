<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanAsetTetapExport implements FromView, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        // Kita arahkan ke view blade khusus excel agar lebih rapi
        return view('kepalabpmp.exports.laporan_asettetap_excel', $this->data);
    }
}