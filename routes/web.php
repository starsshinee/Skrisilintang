<?php

use App\Http\Controllers\AdminSarprasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TamuController;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

// ──────────────────────────────────────────────────────────────────────
// Halaman Publik
// ──────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ──────────────────────────────────────────────────────────────────────
// Autentikasi – hanya untuk tamu (belum login)
// ──────────────────────────────────────────────────────────────────────

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');

Route::middleware('guest')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Registrasi
    Route::get('/daftar',  [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register'])->name('register.post');
});

// Logout (wajib login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ──────────────────────────────────────────────────────────────────────
// Area yang memerlukan login (semua peran)
// ──────────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Profil & ganti password – semua peran yang sudah login
    Route::get('/profil', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profil/ganti-password', [AuthController::class, 'changePassword'])->name('password.change');

    // ──────────────────────────────────────────────────────────────────
    // SUPER ADMIN – akses penuh ke semua fitur
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('superadmin')
        ->name('superadmin.')
        ->middleware('role:superadmin')
        ->group(function () {
            Route::get('/dashboard',      fn () => view('superadmin.dashbord'))->name('dashboard');
            Route::get('/manajemen-user', fn () => view('superadmin.manajemen_user'))->name('manajemen-user');
        });

    // ──────────────────────────────────────────────────────────────────
    // KEPALA BPMP – lihat laporan & persetujuan
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('kepalabpmp')
        ->name('kepalabpmp.')
        ->middleware('role:kepalabpmp,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('kepalabpmp.dashbord'))->name('dashboard');
        });

    // ──────────────────────────────────────────────────────────────────
    // KASUBAG TU – pengelolaan administrasi
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('kasubag')
        ->name('kasubag.')
        ->middleware('role:kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', [KasubagController::class, 'dashboard'])->name('dashboard');
            Route::get('/persetujuan-peminjaman-gedung', [KasubagController::class, 'persetujuanPeminjamanGedung'])->name('persetujuan-peminjaman-gedung');
            Route::get('/persetujuan-peminjaman-barang', [KasubagController::class, 'persetujuanPeminjamanBarang'])->name('persetujuan-peminjaman-barang');
            Route::get('/persetujuan-peminjaman-kendaraan', [KasubagController::class, 'persetujuanPeminjamanKendaraan'])->name('persetujuan-peminjaman-kendaraan');
            Route::get('/persetujuan-permintaan-persediaan', [KasubagController::class, 'persetujuanPermintaanPersediaan'])->name('persetujuan-permintaan-persediaan');
            Route::get('/pengaturan-akun', [KasubagController::class, 'pengaturanAkun'])->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // ADMIN PERSEDIAAN – kelola barang persediaan
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminpersediaan')
        ->name('adminpersediaan.')
        ->middleware('role:adminpersediaan,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('adminpersediian.dashbord'))->name('dashboard');
            // Catatan: folder view typo → "adminpersediian" (sesuai folder yang ada)
        });

    // ──────────────────────────────────────────────────────────────────
    // ADMIN SARPRAS – kelola sarana dan prasarana
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminsarpras')
        ->name('adminsarpras.')
        ->middleware('role:adminsarpras,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('adminsarpras.dashbord'))->name('dashboard');
            Route::get('/data-gedung', [AdminSarprasController::class, 'dataGedung'])->name('data-gedung');
            Route::get('/daftar-peminjaman', [AdminSarprasController::class, 'daftarPeminjaman'])->name('daftar-peminjaman');
            Route::get('/laporan-peminjaman-gedung', [AdminSarprasController::class, 'laporanPeminjamanGedung'])->name('laporan-peminjaman-gedung');
            Route::get('/pengaturan-akun', [AdminSarprasController::class, 'pengaturanAkun'])->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // ADMIN ASET TETAP – kelola aset tetap / BMN
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminasettetap')
        ->name('adminasettetap.')
        ->middleware('role:adminasettetap,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('adminasettetap.dashbord'))->name('dashboard');
        });

    // ──────────────────────────────────────────────────────────────────
    // PEGAWAI – akses terbatas (pengajuan peminjaman, dll.)
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('pegawai')
        ->name('pegawai.')
        ->middleware('role:pegawai,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('pegawai.dashbord'))->name('dashboard');
            Route::get('/peminjaman-barang', fn () => view('pegawai.peminjaman_barang'))->name('peminjaman-barang');
            Route::get('/peminjaman-kendaraan', fn () => view('pegawai.peminjaman_kendaraan'))->name('peminjaman-kendaraan');
            Route::get('/permintaan-persediaan', fn () => view('pegawai.permintaan_persediaan'))->name('permintaan-persediaan');
            Route::get('/pengaturan-akun', fn () => view('pegawai.pengaturan_akun'))->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // TAMU – akses baca saja
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('tamu')
        ->name('tamu.')
        ->middleware('role:tamu,superadmin')
        ->group(function () {
            Route::get('/dashboard', [TamuController::class, 'dashboard'])->name('dashboard');
            Route::get('/peminjaman-gedung', [TamuController::class, 'peminjamangedung'])->name('peminjaman-gedung');
            Route::get('/pengaturan-akun', [TamuController::class, 'pengaturanAkun'])->name('pengaturan-akun');
            Route::get('/info-fasilitas', [TamuController::class, 'infoFasilitas'])->name('info-fasilitas');
        });
});
