<?php

namespace App\Exports;

// Sesuaikan nama-nama Model ini dengan yang ada di folder app/Models Anda
use App\Models\Gedung; 
use App\Models\Kerusakan; // Atau mungkin namanya KerusakanBarang / KerusakanAset
use App\Models\PeminjamanGedung; 

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanSarprasExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        // 1. Ambil Data Gedung (Master Data)
        $gedung = Gedung::all();

        // 2. Ambil Data Kerusakan (Berdasarkan rentang tanggal input)
        // Pastikan kolom tanggal di tabel kerusakan namanya benar (contoh: tanggal_input)
        $kerusakan = Kerusakan::whereBetween('tanggal_input', [$this->startDate, $this->endDate])
            ->orderBy('tanggal_input', 'desc')
            ->get();

        // 3. Ambil Data Peminjaman Gedung (Berdasarkan rentang tanggal pinjam)
        $peminjaman_gedung = PeminjamanGedung::with('gedung')
            ->whereBetween('tanggal_pinjam', [$this->startDate, $this->endDate])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // 4. Siapkan Data Statistik (Format Array sesuai permintaan View)
        $stats = [
            'total_gedung'            => $gedung->count(),
            // Sesuaikan string 'Tersedia' atau 'tersedia' dengan isi database Anda
            'gedung_tersedia'         => $gedung->where('ketersediaan', 'Tersedia')->count(), 
            'total_kerusakan'         => $kerusakan->count(),
            'total_peminjaman_gedung' => $peminjaman_gedung->count(),
        ];

        // 5. Kembalikan ke View
        return view('kepalabpmp.exports.laporan_sarpras', [
            'title'             => 'Laporan Sarana dan Prasarana',
            'periode'           => Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y'),
            'generated_by'      => Auth::user()->name,
            'generated_at'      => Carbon::now(),
            
            // Variabel Data
            'stats'             => $stats,
            'gedung'            => $gedung,
            'kerusakan'         => $kerusakan,
            'peminjaman_gedung' => $peminjaman_gedung,
        ]);
    }
}