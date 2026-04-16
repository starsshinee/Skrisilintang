<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasubagController extends Controller
{
    public function dashboard()
    {
        // Logika untuk menampilkan dashboard kasubag
        return view('kasubag.dashbord');
    }

    public function persetujuanPeminjamanGedung()
    {
        // Logika untuk menampilkan halaman persetujuan peminjaman gedung
        return view('kasubag.persetujuan_peminjaman_gedung');
    }

    public function persetujuanPeminjamanBarang()
    {
        // Logika untuk menampilkan halaman persetujuan peminjaman barang
        return view('kasubag.persetujuan_peminjaman_barang');
    }

    public function persetujuanPeminjamanKendaraan()
    {
        // Logika untuk menampilkan halaman persetujuan peminjaman kendaraan
        return view('kasubag.persetujuan_peminjaman_kendaraan');
    }

    public function persetujuanPermintaanPersediaan()
    {
        // Logika untuk menampilkan halaman persetujuan permintaan persediaan
        return view('kasubag.persetujuan_permintaan_persediaan');
    }

    public function pengaturanAkun()
    {
        // Logika untuk menampilkan pengaturan akun
        return view('kasubag.pengaturan_akun');
    }
}