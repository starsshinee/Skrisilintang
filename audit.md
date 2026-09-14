# AUDIT KEAMANAN API - Sistem Penarikan Data (Provider)

**Proyek:** Sistem Informasi Manajemen BMN (SIPANDU)
**Tanggal Audit:** 14 September 2026
**Scope:** Endpoint API penarikan data dengan autentikasi API Key
**Role:** Provider/Penyedia data (SIPANDU menyediakan data untuk SAKTI)

---

## RINGKASAN EKSEKUTIF

| Total Temuan | Kritis | Tinggi | Sedang | Rendah |
|:---:|:---:|:---:|:---:|:---:|
| 12 | 2 | 4 | 4 | 2 |

**Status Keseluruhan: MEMERLUKAN PERBAIKAN SEGERA**

Terdapat 2 temuan kritis yang harus segera diperbaiki sebelum sistem dapat digunakan secara produksi. Temuan paling utama adalah **ketidaksesuaian nama variabel environment** yang menyebabkan middleware autentikasi API Key tidak berfungsi sebagaimana mestinya.

---

## ARSITEKTUR AUTENTIKASI SAAT INI

```
Postman/Client (SAKTI)
        │
        │  GET /api/aset-tetap/master
        │  Header: X-API-KEY: <key>
        │
        ▼
┌─────────────────────────┐
│   Laravel API Router    │
│   routes/api.php        │
│   prefix: /api          │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│   VerifyApiKey          │
│   Middleware             │
│                         │
│   env('API_SECRET_KEY') │ ◄── MASALAH: Variabel ini tidak ada di .env
│         vs              │
│   $request->header()    │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ PenarikanDataController │
│ (getMasterAssetTetap)   │
└─────────────────────────┘
```

---

## DAFTAR ENDPOINT YUNA DIDUGA

### A. Endpoint Provider (SIPANDU menyediakan data) - `routes/api.php`

| # | Method | Endpoint | Middleware | Status |
|---|--------|----------|-----------|--------|
| 1 | GET | `/api/aset-tetap/master` | VerifyApiKey | AKTIF |
| 2 | GET | `/api/aset-tetap/transaksi-masuk` | VerifyApiKey | AKTIF |
| 3 | GET | `/api/aset-tetap/transaksi-keluar` | VerifyApiKey | AKTIF |
| 4 | GET | `/api/persediaan/master` | VerifyApiKey | AKTIF |
| 5 | GET | `/api/persediaan/transaksi-masuk` | VerifyApiKey | AKTIF |
| 6 | GET | `/api/persediaan/transaksi-keluar` | VerifyApiKey | AKTIF |

### B. Endpoint Provider (Web Route) - `routes/web.php`

| # | Method | Endpoint | Middleware | Status |
|---|--------|----------|-----------|--------|
| 7 | GET | `/v1/tarik-data-sakti` | VerifyApiKey | AKTIF |

### C. Endpoint SAKTI Provider (SAKTI menyediakan data ke SIPANDU) - `routes/web.php`

| # | Method | Endpoint | Middleware | Status |
|---|--------|----------|-----------|--------|
| 8 | GET | `/v1/sakti/aset` | VerifySaktiApiKey | AKTIF |

### D. Endpoint Pull (SIPANDU menarik data dari SAKTI) - `routes/web.php`

| # | Method | Endpoint | Middleware | Status |
|---|--------|----------|-----------|--------|
| 9 | GET | `/sipandu/pull/aset-tetap` | **TIDAK ADA** | TANPA AUTENTIKASI |
| 10 | GET | `/sipandu/pull/persediaan` | **TIDAK ADA** | TANPA AUTENTIKASI |

---

## TEMUAN AUDIT

---

### TEMUAN #1 — KRITIS: Ketidaksesuaian Nama Variabel Environment

**Lokasi:** `app/Http/Middleware/VerifyApiKey.php:16` dan `.env:73`
**CVSS:** 9.8 (Critical)

