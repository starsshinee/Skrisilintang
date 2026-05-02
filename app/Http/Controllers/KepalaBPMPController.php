<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

// Models - Admin Persediaan
use App\Models\Persediaan;
use App\Models\TransaksiMasukPersediaan;
use App\Models\TransaksiKeluarPersediaan;
use App\Models\PermintaanPersediaan;

// Models - Admin Aset Tetap
use App\Models\AssetTetap;
use App\Models\TransaksiMasukAssetTetap;
use App\Models\TransaksiKeluarAssetTetap;
use App\Models\MutasiBarang;
use App\Models\PeminjamanBarang;
use App\Models\PengembalianBarang;
use App\Models\PeminjamanKendaraan;
use App\Models\PengembalianKendaraan;

// Models - Admin Sarpras
use App\Models\Gedung;
use App\Models\Kerusakan;
use App\Models\PeminjamanGedung;

// Models - Umum
use App\Models\Pengaduan;
use App\Models\SurveyKepuasan;
use App\Models\User;

class KepalaBPMPController extends Controller
{
    public function dashboard()
    {
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // 📊 STATISTIK UTAMA
        $totalAset = AssetTetap::count() + Persediaan::count();
        $totalPengguna = User::count();
        $totalGedung = Gedung::count();

        // Permintaan & Peminjaman menunggu approval
        $permintaanPending = PermintaanPersediaan::whereIn('status', ['pending', 'dalam_review'])->count();
        $peminjamanBarangPending = PeminjamanBarang::whereIn('status', ['pending', 'dalam_review'])->count();
        $peminjamanKendaraanPending = PeminjamanKendaraan::whereIn('status', ['pending', 'dalam_review'])->count();
        $peminjamanGedungPending = PeminjamanGedung::whereIn('status', ['pending', 'dalam_review'])->count();
        $menungguApproval = $permintaanPending + $peminjamanBarangPending + $peminjamanKendaraanPending + $peminjamanGedungPending;

        // Permintaan bulan ini
        $permintaanBulanIni = PermintaanPersediaan::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count()
            + PeminjamanBarang::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count()
            + PeminjamanKendaraan::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count()
            + PeminjamanGedung::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count();

        // Pengaduan & Survey
        $totalPengaduan = Pengaduan::count();
        $pengaduanBaru = Pengaduan::where('status', 'baru')->count();
        $totalSurvey = SurveyKepuasan::count();
        $surveyRataRata = $this->calculateSurveyAverage();

        // 📈 CHART DATA - Tren Permintaan 6 bulan terakhir
        $chartLabels = [];
        $chartPermintaan = [];
        $chartPeminjaman = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chartLabels[] = $d->translatedFormat('M');
            $chartPermintaan[] = PermintaanPersediaan::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count();
            $chartPeminjaman[] = PeminjamanBarang::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count()
                + PeminjamanKendaraan::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count()
                + PeminjamanGedung::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count();
        }

        // 🍩 DISTRIBUSI ASET
        $distribusiAset = [
            'Persediaan' => Persediaan::count(),
            'Aset Tetap' => AssetTetap::count(),
            'Gedung' => Gedung::count(),
            'Kendaraan' => AssetTetap::where('kategori', 'like', '%kendaraan%')->count(),
        ];

        // ⏰ AKTIVITAS TERBARU
        $activities = collect();

        $activities = $activities->merge(
            PeminjamanGedung::latest()->limit(2)->get()->map(fn($i) => [
                'text' => 'Peminjaman gedung oleh ' . $i->nama_lengkap,
                'time' => $i->created_at,
                'icon' => 'fas fa-building',
                'color' => '#22c55e',
            ])
        );
        $activities = $activities->merge(
            PermintaanPersediaan::with('user')->latest()->limit(2)->get()->map(fn($i) => [
                'text' => 'Permintaan persediaan: ' . ($i->nama_barang ?? 'Barang'),
                'time' => $i->created_at,
                'icon' => 'fas fa-boxes',
                'color' => '#2563eb',
            ])
        );
        $activities = $activities->merge(
            Pengaduan::latest()->limit(2)->get()->map(fn($i) => [
                'text' => 'Pengaduan baru dari ' . $i->nama_lengkap,
                'time' => $i->created_at,
                'icon' => 'fas fa-exclamation-triangle',
                'color' => '#f59e0b',
            ])
        );
        $recentActivities = $activities->sortByDesc('time')->take(5)->values();

