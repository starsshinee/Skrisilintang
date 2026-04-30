<?php

use App\Http\Controllers\AdminSarprasController;
use App\Http\Controllers\AdminAsettetapController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepalaBPMPController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AdminPersediaanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;


// ──────────────────────────────────────────────────────────────────────
// Halaman Publik
// ──────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== PENGADUAN dan SURVEY KEPUASAN PUBLIC FORM (TIDAK PERLU LOGIN) ==========
Route::post('/pengaduan/store', [AdminAsettetapController::class, 'pengaduanStore'])->name('pengaduan.store');
Route::post('/survey/store', [AdminAsettetapController::class, 'surveyStore'])->name('survey.store');

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
// routes/web.php
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes - PAKAI MIDDLEWARE ANDA!
Route::middleware('checkrole')->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/signature', [AuthController::class, 'updateProfile'])->name('profile.signature');
    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Superadmin Register - PAKAI MIDDLEWARE ANDA!
    Route::middleware('checkrole:superadmin')->group(function () {
        Route::get('/register', function() { return view('auth.register'); })->name('register.show');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    });

    // Role-specific dashboards
    Route::middleware('checkrole:superadmin')->group(function () {
        Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'))->name('superadmin.dashboard');
    });
    Route::middleware('checkrole:kepalabpmp')->group(function () {
        Route::get('/kepalabpmp/dashboard', fn() => view('kepalabpmp.dashboard'))->name('kepalabpmp.dashboard');
    });
    Route::middleware('checkrole:kasubag')->group(function () {
        Route::get('/kasubag/dashboard', fn() => view('kasubag.dashboard'))->name('kasubag.dashboard');
    });
    Route::middleware('checkrole:adminpersediaan')->group(function () {
        Route::get('/adminpersediaan/dashboard', fn() => view('adminpersediaan.dashboard'))->name('kasubag.dashboard');
    });
    Route::middleware('checkrole:adminsarpras')->group(function () {
        Route::get('/adminsarpras/dashboard', fn() => view('adminsarpras.dashboard'))->name('adminsarpras.dashboard');
    });
    Route::middleware('checkrole:adminasettetap')->group(function () {
        Route::get('/adminasettetap/dashboard', fn() => view('adminasettetap.dashboard'))->name('adminasettetap.dashboard');
    });
    Route::middleware('checkrole:pegawai')->group(function () {
        Route::get('/pegawai/dashboard', fn() => view('pegawai.dashboard'))->name('pegawai.dashboard');
    });
    Route::middleware('checkrole:tamu')->group(function () {
        Route::get('/tamu/dashboard', fn() => view('tamu.dashboard'))->name('tamu.dashboard');
    });