**Masalah:**
Middleware `VerifyApiKey` memeriksa variabel `env('API_SECRET_KEY')`, tetapi variabel yang didefinisikan di `.env` adalah `API_KEY_SIPANDU`.

```php
// VerifyApiKey.php baris 16
if ($apiKey !== env('API_SECRET_KEY')) {  // ← Variabel: API_SECRET_KEY
```

```env
# .env baris 73
API_KEY_SIPANDU=KunciRahasiaSipandu2026!  # ← Variabel: API_KEY_SIPANDU
```

**Dampak:**
- `env('API_SECRET_KEY')` mengembalikan `null` karena variabel tidak didefinisikan
- Bandingkan `"KunciRahasiaSipandu2026!" !== null` selalu `true`
- **Semua request API akan selalu ditolak dengan 401 Unauthorized**, atau sebaliknya — tergantung bagaimana caching config bekerja
- Jika ada system environment variable `API_SECRET_KEY` di OS yang nilainya berbeda, API key yang valid di `.env` tidak akan dikenali

**Catatan Penting:**
Jika pengujian Postman terhadap `GET /api/aset-tetap/master` menghasilkan respons sukses, kemungkinan penyebabnya:
1. Ada environment variable OS bernama `API_SECRET_KEY` yang bernilai sama
2. Config cache (`php artisan config:cache`) menyimpan nilai dari waktu lampau
3. Ada file `.env.local` atau override environment lainnya
4. Request mengenai route lain yang tidak melewati middleware ini

**Rekomendasi:**
```php
// VerifyApiKey.php — PERBAIKAN
$apiKey = $request->header('X-API-KEY');
$validKey = config('services.sipandu_api_key');

if (!$apiKey || !hash_equals($validKey, $apiKey)) {
    return response()->json([
        'status'  => 'error',
        'message' => 'Unauthorized. API Key tidak valid atau tidak ditemukan.'
    ], 401);
}
```

```php
// config/services.php — tambahkan:
'sipandu_api_key' => env('API_KEY_SIPANDU'), 
```

**Mengapa menggunakan `hash_equals()`?**
Membandingkan string API key menggunakan `!==` rentan terhadap **timing attack**. `hash_equals()` melakukan perbandingan konstan waktu.

---

### TEMUAN #2 — KRITIS: Penggunaan `env()` Langsung di Middleware

**Lokasi:**
- `app/Http/Middleware/VerifyApiKey.php:16`
- `app/Http/Middleware/VerifySaktiApiKey.php:16`
- `app/Http/Controllers/Api/SaktiPullController.php:15,25,26`

**CVSS:** 9.1 (Critical)

**Masalah:**
Pemanggilan `env()` secara langsung di middleware dan controller. Dalam mode produksi Laravel, `php artisan config:cache` menyimpan semua nilai config ke file cached. Setelah config di-cache, **`env()` akan selalu mengembalikan `null`** untuk semua variabel.

```php
// VerifyApiKey.php — SAAT INI
if ($apiKey !== env('API_SECRET_KEY')) {  // ← env() langsung, BURUK

// VerifySaktiApiKey.php — SAAT INI
$envKey = env('SAKTI_API_KEY');  // ← env() langsung, BURUK
```

**Dampak:**
- Setelah `php artisan config:cache` dijalankan di server produksi, **semua autentikasi API akan gagal**
- Ini adalah bug "time bomb" — bekerja di development tetapi hancur di produksi
- Error-nya tidak eksplisit, hanya mengembalikan 401 Unauthorized

**Rekomendasi:**
Selalu gunakan `config()` dan definisikan nilai di file config:

```php
// config/services.php
return [
    'sipandu_api_key' => env('API_KEY_SIPANDU'),
    'sakti_api_key'   => env('SAKTI_API_KEY'),
    'sakti_endpoint'  => env('SAKTI_ENDPOINT'),
];
```

