<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class TamuController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard tamu
        return view('tamu.dashbord');
    }

    public function peminjamanGedung()
    {
        // Logika untuk peminjaman gedung
        return view('tamu.peminjaman_gedung');
    }

    public function pengaturanAkun()
    {
        // Logika untuk pengaturan akun
        return view('tamu.pengaturan_akun');
    }

    /**
     * Info Fasilitas – data diambil dari tabel gedung (relasi dengan CRUD admin sarpras)
     */
    public function infoFasilitas(Request $request)
    {
        $query = Gedung::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_gedung', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('fasilitas', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $gedungs = $query->latest()->get();

        // Statistik untuk hero section
        $totalGedung = Gedung::count();
        $tersedia    = Gedung::where('ketersediaan', 'Tersedia')->count();

        return view('tamu.info_fasilitas', compact('gedungs', 'totalGedung', 'tersedia'));
    }

    public function pengembalianGedung()
    {
        // Logika untuk pengembalian gedung
        return view('tamu.pengembalian_gedung');
    }
}