Route::middleware('auth')->group(function () {

    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/signature', [AuthController::class, 'updateProfile'])->name('profile.signature'); // Same method
    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // ──────────────────────────────────────────────────────────────────
    // SUPER ADMIN – akses penuh ke semua fitur
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('superadmin')
        ->name('superadmin.')
        ->middleware('role:superadmin')
        ->group(function () {
            Route::get('/dashboard',      fn () => view('superadmin.dashbord'))->name('dashboard');
            Route::get('/manajemen-user', fn () => view('superadmin.manajemen_user'))->name('manajemen-user');
            Route::post('/register', [AuthController::class, 'register'])->name('register');
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // KEPALA BPMP – lihat laporan & persetujuan
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('kepalabpmp')
        ->name('kepalabpmp.')
        ->middleware('role:kepalabpmp,superadmin')
        ->group(function () {
            Route::get('/dashboard', [KepalaBPMPController::class, 'dashboard'])->name('dashboard');
            Route::get('/laporan', [KepalaBPMPController::class, 'laporan'])->name('laporan');
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // KASUBAG TU – pengelolaan administrasi
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('kasubag')
        ->name('kasubag.')
        ->middleware('role:kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', [KasubagController::class, 'dashboard'])->name('dashboard');
            Route::get('/pengaturan-akun', [KasubagController::class, 'pengaturanAkun'])->name('pengaturan-akun');

            //PEMINJAMAN BARANG
            Route::get('/persetujuan-peminjaman-barang', [KasubagController::class, 'persetujuanPeminjamanBarang'])->name('persetujuan-peminjaman-barang');

            //PEMINJAMAN KENDARAAN
            Route::get('/persetujuan-peminjaman-kendaraan', [KasubagController::class, 'persetujuanPeminjamanKendaraan'])->name('persetujuan-peminjaman-kendaraan');   
            
            //PERMINTAAN PERSEDIAAN
            Route::get('/persetujuan-permintaan-persediaan', [KasubagController::class, 'persetujuanPermintaanPersediaan'])->name('persetujuan-permintaan-persediaan');
            Route::get('/permintaan-persediaan', [KasubagController::class, 'permintaanPersediaan'])->name('permintaan-persediaan');
            Route::post('/permintaan/{permintaan}/approve', [KasubagController::class, 'approvePermintaan'])->name('approve-permintaan');
            Route::get('/permintaan-persediaan/{id}', [KasubagController::class, 'showPermintaan'])->name('permintaan-persediaan.show');
            
            // PEMINJAMAN GEDUNG
            Route::get('/peminjaman-gedung/{peminjaman}', [KasubagController::class, 'show'])->name('peminjaman-gedung.show');
            Route::post('/peminjaman-gedung/{peminjaman}/approve', [KasubagController::class, 'approveByKasubag']);
            Route::post('/peminjaman-gedung/{peminjaman}/reject', [KasubagController::class, 'rejectByKasubag']);
            Route::get('/peminjaman-gedung/{peminjaman}/download', [KasubagController::class, 'downloadSurat']);
            Route::get('/persetujuan-peminjaman-gedung', [KasubagController::class, 'persetujuanPeminjamanGedung'])->name('persetujuan-peminjaman-gedung'); 
            Route::get('/peminjaman/{peminjaman}/surat/download', [KasubagController::class, 'downloadSurat'])->name('download-surat');
            Route::get('/kasubag/peminjaman-gedung/{peminjaman}', [KasubagController::class, 'show'])->name('kasubag.peminjaman-gedung.show');

            //PENGATURAN AKUN
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
        });

    // ──────────────────────────────────────────────────────────────────
    // ADMIN PERSEDIAAN – kelola barang persediaan
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminpersediaan')
    ->name('adminpersediaan.')
    ->middleware('role:adminpersediaan,kasubag,superadmin')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminPersediaanController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
        
        // 📋 DATA PERSEDIAAN - Custom Routes (bukan resource)
        Route::get('/data-persediaan', [AdminPersediaanController::class, 'dataPersediaan'])->name('data-persediaan');
        Route::get('/data-persediaan/create', [AdminPersediaanController::class, 'create'])->name('data-persediaan.create');
        Route::post('/data-persediaan', [AdminPersediaanController::class, 'store'])->name('data-persediaan.store');
        Route::get('/data-persediaan/{persediaan}', [AdminPersediaanController::class, 'show'])->name('data-persediaan.show');
        Route::get('/data-persediaan/{persediaan}/edit', [AdminPersediaanController::class, 'edit'])->name('data-persediaan.edit');
        Route::put('/data-persediaan/{persediaan}', [AdminPersediaanController::class, 'update'])->name('data-persediaan.update');
        Route::delete('/data-persediaan/{persediaan}', [AdminPersediaanController::class, 'destroy'])->name('data-persediaan.destroy');
        
        // 📤 TRANSAKSI KELUAR
        Route::get('/transaksi-keluar', [AdminPersediaanController::class, 'transaksiKeluar'])->name('transaksi-keluar');
        Route::get('/transaksi-keluar/create', [AdminPersediaanController::class, 'createTransaksiKeluar'])->name('transaksi-keluar.create');
        Route::post('/transaksi-keluar', [AdminPersediaanController::class, 'storeTransaksiKeluar'])->name('transaksi-keluar.store');
        Route::get('/transaksi-keluar/{transaksiKeluar}', [AdminPersediaanController::class, 'showTransaksiKeluar'])->name('transaksi-keluar.show');
        Route::get('/transaksi-keluar/{transaksiKeluar}/edit', [AdminPersediaanController::class, 'editTransaksiKeluar'])->name('transaksi-keluar.edit');
        Route::put('/transaksi-keluar/{transaksiKeluar}', [AdminPersediaanController::class, 'updateTransaksiKeluar'])->name('transaksi-keluar.update');
        Route::delete('/transaksi-keluar/{transaksiKeluar}', [AdminPersediaanController::class, 'destroyTransaksiKeluar'])->name('transaksi-keluar.destroy');
        
        // TRANSAKSI MASUK
        Route::get('/transaksi-masuk', [AdminPersediaanController::class, 'TransaksiMasuk'])->name('transaksi-masuk');
        Route::get('/transaksi-masuk/create', [AdminPersediaanController::class, 'createTransaksiMasuk'])->name('transaksi-masuk.create');
        Route::post('/transaksi-masuk', [AdminPersediaanController::class, 'storeTransaksiMasuk'])->name('transaksi-masuk.store');
        Route::get('/transaksi-masuk/{transaksiMasuk}', [AdminPersediaanController::class, 'showTransaksiMasuk'])->name('transaksi-masuk.show');
        Route::get('/transaksi-masuk/{transaksiMasuk}/edit', [AdminPersediaanController::class, 'editTransaksiMasuk'])->name('transaksi-masuk.edit');
        Route::put('/transaksi-masuk/{transaksiMasuk}', [AdminPersediaanController::class, 'updateTransaksiMasuk'])->name('transaksi-masuk.update');
        Route::delete('/transaksi-masuk/{transaksiMasuk}', [AdminPersediaanController::class, 'destroyTransaksiMasuk'])->name('transaksi-masuk.destroy');

        //PERMINTAAN PERSEDIAAN
        Route::get('/permintaan-persediaan', [AdminPersediaanController::class, 'PermintaanPersediaan'])->name('permintaan-persediaan');
        Route::get('/permintaan/{id}', [AdminPersediaanController::class, 'showPermintaan'])->name('permintaan.show');
        
        Route::post('/permintaan/{permintaan}/review', [AdminPersediaanController::class, 'reviewPermintaan'])->name('review-permintaan');
        Route::get('/surat/{permintaan}', [AdminPersediaanController::class, 'generateSuratPermintaan'])->name('surat-permintaan');

        //LAPORAN
        Route::get('/laporan-permintaan-persediaan', [AdminPersediaanController::class, 'laporanPermintaanPersediaan'])->name('laporan-permintaan-persediaan');
        Route::get('/laporan-transaksi-masuk', [AdminPersediaanController::class, 'laporanTransaksiMasuk'])->name('laporan-transaksi-masuk');
        Route::get('/adminpersediaan/laporan-transaksi-masuk/pdf', [AdminPersediaanController::class, 'downloadLaporanTransaksiMasuk'])->name('laporan-transaksi-masuk.pdf');
        Route::get('adminpersediaan/laporan-transaksi-keluar/download', [App\Http\Controllers\AdminPersediaanController::class, 'downloadLaporanTransaksiKeluar'])->name('laporan-transaksi-keluar.download');

        Route::get('/laporan-transaksi-keluar', [AdminPersediaanController::class, 'laporanTransaksiKeluar'])->name('laporan-transaksi-keluar');
        
});

    // ──────────────────────────────────────────────────────────────────
    // ADMIN SARPRAS – kelola sarana dan prasarana
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminsarpras')
        ->name('adminsarpras.')
        ->middleware('role:adminsarpras,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', [AdminSarprasController::class, 'dashboard']) ->name('dashboard');
            Route::get('/data-gedung', [AdminSarprasController::class, 'dataGedung'])->name('data-gedung');
            Route::get('/data-kerusakan', [AdminSarprasController::class, 'dataKerusakan'])->name('data-kerusakan');
            Route::post('/simpan-kerusakan', [AdminSarprasController::class, 'storeKerusakan'])->name('simpan-kerusakan');
            Route::get('/daftar-peminjaman', [AdminSarprasController::class, 'daftarPeminjaman'])->name('daftar-peminjaman');
            Route::get('/daftar-pengembalian', [AdminSarprasController::class, 'daftarPengembalian'])->name('daftar-pengembalian');
            Route::get('/laporan-peminjaman-gedung', [AdminSarprasController::class, 'laporanPeminjamanGedung'])->name('laporan-peminjaman-gedung');
            Route::get('/laporan-kerusakan', [AdminSarprasController::class, 'laporanKerusakan'])->name('laporan-kerusakan');
            Route::get('/peminjaman/{peminjaman}/surat/download', [AdminSarprasController::class, 'downloadSurat'])->name('download-surat');
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
            
            //DATA GEDUNG
            Route::post('/data-gedung', [AdminSarprasController::class, 'storeGedung'])->name('data-gedung.store');
            Route::get('/gedung/{gedung}', [AdminSarprasController::class, 'showGedungJson'])->name('gedung.show');
            Route::put('/gedung/{gedung}', [AdminSarprasController::class, 'updateGedung'])->name('gedung.update');
            Route::delete('/gedung/{gedung}', [AdminSarprasController::class, 'destroyGedung'])->name('gedung.destroy');
             Route::get('data-gedung/{gedung}', [AdminSarprasController::class, 'showGedungJson'])->name('data-gedung.show');
            
                    
            // Modal AJAX Routes (BARU)
            Route::get('/data-kerusakan/{kerusakan}/edit', [AdminSarprasController::class, 'editKerusakanJson'])->name('kerusakan.edit.json');
            Route::get('/data-kerusakan/{kerusakan}', [AdminSarprasController::class, 'showKerusakanJson'])->name('kerusakan.show.json');
            Route::post('/data-kerusakan', [AdminSarprasController::class, 'storeKerusakan'])->name('kerusakan.store');
            Route::post('/data-kerusakan/{kerusakan}/update', [AdminSarprasController::class, 'updateKerusakanAjax'])->name('kerusakan.update.ajax');
            Route::delete('/data-kerusakan/{kerusakan}', [AdminSarprasController::class, 'destroyKerusakan'])->name('kerusakan.destroy');

            //ROUTE PERSETUJUAN PEMINJAMAN
            Route::post('/peminjaman/{peminjaman}/forward', [AdminSarprasController::class, 'forwardToKasubag'])->name('peminjaman.forward');
            Route::post('/peminjaman/{peminjaman}/reject', [AdminSarprasController::class, 'rejectByAdmin'])->name('peminjaman.reject');
            Route::get('/peminjaman/{peminjaman}/download-surat', [AdminSarprasController::class, 'downloadSurat'])->name('download-surat');
        });


    // ──────────────────────────────────────────────────────────────────
    // ADMIN ASET TETAP – kelola aset tetap / BMN
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminasettetap')
        ->name('adminasettetap.')
        ->middleware('role:adminasettetap,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', [AdminAsettetapController::class, 'dashboard'])->name('dashboard');
            Route::get('/data-aset-tetap', [AdminAsettetapController::class, 'dataAsetTetap'])->name('data-aset-tetap');
            Route::get('/transaksi-masuk', [AdminAsettetapController::class, 'TransaksiMasuk'])->name('transaksi-masuk');
            Route::get('/transaksi-keluar', [AdminAsettetapController::class, 'TransaksiKeluar'])->name('transaksi-keluar');
            Route::get('/mutasi-barang', [AdminAsettetapController::class, 'mutasiBarang'])->name('mutasi-barang');
            Route::get('/pengaduan', [AdminAsettetapController::class, 'pengaduan'])->name('pengaduan');
            Route::get('/survey-kepuasan', [AdminAsettetapController::class, 'surveyKepuasan'])->name('survey-kepuasan');
            Route::get('/peminjaman-barang', [AdminAsettetapController::class, 'PeminjamanBarang'])->name('peminjaman-barang');
            Route::get('/pengembalian-barang', [AdminAsettetapController::class, 'PengembalianBarang'])->name('pengembalian-barang');
            Route::get('/peminjaman-kendaraan', [AdminAsettetapController::class, 'PeminjamanKendaraan'])->name('peminjaman-kendaraan');
            Route::get('/pengembalian-kendaraan', [AdminAsettetapController::class, 'PengembalianKendaraan'])->name('pengembalian-kendaraan');  
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');            
            
            // Laporan 
            Route::get('/laporan-transaksi-masuk', [AdminAsettetapController::class, 'laporanTransaksiMasuk'])->name('laporan-transaksi-masuk');  
            Route::get('/laporan-transaksi-keluar', [AdminAsettetapController::class, 'laporanTransaksiKeluar'])->name('laporan-transaksi-keluar');
            Route::get('/laporan-mutasi-barang', [AdminAsettetapController::class, 'laporanMutasiAsetTetap'])->name('laporan-mutasi-barang');
            Route::get('/laporan-peminjaman-pengembalian', [AdminAsettetapController::class, 'laporanPeminjamanpengembalian'])->name('laporan-peminjaman-pengembalian');

            // ========== CRUD DATA ASET TETAP ==========
            Route::get('/data-aset-tetap/create', [AdminAsettetapController::class, 'createDataAsetTetap'])->name('data-aset-tetap.create');
            Route::post('/data-aset-tetap', [AdminAsettetapController::class, 'storeDataAsetTetap'])->name('data-aset-tetap.store');
            Route::get('/data-aset-tetap/{aset}', [AdminAsettetapController::class, 'showDataAsetTetap'])->name('data-aset-tetap.show');
            Route::get('/data-aset-tetap/{aset}/edit', [AdminAsettetapController::class, 'editDataAsetTetap'])->name('data-aset-tetap.edit');
            Route::put('/data-aset-tetap/{aset}', [AdminAsettetapController::class, 'updateDataAsetTetap'])->name('data-aset-tetap.update');
            Route::delete('/data-aset-tetap/{aset}', [AdminAsettetapController::class, 'destroyDataAsetTetap'])->name('data-aset-tetap.destroy');
            
            
            
            // ========== CRUD TRANSAKSI KELUAR ASET TETAP ==========
            // ========== TRANSAKSI KELUAR ==========
            Route::get('/adminasettetap/transaksi-keluar', [AdminAsettetapController::class, 'TransaksiKeluar'])->name('transaksi-keluar');
            Route::get('/adminasettetap/transaksi-keluar/create', [AdminAsettetapController::class, 'createTransaksiKeluar'])->name('transaksi-keluar.create');
            Route::post('/adminasettetap/transaksi-keluar', [AdminAsettetapController::class, 'storeTransaksiKeluar'])->name('transaksi-keluar.store');

            // ✅ SATU ROUTE UNTUK AUTO-FILL
            Route::get('/aset-tetap/{id}', [AdminAsettetapController::class, 'getAsetData'])->name('admin-aset-data');

            // // Detail & Edit JSON
            Route::get('transaksi-keluar/{id}/show-aset', [AdminAsettetapController::class, 'showWithAset'])->name('transaksi-keluar.show-aset');
            Route::get('transaksi-keluar/{id}/edit-json', [AdminAsettetapController::class, 'editJson'])->name('transaksi-keluar.edit-json');
            
            // ✅ DELETE ROUTE - TAMBAHAN BARU