```php
// VerifyApiKey.php
$apiKey = $request->header('X-API-KEY');
if (!$apiKey || !hash_equals(config('services.sipandu_api_key'), $apiKey)) {
    // ...
}
```

---

### TEMUAN #3 — TINGGI: API Key Dikirim sebagai Query Parameter

**Lokasi:** Pengujian Postman — `GET /api/aset-tetap/master?X-API-KEY=KunciRahasiaSipandu2026!`
**CVSS:** 7.5 (High)

**Masalah:**
API Key dikirim sebagai **query parameter** di URL:
```
GET http://127.0.0.1:8000/api/aset-tetap/master?X-API-KEY=KunciRahasiaSipandu2026!
```

**Dampak:**
- API Key tercatat di **server access logs** (Apache/Nginx)
- API Key tercatat di **browser history** jika diakses via browser
- API Key tercatat di **proxy logs** dan **CDN logs**
- API Key bisa bocor melalui **Referer header** ke situs third-party
- **Tidak ada log audit trail** yang berarti karena key terekspos di URL

**Cara yang Benar (via Header):**
```
GET http://127.0.0.1:8000/api/aset-tetap/master
Headers:
  X-API-KEY: KunciRahasiaSipandu2026!
```

**Rekomendasi:**
1. Dokumentasikan bahwa API Key **wajib** dikirim via header `X-API-KEY`
2. Tambahkan validasi di middleware untuk menolak key dari query parameter
3. Buat dokumentasi API (OpenAPI/Swagger) yang jelas

```php
// Tambahkan validasi: tolak key dari query parameter
if ($request->query('X-API-KEY')) {
    return response()->json([
        'status'  => 'error',
        'message' => 'API Key harus dikirim melalui Header HTTP, bukan Query Parameter.'
    ], 400);
}
```

---

### TEMUAN #4 — TINGGI: Endpoint Pull Tanpa Autentikasi

**Lokasi:** `routes/web.php:47-50`
**CVSS:** 7.4 (High)

**Masalah:**
Dua endpoint yang digunakan oleh SIPANDU untuk menarik data dari SAKTI **tidak memiliki middleware autentikasi**:

```php
// routes/web.php baris 47-50
Route::prefix('sipandu/pull')->group(function () {
    Route::get('/aset-tetap', [SaktiPullController::class, 'syncAsetTetap']);
    Route::get('/persediaan', [SaktiPullController::class, 'syncPersediaan']);
});
```

**Dampak:**
- Siapapun dapat mengeksekusi sync data dari SAKTI tanpa autentikasi
- Dapat menyebabkan manipulasi data sinkronisasi
- Endpoint ini mengeksekusi HTTP request ke SAKTI — potensi SSRF (Server-Side Request Forgery)

**Rekomendasi:**
```php
Route::prefix('sipandu/pull')->middleware([VerifyApiKey::class])->group(function () {
    Route::get('/aset-tetap', [SaktiPullController::class, 'syncAsetTetap']);
    Route::get('/persediaan', [SaktiPullController::class, 'syncPersediaan']);
});
```

---

### TEMUAN #5 — TINGGI: Tidak Ada Rate Limiting pada Endpoint API

**Lokasi:** `routes/api.php` dan `routes/web.php`
**CVSS:** 7.3 (High)

**Masalah:**
Tidak ada implementasi rate limiting (throttling) pada endpoint API publik.

**Dampak:**
- **Brute force attack** terhadap API Key — penyerang dapat mencoba berbagai kombinasi key
- **Denial of Service (DoS)** — server dapat dibanjiri request
- **Penggunaan sumber daya berlebihan** — query database tanpa batasan

**Rekomendasi:**
```php
// routes/api.php
Route::middleware([VerifyApiKey::class, 'throttle:60,1'])->group(function () {
    Route::prefix('aset-tetap')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterAssetTetap']);
        // ...
    });
});
```

Atau buat custom throttle untuk API:
```php
Route::middleware([VerifyApiKey::class, 'throttle:api'])->group(function () {
    // ...
});
```

---

