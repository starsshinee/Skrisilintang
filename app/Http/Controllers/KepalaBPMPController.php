<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepalaBPMPController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard Kepala BPMP
        return view('kepalabpmp.dashbord');
    }

    public function laporan()
    {
        // Logika untuk laporan Kepala BPMP
        return view('kepalabpmp.laporan');
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
