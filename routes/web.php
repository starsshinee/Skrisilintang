<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────────────────────────────
// Halaman Publik
// ──────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ──────────────────────────────────────────────────────────────────────
// Autentikasi – hanya untuk tamu (belum login)
// ──────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
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
            Route::get('/dashboard', fn () => view('kasubag.dashbord'))->name('dashboard');
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
            Route::get('/data-gedung', 'AdminSarprasController@dataGedung')->name('adminsarpras.data-gedung');
            Route::get('/daftar-peminjaman', 'AdminSarprasController@daftarPeminjaman')->name('adminsarpras.daftar-peminjaman');
            Route::get('/laporan', 'AdminSarprasController@laporan')->name('adminsarpras.laporan');
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
        });

    // ──────────────────────────────────────────────────────────────────
    // TAMU – akses baca saja
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('tamu')
        ->name('tamu.')
        ->middleware('role:tamu,superadmin')
        ->group(function () {
            Route::get('/dashboard',        fn () => view('tamu.dashbord'))->name('dashboard');
            Route::get('/peminjaman-aset',  fn () => view('tamu.peminjaman_aset'))->name('peminjaman-aset');
            Route::get('/pengaturan-akun',  fn () => view('tamu.pengaturan_akun'))->name('pengaturan-akun');
            Route::get('/info-fasilitas',   fn () => view('tamu.info_fasilitas'))->name('info-fasilitas');
        });
});