### TEMUAN #6 — TINGGI: Hardcoded API Key di Controller

**Lokasi:** `app/Http/Controllers/Api/SaktiPullController.php:24-26`
**CVSS:** 7.1 (High)

**Masalah:**
```php
$response = Http::withHeaders([
    'X-API-KEY' => env('SAKTI_API_KEY')  // ← env() langsung
])->get(env('SAKTI_ENDPOINT'));           // ← env() langsung
```

Selain menggunakan `env()` langsung (akan null di produksi), request HTTP outbound ini juga tidak memverifikasi SSL certificate.

**Dampak:**
- Request ke SAKTI akan gagal di produksi (env() = null)
- Tidak ada verifikasi SSL — rentan MITM (Man-in-the-Middle)
- Tidak ada timeout — request bisa hang selamanya

**Rekomendasi:**
```php
$response = Http::withHeaders([
    'X-API-KEY' => config('services.sakti_api_key')
])->timeout(30)
  ->withOptions(['verify' => true])
  ->get(config('services.sakti_endpoint'));
```

---

### TEMUAN #7 — SEDANG: Tidak Ada Mekanisme Rotasi API Key

**Lokasi:** Arsitektur keseluruhan
**CVSS:** 5.3 (Medium)

**Masalah:**
- API Key bersifat statis dan tidak pernah berubah
- Tidak ada mekanisme rotasi key secara otomatis
- Tidak ada key expiration
- Tidak ada pembagian key per client/consumer

**Dampak:**
- Jika key bocor, tidak ada cara untuk mengganti tanpa deploy ulang
- Semua konsumer menggunakan key yang sama — tidak bisa revoke per-client
- Tidak comply dengan best practice keamanan API

**Rekomendasi:**
1. Implementasikan multiple API keys di database
2. Buat endpoint untuk rotasi key
3. Set key expiration (misal: 90 hari)
4. Beri label per client (misal: `sakti_v1`, `monitoring_v1`)

---

### TEMUAN #8 — SEDANG: Tidak Ada Logging/Audit Trail pada API

**Lokasi:** `app/Http/Middleware/VerifyApiKey.php` dan `VerifySaktiApiKey.php`
**CVSS:** 5.3 (Medium)

**Masalah:**
Middleware tidak mencatat percobaan autentikasi — baik yang berhasil maupun yang gagal.

**Dampak:**
- Tidak bisa mendeteksi percobaan brute force
- Tidak bisa melakukan forensik jika terjadi insiden keamanan
- Tidak ada jejak audit untuk compliance

**Rekomendasi:**
```php
// VerifyApiKey.php
public function handle(Request $request, Closure $next)
{
    $apiKey = $request->header('X-API-KEY');
    $clientIp = $request->ip();

    if (!$apiKey || !hash_equals(config('services.sipandu_api_key'), $apiKey)) {
        \Log::warning('API Authentication Failed', [
            'ip'        => $clientIp,
            'endpoint'  => $request->path(),
            'timestamp' => now()->toIso8601String(),
        ]);
        return response()->json([...], 401);
    }

    \Log::info('API Authentication Success', [
        'ip'        => $clientIp,
        'endpoint'  => $request->path(),
        'timestamp' => now()->toIso8601String(),
    ]);

    return $next($request);
}
```

---

### TEMUAN #9 — SEDANG: Tidak Ada CORS Configuration

**Lokasi:** Konfigurasi aplikasi
**CVSS:** 5.0 (Medium)

**Masalah:**
Tidak ditemukan konfigurasi CORS (Cross-Origin Resource Sharing) yang terdefinisi untuk API endpoints.

**Dampak:**
- Jika API diakses dari browser frontend yang berbeda origin, request akan diblokir oleh CORS policy
- Jika CORS diatur terlalu longgar (`*`), semua origin dapat mengakses API

**Rekomendasi:**
Buat file `config/cors.php` atau tambahkan middleware CORS khusus yang hanya mengizinkan origin yang terautentikasi.

