<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenarikanDataController;
use App\Http\Middleware\VerifyApiKey;

Route::middleware([VerifyApiKey::class, 'throttle:60,1'])->group(function () {

    // ── ASET TETAP ──────────────────────────────────────────
    Route::prefix('aset-tetap')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterAssetTetap']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukAssetTetap']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarAssetTetap']);
    });

    // ── PERSEDIAAN ──────────────────────────────────────────
    Route::prefix('persediaan')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterPersediaan']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukPersediaan']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarPersediaan']);
    });

    // ── OPERASIONAL ─────────────────────────────────────────
    Route::get('/mutasi-barang', [PenarikanDataController::class, 'getMutasiBarang']);
    Route::get('/peminjaman-barang', [PenarikanDataController::class, 'getPeminjamanBarang']);
    Route::get('/peminjaman-kendaraan', [PenarikanDataController::class, 'getPeminjamanKendaraan']);
    Route::get('/peminjaman-gedung', [PenarikanDataController::class, 'getPeminjamanGedung']);
    Route::get('/permintaan-persediaan', [PenarikanDataController::class, 'getPermintaanPersediaan']);
    Route::get('/pengembalian-barang', [PenarikanDataController::class, 'getPengembalianBarang']);
    Route::get('/pengembalian-kendaraan', [PenarikanDataController::class, 'getPengembalianKendaraan']);
    Route::get('/kerusakan', [PenarikanDataController::class, 'getKerusakan']);

});
