<?php
// app/Http/Controllers/AdminAsettetap/LaporanController.php

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
use App\Models\Pengaduan;
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
     * 📊 Get Dashboard Statistics - UPDATED dengan Survey & Pengaduan
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
            'peminjaman_barang_aktif' => PeminjamanBarang::where('status', '!=', 'dikembalikan')->count(),
            'peminjaman_kendaraan_aktif' => PeminjamanKendaraan::where('status', '!=', 'dikembalikan')->count(),
            
            // 📞 PENGADUAN - UPDATED sesuai migration
            'pengaduan_baru' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])
                                        ->where('status', 'baru')
                                        ->count(),
            'pengaduan_diproses' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])
                                            ->where('status', 'diproses')
                                            ->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            'total_pengaduan' => Pengaduan::count(),
            
            // 📊 SURVEY KEPUASAN - UPDATED sesuai migration
            'total_survey' => SurveyKepuasan::count(),
            'survey_bulan_ini' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'survey_rata_rata' => $this->calculateSurveyAverage(),
            'survey_puas' => SurveyKepuasan::whereIn('kepuasan', ['sangat_puas', 'puas'])->count(),
            
            // 📊 TREND
            'growth_asset' => $this->calculateGrowth(AssetTetap::class, 'created_at'),
            'growth_pengaduan' => $this->calculateGrowth(Pengaduan::class, 'created_at'),
        ];
    }

    /**
     * 📈 Get Charts Data - UPDATED dengan Survey & Pengaduan
     */
    private function getChartsData(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->subDays(30) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        return [
            // 📊 Transaksi
            'transaksi_masuk_chart' => TransaksiMasukAssetTetap::selectRaw('DATE(tanggal_perolehan) as date, COUNT(*) as count')
                ->whereBetween('tanggal_perolehan', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
                
            'transaksi_keluar_chart' => TransaksiKeluarAssetTetap::selectRaw('DATE(tanggal_input) as date, COUNT(*) as count')
                ->whereBetween('tanggal_input', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
                
            // 📞 Pengaduan Chart - Per Status
            'pengaduan_chart' => Pengaduan::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
                
            // 📊 Survey Chart
            'survey_chart' => SurveyKepuasan::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
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
     * ⏰ Recent Activities - UPDATED dengan Survey & Pengaduan
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
                ->get(['id', 'tanggal_perolehan', 'keterangan', 'nama_barang'])
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
                ->get(['id', 'tanggal_input', 'keterangan', 'nama_barang'])
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

        // ✅ Pengaduan - UPDATED sesuai migration
        $activities = $activities->merge(
            Pengaduan::where('created_at', '>=', $startDate)
                ->latest()
                ->limit(3)
                ->get(['id', 'created_at', 'nama_lengkap', 'kategori', 'status'])
                ->map(function($item) {
                    $statusColor = [
                        'baru' => 'warning',
                        'diproses' => 'info', 
                        'selesai' => 'success',
                        'ditolak' => 'danger'
                    ];
                    
                    return [
                        'type' => 'pengaduan',
                        'title' => ucfirst($item->kategori),
                        'date' => $item->created_at,
                        'desc' => $item->nama_lengkap . ' - ' . $item->status,
                        'icon' => 'fas fa-exclamation-triangle',
                        'color' => $statusColor[$item->status] ?? 'secondary'
                    ];
                })
        );

        // ✅ Survey Kepuasan - BARU
        $activities = $activities->merge(
            SurveyKepuasan::where('created_at', '>=', $startDate)
                ->latest()
                ->limit(2)
                ->get(['id', 'created_at', 'nama', 'kepuasan'])
                ->map(function($item) {
                    $kepuasanColor = [
                        'sangat_puas' => 'success',
                        'puas' => 'info',
                        'cukup' => 'warning',
                        'kurang_puas' => 'danger',
                        'tidak_puas' => 'dark'
                    ];
                    
                    return [
                        'type' => 'survey',
                        'title' => 'Survey Kepuasan',
                        'date' => $item->created_at,
                        'desc' => $item->nama . ' - ' . ucwords(str_replace('_', ' ', $item->kepuasan)),
                        'icon' => 'fas fa-star',
                        'color' => $kepuasanColor[$item->kepuasan] ?? 'secondary'
                    ];
                })
        );

        return $activities
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }

    /**
     * 📋 Summary Data - UPDATED lengkap
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
            
            // 📞 Pengaduan per Kategori
            'pengaduan_kategori' => Pengaduan::selectRaw('kategori, COUNT(*) as count')
                ->groupBy('kategori')
                ->orderByDesc('count')
                ->get(),
                
            'pengaduan_status' => Pengaduan::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            
            // 📊 Survey Kepuasan Distribution
            'survey_distribution' => SurveyKepuasan::selectRaw('kepuasan, COUNT(*) as count')
                ->groupBy('kepuasan')
                ->orderBy('kepuasan')
                ->get(),
                
            'status_peminjaman' => [
                'peminjaman_barang' => PeminjamanBarang::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status'),
                'peminjaman_kendaraan' => PeminjamanKendaraan::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status'),
            ],
        ];
    }

    /**
     * 📊 Calculate Survey Average Score
     */
    private function calculateSurveyAverage()
    {
        $scores = [
            'sangat_puas' => 5,
            'puas' => 4,
            'cukup' => 3,
            'kurang_puas' => 2,
            'tidak_puas' => 1
        ];

        $totalSurvey = SurveyKepuasan::count();
        if ($totalSurvey === 0) return 0;

        $totalScore = SurveyKepuasan::selectRaw('SUM(CASE 
            WHEN kepuasan="sangat_puas" THEN 5 
            WHEN kepuasan="puas" THEN 4 
            WHEN kepuasan="cukup" THEN 3 
            WHEN kepuasan="kurang_puas" THEN 2 
            WHEN kepuasan="tidak_puas" THEN 1 
            END) as total_score')
            ->value('total_score') ?? 0;

        return round($totalScore / $totalSurvey, 1);
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
     * 📊 Get Survey Analytics
     */
    public function surveyAnalytics(Request $request)
    {
        return response()->json([
            'distribution' => SurveyKepuasan::selectRaw('kepuasan, COUNT(*) as count')
                ->groupBy('kepuasan')
                ->pluck('count', 'kepuasan'),
            'average' => $this->calculateSurveyAverage(),
            'total' => SurveyKepuasan::count(),
        ]);
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
            'pengaduan' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])->get(),
            'survey' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])->get(),
        ];

        // TODO: Implement Excel/PDF export
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

    /**
     * 📞 DOWNLOAD LAPORAN PENGADUAN (Excel & PDF)
     */
    public function downloadPengaduan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Pengaduan',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'pengaduan' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->get(),
            'stats' => [
                'total' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])->count(),
                'kategori' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('kategori, COUNT(*) as count')
                    ->groupBy('kategori')
                    ->get(),
                'status' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status')
            ],
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data), 'laporan-pengaduan-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.pengaduan', $data);
        return $pdf->download('Laporan-Pengaduan-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📊 DOWNLOAD LAPORAN SURVEY KEPUASAN (Excel & PDF)
     */
    public function downloadSurvey(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Survey Kepuasan',
            'periode' => "{$startDate->format('d/m/Y')} s/d {$endDate->format('d/m/Y')}",
            'survey' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->get(),
            'stats' => [
                'total' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])->count(),
                'average' => $this->calculateSurveyAverage(),
                'distribution' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('kepuasan, COUNT(*) as count')
                    ->groupBy('kepuasan')
                    ->get()
            ],
            'generated_at' => now()
        ];

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($data), 'laporan-survey-kepuasan-' . now()->format('Y-m-d') . '.xlsx');
        }

        $pdf = Pdf::loadView('adminasettetap.laporan.exports.survey', $data);
        return $pdf->download('Laporan-Survey-Kepuasan-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📋 DOWNLOAD LAPORAN PEMINJAMAN (Excel & PDF)
     */
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
            $this->generatePdf('pengaduan', $startDate, $endDate),
            $this->generatePdf('survey', $startDate, $endDate),
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
            case 'pengaduan':
                $data = $this->preparePengaduanData($request);
                $pdf = Pdf::loadView('adminasettetap.laporan.exports.pengaduan', $data);
                break;
            case 'survey':
                $data = $this->prepareSurveyData($request);
                $pdf = Pdf::loadView('adminasettetap.laporan.exports.survey', $data);
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

    // Helper methods untuk prepare data (implementasi sederhana)
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
    private function prepareTransaksiKeluarData($request) { /* ... */ return []; }
    private function preparePengaduanData($request) { /* ... */ return []; }
    private function prepareSurveyData($request) { /* ... */ return []; }
    private function preparePeminjamanData($request) { /* ... */ return []; }
}