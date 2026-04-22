<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAsettetapController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard admin aset tetap
        return view('adminasettetap.dashbord');
    }

    public function dataAsetTetap()
    {
        // Logika untuk menampilkan data aset tetap
        return view('adminasettetap.data_aset_tetap');
    }

    public function TransaksiMasuk()
    {
        // Logika untuk menampilkan transaksi masuk aset tetap
        return view('adminasettetap.transaksi_masuk');
    }
    
    public function TransaksiKeluar()
    {
        // Logika untuk menampilkan transaksi keluar aset tetap
        return view('adminasettetap.transaksi_keluar');
    }
    
    public function mutasiAsetTetap()
    {
        // Logika untuk menampilkan mutasi aset tetap
        return view('adminasettetap.mutasi_barang');
    }
    
    public function PeminjamanBarang()
    {
        // Logika untuk menampilkan peminjaman barang
        return view('adminasettetap.peminjaman_barang');
    }

    public function PengembalianBarang()
    {
        // Logika untuk menampilkan pengembalian barang
        return view('adminasettetap.pengembalian_barang');
    }

    public function PeminjamanKendaraan()
    {
        // Logika untuk menampilkan peminjaman kendaraan
        return view('adminasettetap.peminjaman_kendaraan');
    }

    public function PengembalianKendaraan()
    {
        // Logika untuk menampilkan pengembalian kendaraan
        return view('adminasettetap.pengembalian_kendaraan');
    }

    public function laporanPeminjamanBarang()
    {
        // Logika untuk menampilkan laporan peminjaman barang
        return view('adminasettetap.laporan_peminjaman_barang');
    }    

    public function laporanTransaksiMasuk()
    {
        // Logika untuk menampilkan laporan transaksi masuk
        return view('adminasettetap.laporan_transaksi_masuk');
    }

    public function laporanTransaksiKeluar()
    {
        // Logika untuk menampilkan laporan transaksi keluar
        return view('adminasettetap.laporan_transaksi_keluar');
    }

    public function laporanMutasiAsetTetap()
    {
        // Logika untuk menampilkan laporan mutasi aset tetap
        return view('adminasettetap.laporan_mutasi_barang');
    }
}
