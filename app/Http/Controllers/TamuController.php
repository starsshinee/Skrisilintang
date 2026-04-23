<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function infoFasilitas()
    {
        // Logika untuk info fasilitas
        return view('tamu.info_fasilitas');
    }

    public function pengembalianGedung()
    {
        // Logika untuk pengembalian gedung
        return view('tamu.pengembalian_gedung');
    }
}