---

### TEMUAN #10 — SEDANG: HTTP tanpa HTTPS

**Lokasi:** `.env:5` — `APP_URL=http://localhost`
**CVSS:** 5.0 (Medium)

**Masalah:**
- `APP_URL` dikonfigurasi dengan HTTP, bukan HTTPS
- API Key dikirim dalam plaintext melalui jaringan
- TLS/SSL tidak diaktifkan pada local development server

**Dampak:**
- API Key dapat ditangkap oleh attacker pada jaringan yang sama (MITM)
- Data sensitif yang ditransmisikan dapat dibaca

**Rekomendasi:**
1. Gunakan HTTPS di produksi (wajib)
2. Aktifkan TLS pada server
3. Gunakan HSTS (HTTP Strict Transport Security)

---

### TEMUAN #11 — RENDAH: API Key Tercantum dalam `.env` sebagai Plaintext

**Lokasi:** `.env:70,73`
**CVSS:** 3.5 (Low)

**Masalah:**
```
SAKTI_API_KEY=SaktiSipandu_S3cr3t_2026!
API_KEY_SIPANDU=KunciRahasiaSipandu2026!
```

API key disimpan dalam bentuk plaintext di file `.env`.

**Catatan:** Ini adalah praktik umum di Laravel, namun tetap memiliki risiko. Pastikan:
- `.env` tidak masuk ke version control (cek `.gitignore`)
- File permissions diketatkan
- Gunakan encrypted env untuk produksi jika memungkinkan

**Rekomendasi:**
1. Pastikan `.env` ada di `.gitignore`
2. Gunakan Laravel encrypted values untuk production
3. Pertimbangkan penggunaan vault (HashiCorp Vault, AWS Secrets Manager)

---

### TEMUAN #12 — RENDAH: `.env.example` Tidak Lengkap

**Lokasi:** `.env.example`
**CVSS:** 2.0 (Low)

**Masalah:**
File `.env.example` tidak memuat placeholder untuk variabel API key:
- `API_SECRET_KEY` atau `API_KEY_SIPANDU` — tidak ada
- `SAKTI_API_KEY` — tidak ada
- `SAKTI_ENDPOINT` — tidak ada

**Dampak:**
- Developer baru tidak mengetahui variabel environment yang diperlukan
- Deployment ke environment baru berisiko gagal karena variabel terlupakan

**Rekomendasi:**
Tambahkan ke `.env.example`:
```env
# ──────────────────────────────────────────────────
# API KEY CONFIGURATION
# ──────────────────────────────────────────────────
API_KEY_SIPANDU=your-sipandu-api-key-here
SAKTI_API_KEY=your-sakti-api-key-here
SAKTI_ENDPOINT=http://sakti.example.com/api/v1/sakti/aset
```

---

## HASIL PENGUJIAN POSTMAN (ANALISIS)

### Pengujian: `GET /api/aset-tetap/master?X-API-KEY=KunciRahasiaSipandu2026!`

| Aspek | Status | Catatan |
|-------|--------|---------|
| URL & Endpoint | BENAR | Endpoint terdaftar di `routes/api.php` |
| HTTP Method | BENAR | GET sesuai untuk penarikan data |
| API Key dikirim sebagai | **SALAH** | Query parameter, seharusnya Header |
| Middleware validation | **RAGU** | Tergantung env variable resolution |
| Response format | BENAR | JSON dengan status dan data |

### Cara Pengujian yang Benar di Postman:

```
1. Buka Postman
2. Buat Request baru
3. Method: GET
4. URL: http://127.0.0.1:8000/api/aset-tetap/master

5. Klik tab "Headers" (bukan "Params")
6. Tambahkan:
   Key:   X-API-KEY
   Value: KunciRahasiaSipandu2026!

7. Klik Send
```

**Yang seharusnya terjadi:**
- Tanpa header → Response 401: `"Unauthorized. API Key tidak valid atau tidak ditemukan."`
- Dengan header yang benar → Response 200: `{"status": "success", "data": {...}}`

