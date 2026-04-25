<?php

use App\Http\Controllers\AdminSarprasController;
use App\Http\Controllers\AdminAsettetapController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminPersediaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepalaBPMPController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TamuController;
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
            Route::get('/dashboard', [KepalaBPMPController::class, 'dashboard'])->name('dashboard');
            Route::get('/laporan', [KepalaBPMPController::class, 'laporan'])->name('laporan');

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
            Route::get('/persetujuan-peminjaman-barang', [KasubagController::class, 'persetujuanPeminjamanBarang'])->name('persetujuan-peminjaman-barang');
            Route::get('/persetujuan-peminjaman-kendaraan', [KasubagController::class, 'persetujuanPeminjamanKendaraan'])->name('persetujuan-peminjaman-kendaraan');                
            Route::get('/persetujuan-permintaan-persediaan', [KasubagController::class, 'persetujuanPermintaanPersediaan'])->name('persetujuan-permintaan-persediaan');
            Route::get('/persetujuan-peminjaman-gedung', [KasubagController::class, 'persetujuanPeminjamanGedung'])->name('persetujuan-peminjaman-gedung'); 
        });

    // ──────────────────────────────────────────────────────────────────
    // ADMIN PERSEDIAAN – kelola barang persediaan
    // ──────────────────────────────────────────────────────────────────
    Route::prefix('adminpersediaan')
        ->name('adminpersediaan.')
        ->middleware('role:adminpersediaan,kasubag,superadmin')
        ->group(function () {
            Route::get('/dashboard', fn () => view('adminpersediian.dashbord'))->name('dashboard');
            Route::get('/data-persediaan', fn () => view('adminpersediian.data_persediaan'))->name('data-persediaan');
            Route::get('/transaksi-masuk', fn () => view('adminpersediian.transaksi_masuk'))->name('transaksi-masuk');
            Route::get('/transaksi-keluar', fn () => view('adminpersediian.transaksi_keluar'))->name('transaksi-keluar');
            Route::get('/permintaan-persediaan', fn () => view('adminpersediian.permintaan_persediaan'))->name('permintaan-persediaan');
            Route::get('/laporan-permintaan-persediaan', fn () => view('adminpersediian.laporan_permintaan_persediaan'))->name('laporan-permintaan-persediaan');
            Route::get('/laporan-transaksi-masuk', fn () => view('adminpersediian.laporan_transaksimasuk'))->name('laporan-transaksi-masuk');
            Route::get('/laporan-transaksi-keluar', fn () => view('adminpersediian.laporan_transaksikeluar'))->name('laporan-transaksi-keluar');
            // Catatan: folder view typo → "adminpersediian" (sesuai folder yang ada)
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
            Route::get('/tambah-kerusakan', [AdminSarprasController::class, 'createKerusakan'])
            ->name('tambah-kerusakan');  // ← PASTI SEPERTI INI
            Route::post('/tambah-kerusakan', [AdminSarprasController::class, 'storeKerusakan'])
            ->name('store-kerusakan');
            // // Data kerusakan
            //     Route::middleware(['auth'])->group(function() {
            //     Route::get('/data-kerusakan', [AdminSarprasController::class, 'dataKerusakan'])->name('data-kerusakan');
            //     Route::get('/tambah-kerusakan', [AdminSarprasController::class, 'createKerusakan'])->name('tambah-kerusakan');
            //     Route::post('/tambah-kerusakan', [AdminSarprasController::class, 'storeKerusakan'])->name('store-kerusakan');
            // });
            Route::post('/simpan-kerusakan', [AdminSarprasController::class, 'storeKerusakan'])->name('simpan-kerusakan');
            Route::get('/daftar-peminjaman', [AdminSarprasController::class, 'daftarPeminjaman'])->name('daftar-peminjaman');
            Route::get('/daftar-pengembalian', [AdminSarprasController::class, 'daftarPengembalian'])->name('daftar-pengembalian');
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
            
            // Laporan (tetap sama)
            Route::get('/laporan-transaksi-masuk', [AdminAsettetapController::class, 'laporanTransaksiMasuk'])->name('laporan-transaksi-masuk');  
            Route::get('/laporan-transaksi-keluar', [AdminAsettetapController::class, 'laporanTransaksiKeluar'])->name('laporan-transaksi-keluar');
            Route::get('/laporan-mutasi-barang', [AdminAsettetapController::class, 'laporanMutasiAsetTetap'])->name('laporan-mutasi-barang');
            Route::get('/laporan-peminjaman-pengembalian', [AdminAsettetapController::class, 'laporanPeminjamanpengembalian'])->name('laporan-peminjaman-pengembalian');

            // ========== CRUD DATA ASET TETAP ==========
           Route::get('/transaksi-keluar/create', [AdminAsettetapController::class, 'createTransaksiKeluar'])->name('transaksi-keluar.create');
            Route::post('/transaksi-keluar', [AdminAsettetapController::class, 'storeTransaksiKeluar'])->name('transaksi-keluar.store');
            Route::get('/transaksi-keluar/{transaksi}', [AdminAsettetapController::class, 'showTransaksiKeluar'])->name('transaksi-keluar.show');
            Route::get('/transaksi-keluar/{transaksi}/edit', [AdminAsettetapController::class, 'editTransaksiKeluar'])->name('transaksi-keluar.edit');
            Route::put('/transaksi-keluar/{transaksi}', [AdminAsettetapController::class, 'updateTransaksiKeluar'])->name('transaksi-keluar.update');
            Route::delete('/transaksi-keluar/{transaksi}', [AdminAsettetapController::class, 'destroyTransaksiKeluar'])->name('transaksi-keluar.destroy');

            // ========== AJAX ==========
            Route::get('/transaksi-keluar/aset/{id}', [AdminAsettetapController::class, 'getAsetKeluarData'])->name('transaksi-keluar.aset-data');

            // ========== CRUD TRANSAKSI MASUK ASET TETAP ==========
            Route::get('/transaksi-masuk/create', [AdminAsettetapController::class, 'createTransaksiMasuk'])->name('transaksi-masuk.create');
            Route::post('/transaksi-masuk', [AdminAsettetapController::class, 'storeTransaksiMasuk'])->name('transaksi-masuk.store');
            Route::get('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'showTransaksiMasuk'])->name('transaksi-masuk.show');
            Route::get('/transaksi-masuk/{transaksi}/edit', [AdminAsettetapController::class, 'editTransaksiMasuk'])->name('transaksi-masuk.edit');
            Route::put('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'updateTransaksiMasuk'])->name('transaksi-masuk.update');
            Route::delete('/transaksi-masuk/{transaksi}', [AdminAsettetapController::class, 'destroyTransaksiMasuk'])->name('transaksi-masuk.destroy');

            //CRUD MUTASI BARANG
            Route::get('/aset-tetap/mutasi-barang/create', [AdminAsetTetapController::class, 'createMutasi'])->name('mutasi-barang.create');
            Route::post('/aset-tetap/mutasi-barang', [AdminAsetTetapController::class, 'storeMutasi'])->name('mutasi-barang.store');
            Route::get('/aset-tetap/mutasi-barang/{mutasi}', [AdminAsetTetapController::class, 'showMutasi'])->name('mutasi-barang.show');
            Route::get('/aset-tetap/mutasi-barang/{mutasi}/edit', [AdminAsetTetapController::class, 'editMutasi'])->name('mutasi-barang.edit');
            Route::put('/aset-tetap/mutasi-barang/{mutasi}', [AdminAsetTetapController::class, 'updateMutasi'])->name('mutasi-barang.update');
            Route::delete('/aset-tetap/mutasi-barang/{mutasi}', [AdminAsetTetapController::class, 'destroyMutasi'])->name('mutasi-barang.destroy');
            
            //CRUD PENGADUAN
            Route::get('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanShow'])->name('pengaduan.show');
            Route::put('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanUpdate'])->name('pengaduan.update');
            Route::delete('/pengaduan/{pengaduan}', [AdminAsettetapController::class, 'pengaduanDestroy'])->name('pengaduan.destroy');

            //DELET SURVEY KEPUASAN
            Route::delete('/survey/{survey}', [AdminAsettetapController::class, 'surveyDestroy'])->name('survey.destroy');
            
            
        });

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
            Route::get('/permintaan-persediaan', [PegawaiController::class, 'permintaanPersediaan'])->name('permintaan-persediaan');
            Route::get('/pengaturan-akun', [PegawaiController::class, 'pengaturanAkun'])->name('pengaturan-akun');
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
            Route::get('/pengembalian-gedung', [TamuController::class, 'pengembaliangedung'])->name('pengembalian-gedung');
            Route::get('/pengaturan-akun', [TamuController::class, 'pengaturanAkun'])->name('pengaturan-akun');
            Route::get('/info-fasilitas', [TamuController::class, 'infoFasilitas'])->name('info-fasilitas');
        });
});
