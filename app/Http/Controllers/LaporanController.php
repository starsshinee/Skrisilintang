<?php
// app/Http/Controllers/LaporanController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetTetap;
use App\Models\TransaksiMasukAssetTetap;
use App\Models\TransaksiKeluarAssetTetap;
use App\Models\MutasiBarang;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use App\Models\PeminjamanKendaraan;
use App\Models\PengembalianKendaraan;
use App\Models\SurveyKepuasan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $stats = $this->getDashboardStats($request);
        $charts = $this->getChartsData($request);
        $recentActivities = $this->getRecentActivities($request);
        $summary = $this->getSummaryData();

        return view('adminasettetap.laporan.index', compact(
            'stats', 
            'charts', 
            'recentActivities',
            'summary'
        ));
    }

    /**
     * 📊 Get Dashboard Statistics - DIPERBAIKI
     */
    private function getDashboardStats(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        return [
            // 📋 DATA UTAMA
            'total_asset' => AssetTetap::count(),
            'asset_baru' => AssetTetap::whereBetween('created_at', [$startDate, $endDate])->count(),
            
            // 📤 TRANSAKSI
            'transaksi_masuk' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
            'transaksi_keluar' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
            
            // 🔄 MUTASI & PEMINJAMAN
            'mutasi_barang' => MutasiBarang::whereBetween('tanggal_mutasi', [$startDate, $endDate])->count(),
            'peminjaman_barang_aktif' => PeminjamanBarang::whereNotIn('status', ['dikembalikan', 'ditolak'])->count(),
            'peminjaman_kendaraan_aktif' => PeminjamanKendaraan::whereNotIn('status', ['dikembalikan', 'ditolak'])->count(),
            
            // 📊 STATUS UNTUK DOUGHNUT CHART
            'peminjaman_barang_selesai' => PeminjamanBarang::where('status', 'dikembalikan')->count(),
            'peminjaman_kendaraan_selesai' => PeminjamanKendaraan::where('status', 'dikembalikan')->count(),
            'peminjaman_barang_pending' => PeminjamanBarang::whereIn('status', ['pending', 'dalam_review', 'diteruskan_kasubag'])->count(),
            'peminjaman_kendaraan_pending' => PeminjamanKendaraan::whereIn('status', ['pending', 'dalam_review', 'diteruskan_kasubag'])->count(),
            
            // 📊 TREND
            'growth_asset' => $this->calculateGrowth(AssetTetap::class, 'created_at'),
        ];
    }

    /**
     * 📈 Get Charts Data - DIPERBAIKI (Ditambah Peminjaman Barang & Selaras Tanggal)
     */
    private function getChartsData(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        return [
            // 📊 Transaksi Masuk
            'transaksi_masuk_chart' => TransaksiMasukAssetTetap::selectRaw('DATE(tanggal_perolehan) as date, COUNT(*) as count')
                ->whereBetween('tanggal_perolehan', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
                
            // 📊 Transaksi Keluar
            'transaksi_keluar_chart' => TransaksiKeluarAssetTetap::selectRaw('DATE(tanggal_input) as date, COUNT(*) as count')
                ->whereBetween('tanggal_input', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),

            // 📦 Peminjaman Barang
            'peminjaman_barang_chart' => PeminjamanBarang::selectRaw('DATE(tanggal_peminjaman) as date, COUNT(*) as count')
                ->whereBetween('tanggal_peminjaman', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
                
            // 🚗 Peminjaman Kendaraan
            'peminjaman_kendaraan_chart' => PeminjamanKendaraan::selectRaw('DATE(tanggal_peminjaman) as date, COUNT(*) as count')
                ->whereBetween('tanggal_peminjaman', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
    }

    /**
     * ⏰ Recent Activities
     */
    private function getRecentActivities(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(7);
        
        $activities = collect();

        // ✅ Transaksi Masuk
        $activities = $activities->merge(
            TransaksiMasukAssetTetap::where('tanggal_perolehan', '>=', $startDate)
                ->latest('tanggal_perolehan')
                ->limit(2)
                ->get(['id', 'tanggal_perolehan', 'nama_barang'])
                ->map(function($item) {
                    return [
                        'type' => 'transaksi_masuk',
                        'title' => 'Transaksi Masuk Barang',
                        'date' => $item->tanggal_perolehan,
                        'desc' => $item->nama_barang,
                        'icon' => 'fas fa-arrow-down',
                        'color' => 'success'
                    ];
                })
        );

        // ✅ Transaksi Keluar
        $activities = $activities->merge(
            TransaksiKeluarAssetTetap::where('tanggal_input', '>=', $startDate)
                ->latest('tanggal_input')
                ->limit(2)
                ->get(['id', 'tanggal_input', 'nama_barang'])
                ->map(function($item) {
                    return [
                        'type' => 'transaksi_keluar',
                        'title' => 'Transaksi Keluar Barang',
                        'date' => $item->tanggal_input,
                        'desc' => $item->nama_barang,
                        'icon' => 'fas fa-arrow-up',
                        'color' => 'danger'
                    ];
                })
        );

        return $activities
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }

    /**
     * 📋 Summary Data
     */
    private function getSummaryData()
    {
        return [
            // 📊 Top 5 Aset Transaksi
            'top_5_asset_masuk' => TransaksiMasukAssetTetap::selectRaw('nama_barang, COUNT(*) as total')
                ->groupBy('nama_barang')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
                
            'top_5_asset_keluar' => TransaksiKeluarAssetTetap::selectRaw('nama_barang, COUNT(*) as total')
                ->groupBy('nama_barang')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * 📈 Calculate Growth Percentage
     */
    private function calculateGrowth($model, $dateField)
    {
        $currentPeriod = Carbon::now()->startOfMonth();
        $previousPeriod = Carbon::now()->subMonth()->startOfMonth();
        
        $current = $model::whereMonth($dateField, $currentPeriod->month)
                        ->whereYear($dateField, $currentPeriod->year)
                        ->count();
        $previous = $model::whereMonth($dateField, $previousPeriod->month)
                         ->whereYear($dateField, $previousPeriod->year)
                         ->count();
        
        return $previous > 0 ? round(($current - $previous) / $previous * 100, 1) : 0;
    }

    /**
     * 🔍 Filter AJAX untuk Charts
     */
    public function filter(Request $request)
    {
        $charts = $this->getChartsData($request);
        return response()->json($charts);
    }

    /**
     * 📄 Export Laporan
     */
    public function export(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'periode' => "{$startDate->format('d/m/Y')} - {$endDate->format('d/m/Y')}",
            'stats' => $this->getDashboardStats($request),
        ];

        return response()->json(['message' => 'Export ready', 'data' => $data]);
    }

    /**
     * 📥 DOWNLOAD LAPORAN TRANSAKSI MASUK (Excel & PDF)
     */
    public function downloadTransaksiMasuk(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Transaksi Masuk Aset Tetap',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'transaksi' => TransaksiMasukAssetTetap::with('asetTetap')
                ->whereBetween('tanggal_perolehan', [$startDate, $endDate])
                ->orderBy('tanggal_perolehan', 'desc')
                ->get(),
            'total' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
            'total_nilai' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])
                ->sum('nilai_perolehan'),
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data), 'laporan-transaksi-masuk-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.transaksi-masuk', $data);
        return $pdf->download('Laporan-Transaksi-Masuk-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📤 DOWNLOAD LAPORAN TRANSAKSI KELUAR (Excel & PDF)
     */
    public function downloadTransaksiKeluar(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Transaksi Keluar Aset Tetap',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'transaksi' => TransaksiKeluarAssetTetap::with('asetTetap')
                ->whereBetween('tanggal_input', [$startDate, $endDate])
                ->orderBy('tanggal_input', 'desc')
                ->get(),
            'total' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data), 'laporan-transaksi-keluar-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.transaksi-keluar', $data);
        return $pdf->download('Laporan-Transaksi-Keluar-' . now()->format('Y-m-d') . '.pdf');
    }

    
    public function downloadPeminjaman(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Peminjaman',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'peminjaman_barang' => PeminjamanBarang::whereBetween('created_at', [$startDate, $endDate])->get(),
            'peminjaman_kendaraan' => PeminjamanKendaraan::whereBetween('tanggal_peminjaman', [$startDate, $endDate])->get(),
            'stats' => [
                'total_barang' => PeminjamanBarang::whereBetween('created_at', [$startDate, $endDate])->count(),
                'total_kendaraan' => PeminjamanKendaraan::whereBetween('tanggal_peminjaman', [$startDate, $endDate])->count(),
                'aktif_barang' => PeminjamanBarang::where('status', '!=', 'dikembalikan')->count(),
                'aktif_kendaraan' => PeminjamanKendaraan::where('status', '!=', 'dikembalikan')->count(),
            ],
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data), 'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.peminjaman', $data);
        return $pdf->download('Laporan-Peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📊 DOWNLOAD DASHBOARD SUMMARY (PDF)
     */
    public function downloadDashboardSummary(Request $request)
    {
        $stats = $this->getDashboardStats($request);
        $summary = $this->getSummaryData();

        $data = [
            'title' => 'Dashboard Summary Aset Tetap',
            'stats' => $stats,
            'summary' => $summary,
            'periode' => now()->format('F Y'),
            'generated_at' => now()
        ];

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.dashboard-summary', $data);
        return $pdf->download('Dashboard-Summary-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 🎯 SINGLE DOWNLOAD SEMUA LAPORAN (ZIP)
     */
    public function downloadAll(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->format('Y-m-d') : now()->format('Y-m-d');
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : now()->format('Y-m-d');

        // Generate semua PDF
        $files = [];
        
        $pdfFiles = [
            $this->generatePdf('transaksi-masuk', $startDate, $endDate),
            $this->generatePdf('transaksi-keluar', $startDate, $endDate),
            $this->generatePdf('peminjaman', $startDate, $endDate),
        ];

        foreach ($pdfFiles as $file) {
            if ($file) $files[] = $file;
        }

        // Buat ZIP
        $zipFile = 'laporan-lengkap-' . now()->format('Y-m-d-His') . '.zip';
        $zip = new \ZipArchive();
        
        if ($zip->open(storage_path("app/public/{$zipFile}"), \ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $zip->addFile(storage_path("app/public/{$file}"), basename($file));
            }
            $zip->close();
            
            // Hapus file sementara
            foreach ($files as $file) {
                unlink(storage_path("app/public/{$file}"));
            }
            
            return response()->download(storage_path("app/public/{$zipFile}"))->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Gagal membuat file ZIP');
    }

    /**
     * Helper untuk generate PDF file
     */
    private function generatePdf($type, $startDate, $endDate)
    {
        $request = new Request(['start_date' => $startDate, 'end_date' => $endDate]);
        
        switch ($type) {
            case 'transaksi-masuk':
                $data = $this->prepareTransaksiMasukData($request);
                $pdf = Pdf::loadView('adminasettetap.laporan.exports.transaksi-masuk', $data);
                break;
            case 'transaksi-keluar':
                $data = $this->prepareTransaksiKeluarData($request);
                $pdf = Pdf::loadView('adminasettetap.laporan.exports.transaksi-keluar', $data);
                break;
            case 'peminjaman':
                $data = $this->preparePeminjamanData($request);
                $pdf = Pdf::loadView('adminasettetap.laporan.exports.peminjaman', $data);
                break;
            default:
                return null;
        }

        $filename = "laporan-{$type}-{$startDate}-to-{$endDate}.pdf";
        $filepath = storage_path("app/public/{$filename}");
        $pdf->save($filepath);
        return $filename;
    }

    // Helper methods untuk prepare data
    private function prepareTransaksiMasukData($request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        
        return [
            'title' => 'Laporan Transaksi Masuk Aset Tetap',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'transaksi' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->get(),
            'total' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
        ];
    }

    /**
     * 🔄 DOWNLOAD LAPORAN PENGEMBALIAN (Barang & Kendaraan)
     */
    public function downloadPengembalian(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Pengembalian Aset & Kendaraan',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'pengembalian_barang' => PengembalianBarang::with(['peminjamanBarang', 'user'])
                ->whereBetween('tanggal_pengembalian_aktual', [$startDate, $endDate])->get(),
            'pengembalian_kendaraan' => PengembalianKendaraan::with(['peminjamanKendaraan', 'user'])
                ->whereBetween('tanggal_pengembalian_aktual', [$startDate, $endDate])->get(),
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data, 'pengembalian'), 'laporan-pengembalian-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.pengembalian', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Pengembalian-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 🔄 DOWNLOAD LAPORAN MUTASI BARANG
     */
    public function downloadMutasi(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Mutasi Barang Aset Tetap',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'mutasi' => \App\Models\MutasiBarang::with('barang')
                ->whereBetween('tanggal_mutasi', [$startDate, $endDate])
                ->orderBy('tanggal_mutasi', 'desc')
                ->get(),
            'total' => \App\Models\MutasiBarang::whereBetween('tanggal_mutasi', [$startDate, $endDate])->count(),
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data, 'mutasi'), 'laporan-mutasi-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.mutasi', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Mutasi-' . now()->format('Y-m-d') . '.pdf');
    }

    private function prepareTransaksiKeluarData($request) { return []; }
    private function preparePeminjamanData($request) { return []; }
}