Route::delete('transaksi-keluar/{transaksi}', [AdminAsettetapController::class, 'destroyTransaksiKeluar'])->name('transaksi-keluar.destroy');

            // ========== CRUD TRANSAKSI MASUK ASET TETAP ==========
            Route::get('/transaksi-masuk/create', [AdminAsettetapController::class, 'createTransaksiMasuk'])->name('transaksi-masuk.create');
            Route::post('/transaksi-masuk', [AdminAsettetapController::class, 'storeTransaksiMasuk'])->name('transaksi-masuk.store');
            Route::get('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'showTransaksiMasuk'])->name('transaksi-masuk.show');
            Route::get('/transaksi-masuk/{transaksi}/edit', [AdminAsettetapController::class, 'editTransaksiMasuk'])->name('transaksi-masuk.edit');
            Route::put('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'updateTransaksiMasuk'])->name('transaksi-masuk.update');
            Route::delete('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'destroyTransaksiMasuk'])->name('transaksi-masuk.destroy');

            //CRUD MUTASI BARANG
            // Mutasi Barang Routes
            Route::post('/mutasi-barang', [AdminAsettetapController::class, 'mutasiBarangStore'])->name('mutasi-barang.store');
            Route::put('/mutasi-barang/{id}', [AdminAsettetapController::class, 'mutasiBarangUpdate'])->name('mutasi-barang.update');
            Route::delete('/mutasi-barang/{id}', [AdminAsettetapController::class, 'mutasiBarangDestroy'])->name('mutasi-barang.destroy');
            Route::get('/mutasi-barang/{id}', [AdminAsettetapController::class, 'mutasiBarangShow']);
            Route::get('/mutasi-barang/{id}/edit', [AdminAsettetapController::class, 'mutasiBarangEdit']);
            Route::get('/mutasi-barang/aset/{id}', [AdminAsettetapController::class, 'getAsetTetapData'])->name('mutasi-barang.aset');
            
            //CRUD PENGADUAN
            Route::get('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanShow'])->name('pengaduan.show');
            Route::put('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanUpdate'])->name('pengaduanUpdate');
    Route::delete('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanDestroy'])->name('pengaduanDestroy');

            //DELET SURVEY KEPUASAN
            Route::delete('/survey/{survey}', [AdminAsettetapController::class, 'surveyDestroy'])->name('survey.destroy');
            Route::get('/survey-kepuasan/export-excel', [AdminAsettetapController::class, 'exportExcel'])->name('survey.excel-export');
            
            // 📊 LAPORAN & ANALITIK (BARU ⭐)
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
            Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');

            // 📥 DOWNLOAD ROUTES (LENGKAP)
            Route::get('/transaksi-masuk/download', [LaporanController::class, 'downloadTransaksiMasuk'])->name('transaksi-masuk.download');
            Route::get('/transaksi-keluar/download', [LaporanController::class, 'downloadTransaksiKeluar'])->name('transaksi-keluar.download');
            Route::get('/pengaduan/download', [LaporanController::class, 'downloadPengaduan'])->name('pengaduan.download');
            Route::get('/survey/download', [LaporanController::class, 'downloadSurvey'])->name('survey.download');
            Route::get('/peminjaman/download', [LaporanController::class, 'downloadPeminjaman'])->name('peminjaman.download');
            Route::get('/dashboard-summary/download', [LaporanController::class, 'downloadDashboardSummary'])->name('dashboard.download');
            Route::get('/all/download', [LaporanController::class, 'downloadAll'])->name('all.download');
            
            });
        

    // ──────────────────────────────────────────────────────────────────


    // ──────────────────────────────────────────────────────────────────
    // PEGAWAI – akses terbatas (pengajuan peminjaman, dll.)
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('pegawai')
        ->name('pegawai.')
        ->middleware('role:pegawai,superadmin')
        ->group(function () {
            Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
            Route::get('/peminjaman-barang', [PegawaiController::class, 'peminjamanBarang'])->name('peminjaman-barang');
            Route::get('/pengembalian-barang', [PegawaiController::class, 'pengembalianBarang'])->name('pengembalian-barang');
            Route::get('/peminjaman-kendaraan', [PegawaiController::class, 'peminjamanKendaraan'])->name('peminjaman-kendaraan');
            Route::get('/pengembalian-kendaraan', [PegawaiController::class, 'pengembalianKendaraan'])->name('pengembalian-kendaraan'); 
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');

            //PERMINTAAN PERSEDIAAN
            Route::get('/permintaan-persediaan', [PegawaiController::class, 'permintaanPersediaan'])->name('permintaan-persediaan');
            Route::post('/permintaan-persediaan', [PegawaiController::class, 'storePermintaanPersediaan'])->name('permintaan-persediaan.store');
            Route::get('/permintaan-persediaan/{id}', [PegawaiController::class, 'detailPermintaanPersediaan'])->name('permintaan_persediaan.detail');
            Route::post('/permintaan-persediaan/{id}/cancel', [PegawaiController::class, 'cancelPermintaanPersediaan'])->name('permintaan_persediaan.cancel');
            // web.php atau routes/pegawai.php
            // Route::get('/permintaan-persediaan/{id}', [PegawaiController::class, 'showDetail'])->name('detail');
            // Route::post('/permintaan-persediaan/{id}/cancel', [PegawaiController::class, 'cancel'])->name('cancel');
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
            Route::post('/peminjaman-gedung', [TamuController::class, 'storePeminjamanGedung'])->name('peminjaman-gedung.store');
            Route::get('/peminjaman-gedung/{peminjaman}', [TamuController::class, 'showPeminjamanGedung'])->name('peminjaman-gedung.show');
            Route::get('/pengembalian-gedung', [TamuController::class, 'pengembaliangedung'])->name('pengembalian-gedung');
            Route::get('/pengaturan-akun', [AuthController::class, 'showProfile'])->name('pengaturan-akun');
            Route::get('/info-fasilitas', [TamuController::class, 'infoFasilitas'])->name('info-fasilitas');
        });

});

