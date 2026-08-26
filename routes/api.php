<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenarikanDataController;
use App\Http\Middleware\VerifyApiKey;
// use App\Http\Controllers\Api\SaktiIntegrationController;

// Opsional: tambahkan middleware 'auth:sanctum' atau middleware token custom Anda
// Route::prefix('sakti')->group(function () {
//     Route::get('/master/aset-tetap', [SaktiIntegrationController::class, 'getAsetTetap']);
//     Route::get('/master/persediaan', [SaktiIntegrationController::class, 'getPersediaan']);
//     Route::get('/transaksi/aset-tetap/masuk', [SaktiIntegrationController::class, 'getMasukAsetTetap']);
//     Route::get('/transaksi/aset-tetap/keluar', [SaktiIntegrationController::class, 'getKeluarAsetTetap']);
//     Route::get('/transaksi/persediaan/masuk', [SaktiIntegrationController::class, 'getMasukPersediaan']);
//     Route::get('/transaksi/persediaan/keluar', [SaktiIntegrationController::class, 'getKeluarPersediaan']);
// });

Route::middleware([VerifyApiKey::class])->group(function () {
    // Endpoint Penarikan Data Aset Tetap
    Route::prefix('aset-tetap')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterAssetTetap']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukAssetTetap']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarAssetTetap']);
    });

    // Endpoint Penarikan Data Persediaan
    Route::prefix('persediaan')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterPersediaan']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukPersediaan']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarPersediaan']);
    });
});