        return view('kepalabpmp.dashbord', compact(
            'totalAset', 'totalPengguna', 'totalGedung', 'permintaanBulanIni', 'menungguApproval',
            'totalPengaduan', 'pengaduanBaru', 'totalSurvey', 'surveyRataRata',
            'chartLabels', 'chartPermintaan', 'chartPeminjaman', 'distribusiAset',
            'recentActivities'
        ));
    }

    /**
     * 📊 HALAMAN UTAMA LAPORAN - Menampilkan ringkasan semua data
     */
    public function laporan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // ══════════════════════════════════════════════════
        // 📦 DATA ADMIN PERSEDIAAN
        // ══════════════════════════════════════════════════
        $persediaan = [
            'total_item' => Persediaan::count(),
            'total_nilai' => Persediaan::sum(\DB::raw('CAST(harga_total AS DECIMAL(20,2))')),
            'transaksi_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
            'transaksi_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
            'nilai_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
            'nilai_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
            'permintaan_total' => PermintaanPersediaan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'permintaan_pending' => PermintaanPersediaan::whereIn('status', ['pending', 'dalam_review'])->count(),
            'permintaan_disetujui' => PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
            'permintaan_ditolak' => PermintaanPersediaan::whereIn('status', ['ditolak', 'ditolak_kasubag'])->count(),
            'recent_masuk' => TransaksiMasukPersediaan::latest('tanggal_input')->limit(5)->get(),
            'recent_keluar' => TransaksiKeluarPersediaan::latest('tanggal_input')->limit(5)->get(),
        ];

        // ══════════════════════════════════════════════════
        // 🏢 DATA ADMIN ASET TETAP
        // ══════════════════════════════════════════════════
        $asetTetap = [
            'total_aset' => AssetTetap::count(),
            'total_nilai' => AssetTetap::sum('nilai_perolehan'),
            'transaksi_masuk' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
            'transaksi_keluar' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
            'mutasi' => MutasiBarang::whereBetween('tanggal_mutasi', [$startDate, $endDate])->count(),
            'peminjaman_barang_aktif' => PeminjamanBarang::where('status', '!=', 'dikembalikan')->count(),
            'peminjaman_kendaraan_aktif' => PeminjamanKendaraan::where('status', '!=', 'dikembalikan')->count(),
            'pengembalian_barang' => PengembalianBarang::whereBetween('created_at', [$startDate, $endDate])->count(),
            'pengembalian_kendaraan' => PengembalianKendaraan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'kondisi_aset' => AssetTetap::selectRaw('kondisi, COUNT(*) as count')->groupBy('kondisi')->pluck('count', 'kondisi'),
            'recent_masuk' => TransaksiMasukAssetTetap::latest('tanggal_perolehan')->limit(5)->get(),
            'recent_keluar' => TransaksiKeluarAssetTetap::latest('tanggal_input')->limit(5)->get(),
        ];

        // ══════════════════════════════════════════════════
        // 🏗️ DATA ADMIN SARPRAS
        // ══════════════════════════════════════════════════
        $sarpras = [
            'total_gedung' => Gedung::count(),
            'gedung_tersedia' => Gedung::where('ketersediaan', 'Tersedia')->count(),
            'gedung_dipakai' => Gedung::where('ketersediaan', 'Sedang Dipakai')->count(),
            'gedung_renovasi' => Gedung::where('ketersediaan', 'Renovasi')->count(),
            'total_kerusakan' => Kerusakan::count(),
            'kerusakan_periode' => Kerusakan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'peminjaman_gedung' => PeminjamanGedung::whereBetween('created_at', [$startDate, $endDate])->count(),
            'peminjaman_gedung_pending' => PeminjamanGedung::whereIn('status', ['pending', 'dalam_review'])->count(),
            'peminjaman_gedung_disetujui' => PeminjamanGedung::whereIn('status', ['di setujui', 'disetujui_kasubag'])->count(),
            'kerusakan_kondisi' => Kerusakan::selectRaw('kondisi, COUNT(*) as count')->groupBy('kondisi')->pluck('count', 'kondisi'),
            'recent_peminjaman' => PeminjamanGedung::with('gedung')->latest()->limit(5)->get(),
            'recent_kerusakan' => Kerusakan::latest()->limit(5)->get(),
        ];

        // ══════════════════════════════════════════════════
        // 📞 DATA PENGADUAN & SURVEY
        // ══════════════════════════════════════════════════
        $pengaduan = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'periode' => Pengaduan::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        $survey = [
            'total' => SurveyKepuasan::count(),
            'periode' => SurveyKepuasan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'rata_rata' => $this->calculateSurveyAverage(),
            'distribusi' => SurveyKepuasan::selectRaw('kepuasan, COUNT(*) as count')
                ->groupBy('kepuasan')->pluck('count', 'kepuasan'),
        ];

        // ══════════════════════════════════════════════════
        // 📈 DATA CHART - Tren Bulanan (12 bulan terakhir)
        // ══════════════════════════════════════════════════
        $chartLabels = [];
        $chartPersediaanMasuk = [];
        $chartPersediaanKeluar = [];
        $chartAsetMasuk = [];
        $chartAsetKeluar = [];
        $chartPeminjamanGedung = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');

            $chartPersediaanMasuk[] = TransaksiMasukPersediaan::whereMonth('tanggal_input', $date->month)
                ->whereYear('tanggal_input', $date->year)->count();
            $chartPersediaanKeluar[] = TransaksiKeluarPersediaan::whereMonth('tanggal_input', $date->month)
                ->whereYear('tanggal_input', $date->year)->count();
            $chartAsetMasuk[] = TransaksiMasukAssetTetap::whereMonth('tanggal_perolehan', $date->month)
                ->whereYear('tanggal_perolehan', $date->year)->count();
            $chartAsetKeluar[] = TransaksiKeluarAssetTetap::whereMonth('tanggal_input', $date->month)
                ->whereYear('tanggal_input', $date->year)->count();
            $chartPeminjamanGedung[] = PeminjamanGedung::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)->count();
        }

        $charts = [
            'labels' => $chartLabels,
            'persediaan_masuk' => $chartPersediaanMasuk,
            'persediaan_keluar' => $chartPersediaanKeluar,
            'aset_masuk' => $chartAsetMasuk,
            'aset_keluar' => $chartAsetKeluar,
            'peminjaman_gedung' => $chartPeminjamanGedung,
        ];

        return view('kepalabpmp.laporan', compact(
            'persediaan', 'asetTetap', 'sarpras', 'pengaduan', 'survey', 'charts',
            'startDate', 'endDate'
        ));
    }

    /**
     * 📥 DOWNLOAD LAPORAN PERSEDIAAN (PDF)
     */
    public function downloadLaporanPersediaan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Data Persediaan',
            'periode' => $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y'),
            'generated_at' => now(),
            'generated_by' => auth()->user()->name,
            'persediaan' => Persediaan::orderBy('kategori')->get(),
            'transaksi_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])
                ->orderBy('tanggal_input', 'desc')->get(),
            'transaksi_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])
                ->orderBy('tanggal_input', 'desc')->get(),
            'permintaan' => PermintaanPersediaan::with(['user', 'persediaan'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')->get(),
            'stats' => [
                'total_item' => Persediaan::count(),
                'total_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'total_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'nilai_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
                'nilai_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
            ],
        ];

        $pdf = Pdf::loadView('kepalabpmp.exports.laporan_persediaan', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Persediaan-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📥 DOWNLOAD LAPORAN ASET TETAP (PDF)
     */
    public function downloadLaporanAsetTetap(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Data Aset Tetap',
            'periode' => $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y'),
            'generated_at' => now(),
            'generated_by' => auth()->user()->name,
            'aset' => AssetTetap::orderBy('kategori')->get(),
            'transaksi_masuk' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])
                ->orderBy('tanggal_perolehan', 'desc')->get(),
            'transaksi_keluar' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])
                ->orderBy('tanggal_input', 'desc')->get(),
            'mutasi' => MutasiBarang::with('barang')->whereBetween('tanggal_mutasi', [$startDate, $endDate])
                ->orderBy('tanggal_mutasi', 'desc')->get(),
            'peminjaman_barang' => PeminjamanBarang::whereBetween('created_at', [$startDate, $endDate])->get(),
            'peminjaman_kendaraan' => PeminjamanKendaraan::whereBetween('tanggal_peminjaman', [$startDate, $endDate])->get(),
            'stats' => [
                'total_aset' => AssetTetap::count(),
                'total_nilai' => AssetTetap::sum('nilai_perolehan'),
                'total_masuk' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
                'total_keluar' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'total_mutasi' => MutasiBarang::whereBetween('tanggal_mutasi', [$startDate, $endDate])->count(),
            ],
        ];

        $pdf = Pdf::loadView('kepalabpmp.exports.laporan_asettetap', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Aset-Tetap-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📥 DOWNLOAD LAPORAN SARPRAS (PDF)
     */
    public function downloadLaporanSarpras(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Sarana & Prasarana',
            'periode' => $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y'),
            'generated_at' => now(),
            'generated_by' => auth()->user()->name,
            'gedung' => Gedung::all(),
            'kerusakan' => Kerusakan::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')->get(),
            'peminjaman_gedung' => PeminjamanGedung::with(['gedung', 'user'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')->get(),
            'stats' => [
                'total_gedung' => Gedung::count(),
                'gedung_tersedia' => Gedung::where('ketersediaan', 'Tersedia')->count(),
                'total_kerusakan' => Kerusakan::whereBetween('created_at', [$startDate, $endDate])->count(),
                'total_peminjaman_gedung' => PeminjamanGedung::whereBetween('created_at', [$startDate, $endDate])->count(),
            ],
        ];

        $pdf = Pdf::loadView('kepalabpmp.exports.laporan_sarpras', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Sarpras-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * 📥 DOWNLOAD LAPORAN LENGKAP SEMUA DATA (PDF)
     */
    public function downloadLaporanLengkap(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $data = [
            'title' => 'Laporan Lengkap SIPANDU',
            'subtitle' => 'BPMP Provinsi Gorontalo',
            'periode' => $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y'),
            'generated_at' => now(),
            'generated_by' => auth()->user()->name,
            
            // Persediaan
            'persediaan_stats' => [
                'total_item' => Persediaan::count(),
                'transaksi_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'transaksi_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'nilai_masuk' => TransaksiMasukPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
                'nilai_keluar' => TransaksiKeluarPersediaan::whereBetween('tanggal_input', [$startDate, $endDate])->sum('total'),
                'permintaan' => PermintaanPersediaan::whereBetween('created_at', [$startDate, $endDate])->count(),
            ],

            // Aset Tetap
            'aset_stats' => [
                'total_aset' => AssetTetap::count(),
                'total_nilai' => AssetTetap::sum('nilai_perolehan'),
                'transaksi_masuk' => TransaksiMasukAssetTetap::whereBetween('tanggal_perolehan', [$startDate, $endDate])->count(),
                'transaksi_keluar' => TransaksiKeluarAssetTetap::whereBetween('tanggal_input', [$startDate, $endDate])->count(),
                'mutasi' => MutasiBarang::whereBetween('tanggal_mutasi', [$startDate, $endDate])->count(),
                'peminjaman_aktif' => PeminjamanBarang::where('status', '!=', 'dikembalikan')->count() 
                    + PeminjamanKendaraan::where('status', '!=', 'dikembalikan')->count(),
            ],

            // Sarpras
            'sarpras_stats' => [
                'total_gedung' => Gedung::count(),
                'gedung_tersedia' => Gedung::where('ketersediaan', 'Tersedia')->count(),
                'kerusakan' => Kerusakan::whereBetween('created_at', [$startDate, $endDate])->count(),
                'peminjaman_gedung' => PeminjamanGedung::whereBetween('created_at', [$startDate, $endDate])->count(),
            ],

            // Pengaduan & Survey
            'pengaduan_stats' => [
                'total' => Pengaduan::count(),
                'baru' => Pengaduan::where('status', 'baru')->count(),
                'diproses' => Pengaduan::where('status', 'diproses')->count(),
                'selesai' => Pengaduan::where('status', 'selesai')->count(),
            ],
            'survey_stats' => [
                'total' => SurveyKepuasan::count(),
                'rata_rata' => $this->calculateSurveyAverage(),
            ],

            // Data Detail
            'persediaan_list' => Persediaan::orderBy('kategori')->limit(50)->get(),
            'aset_list' => AssetTetap::orderBy('kategori')->limit(50)->get(),
            'gedung_list' => Gedung::all(),
        ];

        $pdf = Pdf::loadView('kepalabpmp.exports.laporan_lengkap', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Laporan-Lengkap-SIPANDU-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Helper: Hitung rata-rata survey kepuasan
     */
    private function calculateSurveyAverage()
    {
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

    public function kelolaPengguna()
    {
        // Logika untuk kelola pengguna
        return view('kepalabpmp.kelola_pengguna');
    }

    public function pengaturanSistem()
    {
        // Logika untuk pengaturan sistem
        return view('kepalabpmp.pengaturan_sistem');
    }

    public function analitikDetail()
    {
        // Logika untuk analitik detail
        return view('kepalabpmp.analitik_detail');
    }
}
