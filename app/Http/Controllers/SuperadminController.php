<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function dashboard()
    {
        // Logika untuk dashboard superadmin
        return view('superadmin.dashbord');
    }

    public function kelolaPengguna()
    {
        // Logika untuk kelola pengguna
        return view('superadmin.kelola_pengguna');
    }

    public function laporanSistem()
    {
        // Logika untuk laporan sistem
        return view('superadmin.laporan_sistem');
    }

    public function pengaturanSistem()
    {
        // Logika untuk pengaturan sistem
        return view('superadmin.pengaturan_sistem');
    }

    public function manajemenRole()
    {
        // Logika untuk manajemen role dan permission
        return view('superadmin.manajemen_role');
    }

    public function logAktivitas()
    {
        // Logika untuk log aktivitas
        return view('superadmin.log_aktivitas');
    }
}
