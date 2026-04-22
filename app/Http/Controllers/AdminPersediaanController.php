<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPersediaanController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard admin persediaan
        return view('adminpersediaan.dashbord');
    }

    public function dataPersediaan()
    {
        // Logika untuk menampilkan data persediaan
        return view('adminpersediaan.data_persediaan');
    }

    public function TransaksiMasuk()
    {
        // Logika untuk menampilkan transaksi masuk persediaan
        return view('adminpersediaan.transaksi_masuk');
    }

    public function TransaksiKeluar()
    {
        // Logika untuk menampilkan transaksi keluar persediaan
        return view('adminpersediaan.transaksi_keluar');
    }

    public function PermintaanPersediaan()
    {
        // Logika untuk menampilkan permintaan persediaan
        return view('adminpersediaan.permintaan_persediaan');
    }

    public function laporanPermintaanPersediaan()
    {
        // Logika untuk menampilkan laporan permintaan persediaan
        return view('adminpersediaan.laporan_permintaan_persediaan');
    }

    public function laporanTransaksiMasuk()
    {
        return view('adminpersediaan.laporan_transaksi_masuk');
    }

    public function laporanTransaksiKeluar()
    {
        return view('adminpersediaan.laporan_transaksi_keluar');
    }
}
