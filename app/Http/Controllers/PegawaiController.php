<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard pegawai
        return view('pegawai.dashbord');
    }

    public function peminjamanBarang()
    {
        // Logika untuk peminjaman barang
        return view('pegawai.peminjaman_barang');
    }
    
    public function pengembalianBarang()
    {
        // Logika untuk pengembalian barang
        return view('pegawai.pengembalian_barang');
    }

    public function permintaanPersediaan()
    {
        // Logika untuk permintaan persediaan
        return view('pegawai.permintaan_persediaan');
    }

    public function riwayatPermintaan()
    {
        // Logika untuk riwayat permintaan
        return view('pegawai.riwayat_permintaan');
    }

    public function peminjamanKendaraan()
    {
        // Logika untuk peminjaman kendaraan
        return view('pegawai.peminjaman_kendaraan');
    }

    public function pengembalianKendaraan()
    {
        // Logika untuk pengembalian kendaraan
        return view('pegawai.pengembalian_kendaraan');
    }

    public function pengaturanAkun()
    {
        // Logika untuk pengaturan akun
        return view('pegawai.pengaturan_akun');
    }
}
