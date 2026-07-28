<?php

namespace App\Exports;

use App\Models\Persediaan; // Sesuaikan jika nama model Anda berbeda
use \App\Models\TransaksiMasukPersediaan;
use \App\Models\TransaksiKeluarPersediaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPersediaanExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    // Menangkap parameter tanggal dari Controller
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        // $this->data = $data;
    }

    public function view(): View
    {
        // Pastikan query ini sama persis dengan query di Controller bagian PDF Anda
        $dataPersediaan = Persediaan::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $transaksi_masuk = \App\Models\TransaksiMasukPersediaan::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $transaksi_keluar = \App\Models\TransaksiKeluarPersediaan::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $permintaan = \App\Models\PermintaanPersediaan::whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        // Menggunakan tampilan (view) yang sama dengan PDF untuk di-convert ke Excel
        return view('kepalabpmp.exports.laporan_persediaan', [
            'persediaan'   => $dataPersediaan, // Sesuaikan variabel ini dengan yang diminta oleh file blade laporan_persediaan
            'transaksi_masuk' => $transaksi_masuk,
            'transaksi_keluar' => $transaksi_keluar,
            'permintaan' => $permintaan,

            'title'        => 'Laporan Persediaan',
            'periode'      => Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y'),
            'generated_by' => Auth::user()->name,
            'generated_at' => Carbon::now(),
        ]);
    }
}