---

## PETA ALUR AUTENTIKASI

```
┌──────────────────────────────────────────────────────────────┐
│                    ALUR REQUEST API                           │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Client (SAKTI)                                              │
│      │                                                       │
│      │  1. Kirim request dengan header X-API-KEY             │
│      │     GET /api/aset-tetap/master                        │
│      │     Headers: { X-API-KEY: <secret_key> }              │
│      │                                                       │
│      ▼                                                       │
│  ┌────────────────────┐                                      │
│  │   VerifyApiKey     │                                      │
│  │   Middleware        │                                      │
│  │                     │                                      │
│  │  env('API_SECRET_KEY') ←── BUG #1: variabel salah        │
│  │        vs           │                                      │
│  │  $request->header() │                                      │
│  └────────┬───────────┘                                      │
│           │                                                   │
│     ┌─────┴─────┐                                            │
│     │           │                                             │
│   COCOK     TIDAK COCOK                                      │
│     │           │                                             │
│     ▼           ▼                                             │
│  Controller   401 Error                                      │
│  ↓              {                                            │
│  Return         "status": "error",                           │
│  JSON Data      "message": "Unauthorized..."                 │
│               }                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## REKOMENDASI PERBAIKAN PRIORITAS

### PRIORITAS 1 — SEGERA (Minggu ini)

| # | Temuan | Aksi |
|---|--------|------|
| 1 | Variabel env mismatch | Ganti `env('API_SECRET_KEY')` → `config('services.sipandu_api_key')` |
| 2 | `env()` langsung di middleware | Buat config di `config/services.php`, gunakan `config()` |
| 3 | Endpoint pull tanpa auth | Tambahkan `VerifyApiKey` middleware ke route `/sipandu/pull/*` |

### PRIORITAS 2 — PENTING (2 minggu)

| # | Temuan | Aksi |
|---|--------|------|
| 4 | Tidak ada rate limiting | Tambahkan `throttle:60,1` middleware |
| 5 | Tidak ada logging | Tambahkan log percobaan auth di middleware |
| 6 | Key via query parameter | Tolak key dari query param, wajib header |

### PRIORITAS 3 — RENCANA (Bulan ini)

| # | Temuan | Aksi |
|---|--------|------|
| 7 | Tidak ada rotasi key | Rancang mekanisme key rotation di database |
| 8 | HTTP tanpa HTTPS | Konfigurasi SSL/TLS di server produksi |
| 9 | Tidak ada CORS config | Definisikan CORS policy |
| 10 | `.env.example` tidak lengkap | Tambahkan variabel API key |

---

## CONTOH KODE PERBAIKAN LENGKAP

### 1. `config/services.php` — Tambahkan konfigurasi API key

```php
<?php

return [
    // ... config lainnya ...

    'sipandu_api_key' => env('API_KEY_SIPANDU'),
    'sakti_api_key'   => env('SAKTI_API_KEY'),
    'sakti_endpoint'  => env('SAKTI_ENDPOINT'),
];
```

### 2. `app/Http/Middleware/VerifyApiKey.php` — Versi perbaikan

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        // Tolak key yang dikirim via query parameter
        if ($request->query('X-API-KEY')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API Key harus dikirim melalui Header HTTP (X-API-KEY), bukan Query Parameter.'
            ], 400);
        }

        $apiKey = $request->header('X-API-KEY');
        $validKey = config('services.sipandu_api_key');

        // Validasi: key harus ada dan cocok (timing-safe comparison)
        if (!$apiKey || !$validKey || !hash_equals($validKey, $apiKey)) {
            Log::warning('API Auth Failed', [
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. API Key tidak valid atau tidak ditemukan.'
            ], 401);
        }

        Log::info('API Auth Success', [
            'ip'       => $request->ip(),
            'endpoint' => $request->path(),
            'time'     => now()->toIso8601String(),
        ]);

        return $next($request);
    }
}
```

### 3. `app/Http/Middleware/VerifySaktiApiKey.php` — Versi perbaikan

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifySaktiApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey  = $request->header('X-API-KEY');
        $envKey  = config('services.sakti_api_key');

        if (!$apiKey || !$envKey || !hash_equals($envKey, $apiKey)) {
            Log::warning('SAKTI API Auth Failed', [
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. API Key Sakti tidak valid atau tidak ditemukan di Headers.'
            ], 401);
        }

        return $next($request);
    }
}
```

### 4. `routes/api.php` — Tambahkan rate limiting

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenarikanDataController;
use App\Http\Middleware\VerifyApiKey;

Route::middleware([VerifyApiKey::class, 'throttle:60,1'])->group(function () {
    Route::prefix('aset-tetap')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterAssetTetap']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukAssetTetap']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarAssetTetap']);
    });

    Route::prefix('persediaan')->group(function () {
        Route::get('/master', [PenarikanDataController::class, 'getMasterPersediaan']);
        Route::get('/transaksi-masuk', [PenarikanDataController::class, 'getMasukPersediaan']);
        Route::get('/transaksi-keluar', [PenarikanDataController::class, 'getKeluarPersediaan']);
    });
});
```

### 5. `routes/web.php` — Amankan endpoint pull

```php
// SEBELUM (TIDAK AMAN)
Route::prefix('sipandu/pull')->group(function () {
    Route::get('/aset-tetap', [SaktiPullController::class, 'syncAsetTetap']);
    Route::get('/persediaan', [SaktiPullController::class, 'syncPersediaan']);
});

// SESUDAH (AMAN)
Route::prefix('sipandu/pull')->middleware([VerifyApiKey::class])->group(function () {
    Route::get('/aset-tetap', [SaktiPullController::class, 'syncAsetTetap']);
    Route::get('/persediaan', [SaktiPullController::class, 'syncPersediaan']);
});
```

---

## CHECKLIST VERIFIKASI PASCA-PERBAIKAN

- [ ] `config('services.sipandu_api_key')` mengembalikan nilai dari `.env`
- [ ] Request tanpa header X-API-KEY → Response 401
- [ ] Request dengan header X-API-KEY yang salah → Response 401
- [ ] Request dengan query parameter `?X-API-KEY=...` → Response 400
- [ ] Request dengan header X-API-KEY yang benar → Response 200
- [ ] Jalankan `php artisan config:cache` lalu ulangi test di atas
- [ ] Rate limiting aktif — 61 request dalam 1 menit → Response 429
- [ ] Log percobaan auth tercatat di `storage/logs/laravel.log`
- [ ] Endpoint `/sipandu/pull/*` memerlukan autentikasi
- [ ] `.env.example` memuat semua variabel API key

---

## LAMPIRAN: FILE YANG TERLIBAT

| File | Peran |
|------|-------|
| `app/Http/Middleware/VerifyApiKey.php` | Middleware validasi API key SIPANDU |
| `app/Http/Middleware/VerifySaktiApiKey.php` | Middleware validasi API key SAKTI |
| `routes/api.php` | Route definition untuk endpoint API |
| `routes/web.php` | Route definition untuk web + API hybrid |
| `.env` | Konfigurasi environment variables |
| `.env.example` | Template environment variables |
| `app/Http/Controllers/PenarikanDataController.php` | Controller penyedia data |
| `app/Http/Controllers/Api/SaktiPullController.php` | Controller penarikan data dari SAKTI |
| `app/Http/Controllers/Api/SaktiProviderController.php` | Controller penyedia data dari SAKTI |
| `bootstrap/app.php` | Middleware registration |
| `config/services.php` | **Belum ada konfigurasi API key — perlu ditambahkan** |

---

*Dokumen ini dihasilkan dari audit kode statis (SAST) terhadap kode sumber proyek SIPANDU.*
*Audit dilakukan pada tanggal 14 September 2026.*
