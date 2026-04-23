<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanGedung;
use App\Models\PengembalianGedung;
use App\Models\AdminSarpras;

class AdminSarprasController extends Controller
{
    public function dashboard()
    {
        return view('adminsarpras.dashbord');
        // // Statistics untuk dashboard
        // $stats = [
        //     'total_peminjaman' => PeminjamanGedung::count(),
        //     'peminjaman_aktif' => PeminjamanGedung::whereIn('status', ['dipinjam', 'terlambat'])->count(),
        //     'pengembalian_menunggu' => PengembalianGedung::where('status_verifikasi', 'menunggu')->count(),
        //     'pengembalian_selesai' => PengembalianGedung::where('status_verifikasi', 'disetujui')->count(),
        //     'total_denda' => PengembalianGedung::sum('denda_akhir'),
        // ];

        // $peminjaman_terbaru = PeminjamanGedung::with('pengembalian')
        //     ->whereIn('status', ['dipinjam', 'terlambat'])
        //     ->latest()
        //     ->limit(5)
        //     ->get();

        // $pengembalianGedung_menunggu = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
        //     ->where('status_verifikasi', 'menunggu')
        //     ->latest()
        //     ->limit(5)
        //     ->get();

        // return view('adminsarpras.dashboard', compact('stats', 'peminjaman_terbaru', 'pengembalian_menunggu'));
    }

    public function dataGedung()
    {
        // Data master gedung yang bisa dipinjam
        $gedung = []; // Bisa dari model Gedung jika ada
        return view('adminsarpras.data_gedung', compact('gedung'));
    }

    public function daftarPeminjaman(Request $request)
    {
        $query = PeminjamanGedung::with('pengembalian');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter terlambat
        if ($request->boolean('terlambat')) {
            $query->where('status', 'terlambat');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%'.$request->search.'%')
                  ->orWhere('nama_gedung', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi', 'like', '%'.$request->search.'%');
            });
        }

        $peminjaman = $query->paginate(15);

        return view('adminsarpras.daftar_peminjaman', compact('peminjaman'));
    }

    public function laporanPeminjamanGedung(Request $request)
    {
        $query = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
            ->orderBy('waktu_verifikasi', 'desc');

        // Filter bulan/tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('tanggal_pengembalian', $request->tahun)
                  ->whereMonth('tanggal_pengembalian', $request->bulan);
        }

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        $laporan = $query->paginate(20);

        $stats = [
            'total' => PengembalianGedung::count(),
            'baik' => PengembalianGedung::where('kondisi_gedung', 'baik')->count(),
            'ringan' => PengembalianGedung::where('kondisi_gedung', 'ringan')->count(),
            'rusak' => PengembalianGedung::where('kondisi_gedung', 'rusak')->count(),
            'total_denda' => PengembalianGedung::sum('denda_akhir')
        ];

        return view('adminsarpras.laporan_peminjaman_gedung', compact('laporan', 'stats'));
    }

    public function daftarPengembalian(Request $request)
    {
        $query = PengembalianGedung::with(['peminjaman', 'adminSarpras'])
            ->orderBy('created_at', 'desc');

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        // Filter kondisi gedung
        if ($request->filled('kondisi_gedung')) {
            $query->where('kondisi_gedung', $request->kondisi_gedung);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('peminjaman', function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%'.$request->search.'%')
                  ->orWhere('nama_gedung', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi', 'like', '%'.$request->search.'%');
            });
        }

        $pengembalianGedung = $query->paginate(10);

        return view('adminsarpras.daftar_pengembalian', compact('pengembalianGedung'));
    }

    public function pengaturanAkun()
    {
        $admin = auth('admin_sarpras')->user(); // Sesuaikan dengan guard auth
        return view('adminsarpras.pengaturan_akun', compact('admin'));
    }

    // Method tambahan untuk verifikasi
    public function verifikasiPengembalian(Request $request, PengembalianGedung $pengembalianGedung)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000',
            'denda_akhir' => 'nullable|numeric|min:0'
        ]);

        $admin = auth('admin_sarpras')->user();

        $pengembalianGedung->verifikasiOlehAdmin(
            $admin,
            $request->status_verifikasi,
            $request->catatan_verifikasi,
            $request->denda_akhir ?? 0
        );

        return redirect()->back()->with('success', 'Pengembalian berhasil diverifikasi!');
    }

    // Method untuk detail pengembalian
    public function showPengembalian(PengembalianGedung $pengembalianGedung)
    {
        $pengembalianGedung->load(['peminjaman', 'adminSarpras']);
        return view('adminsarpras.pengembalian_detail', compact('pengembalianGedung'));
    }

    // Method untuk cetak laporan
    public function cetakLaporan(PengembalianGedung $pengembalianGedung)
    {
        $pengembalianGedung->load(['peminjaman', 'adminSarpras']);
        // Logic cetak PDF atau print view
        return view('adminsarpras.cetak_laporan', compact('pengembalianGedung'));
    }

    // API untuk foto modal
    public function getPhotos(PengembalianGedung $pengembalianGedung)
    {
        return response()->json($pengembalianGedung->foto_kondisi ?? []);
    }
}