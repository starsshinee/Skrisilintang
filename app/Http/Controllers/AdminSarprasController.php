<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSarprasController extends Controller
{
    public function dataGedung()
    {
        // Logika untuk menampilkan data gedung
        return view('adminsarpras.data_gedung');
    }

    public function daftarPeminjaman()
    {
        // Logika untuk menampilkan daftar peminjaman
        return view('adminsarpras.daftar_peminjaman');
    }

    public function laporanPeminjamanGedung()
    {
        // Logika untuk menampilkan laporan peminjaman gedung
        return view('adminsarpras.laporan_peminjaman_gedung');
    }

    public function pengaturanAkun()
    {
        // Logika untuk menampilkan pengaturan akun
        return view('adminsarpras.pengaturan_akun');
    }
}
