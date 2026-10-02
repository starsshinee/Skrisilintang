# Audit Sistem Notifikasi Fonnte (Registrasi → Superadmin & Verifikasi Akun)

**Proyek:** SIPANDU – BPMP Gorontalo  
**Tanggal Audit:** 02 Oktober 2026  
**Jenis Audit:** Read-only (tidak ada file diubah)  
**Path Repo:** `C:\laragon\www\backupwebskripsifix\Skrisilintang`

## 1. RINGKASAN EKSEKUTIF

Gejala yang dilaporkan:
> Job `App\Jobs\SendFonnteNotification` berjalan `RUNNING → DONE` berulang kali, **tapi notifikasi WhatsApp tidak pernah terkirim**. Tidak ditemukan entri di `failed_jobs`, dan tidak ada baris log terkait Fonnte di `storage/logs/laravel.log`.

**Penyebab utama (root causes):**

1. **Token NULL saat `config:cache` aktif** (`FonnteService.php:20` memakai `env()` di luar file config). Ketika `bootstrap/cache/config.php` ter-cache, `.env` tidak dimuat → `env('FONNTE_TOKEN')` = `NULL`.
2. **Trailing space pada token** di `.env:66` (`FgYy59735cRG6N95Q42T<spasi>`) — menyebabkan header Authorization tidak valid.
3. **Bug arsitektural “error dipelan” (silent failure)** — `FonnteService` mengembalikan `false` saat gagal (HTTP non-2xx / exception), tapi `SendFonnteNotification::handle()` **membuang nilai balik tersebut dan tidak me-throw**. Akibatnya job selalu selesai normal (`DONE`), `$tries = 3` & `backoff()` tidak pernah terpicu, dan kegagalan tidak pernah masuk `failed_jobs`.

Dengan kata lain: **seluruh kegagalan diperlakukan sebagai sukses oleh aplikasi.** Inilah alasan kenapa job `RUNNING → DONE` tapi pesan tidak terkirim, tanpa ada log atau entri failed_jobs.

---

## 2. ANALISIS FILE

### 2.1 `app/Services/FonnteService.php`

| Baris | Kode | Analisis |
|---|---|---|
| 16–37 | `sendMessage(string $target, string $message): bool` | Method mengembalikan `bool` (true/false). Tidak ada logging sukses, tidak ada validasi token/target. |
| 20 | `$token = env('FONNTE_TOKEN');` | **Kritikal.** `env()` dipanggil di dalam service (bukan di `config/services.php`). Jika `php artisan config:cache` dijalankan (saat ini `bootstrap/cache/config.php` ada), `.env` tidak dimuat → `$token = NULL`. Header `Authorization: <NULL>` → API Fonnte merespons `401` (`{"status": false, "reason": "token invalid"}`). |
| 22–25 | `Http::withHeaders(['Authorization' => $token])->asJson()->post(...)` | Tidak ada `timeout()`, `connectTimeout()`, `retry()` HTTP. Tidak ada `acceptJson()`. Format body JSON OK untuk Fonnte (mereka menerima JSON atau form-data). |
| 27 | `if ($response->successful()) { ... }` | **Bug validasi.** Hanya mengecek **HTTP status code 2xx**. Fonnte bisa mengembalikan HTTP `200 OK` dengan JSON `{"status": false, "reason": "..."}` (device disconnected, quota habis, target invalid, dll.) — kondisi ini akan dianggap `successful()` dan masuk ke `return true` (pesan tidak terkirim tapi dianggap sukses). |
| 28 | `return true;` | Tidak ada logging `requestid`, `detail`, `target`. Tidak bisa dibedakan “queued” vs “gagal”. |
| 31 | `Log::error('Fonnte Error: ' . $response->body());` | Hanya log saat HTTP non-2xx. Saat HTTP 200 + `status:false`, tidak ada log error (masuk `return true`). |
| 32 | `return false;` | Error **dipelan** (ditelan aplikasi). |
| 34–36 | `catch (\Exception $e) { Log::error(...); return false; }` | Semua exception (koneksi timeout, DNS, SSL) juga dikembalikan `false` tanpa detail konteks (target, pesan panjang, dll.). |

**Kesimpulan Service:** Tidak mengecek flag JSON `status` milik Fonnte. Seluruh kegagalan (termasuk `status:false` dengan HTTP 200) bisa lolos sebagai “sukses”.

### 2.2 `app/Jobs/SendFonnteNotification.php`

| Baris | Kode | Analisis |
|---|---|---|
| 13 | `implements ShouldQueue` | Benar. |
| 24 | `public $tries = 3;` | Tidak pernah terpakai karena `handle()` tidak me-throw saat service mengembalikan `false` (lihat baris 41). |
| 30 | `public $timeout = 30;` | Timeout proses worker (PHP max execution), **bukan** HTTP request timeout. Tidak melindungi call HTTP yang hang. |
| 38–47 | `public function handle(): void` | `FonnteService::sendMessage(...)` dipanggil, **nilai kembalian dibuang total** (`baris 41` tidak ada assignment/if). |
| 41 | `FonnteService::sendMessage($this->target, $this->message);` | **Kritikal.** Karena service mengembalikan `false` saat gagal, baris ini tidak me-throw exception → `handle()` selesai tanpa error → job berakhir `DONE`, dihapus dari `jobs`. Tidak masuk `failed_jobs`, tidak ada retry. `$tries=3` dan `backoff()` menjadi tidak relevan. |
| 42–47 | `catch (\Exception $e) { Log::error(...); throw $e; }` | Hanya exception yang dilempar **langsung** oleh service yang bisa memicu retry/failed. Karena service saat ini **tidak melempar**, blok ini jarang terpicu. |
| 54–57 | `public function backoff(): int { return 10; }` | Ada, tapi tidak berguna selama handle tidak me-throw. |

**Kesimpulan Job:** Arsitektur retry/job failure **tidak aktif** karena service tidak melempar exception saat kegagalan API.

### 2.3 Pemanggilan saat Registrasi

`app/Http/Controllers/RegisterController.php:87–109`

| Baris | Analisis |
|---|---|
| 89–94 | Filter penerima: `role = 'superadmin'` AND `whereNotNull('nomor_telepon')` AND `nomor_telepon != ''`. Tidak memfilter `is_active` (superadmin nonaktif masih bisa dikirimi). Tidak ada validasi/normalisasi format nomor WA (hanya `max:14` di validasi form baris 52). |
| 97–106 | Pesan terformat rapi (bold, emoji) — kompatibel Fonnte. Tidak ada URL aksi (tidak ada link login/dashboard verifikasi). Tidak ada escaping jika nama mengandung karakter khusus. |
| 107 | `\App\Jobs\SendFonnteNotification::dispatch($admin->nomor_telepon, $pesan);` di dalam loop foreach. Tidak pakai `->afterCommit()` (bisa kirim sebelum transaksi commit jika ada). Tidak ada batching/chunking (jumlah superadmin kecil). |
| 70–73, 81–84 | Alur `statusAwal` (pending/approved) berdasarkan role — relevan dengan notifikasi verifikasi. |

### 2.4 Pemanggilan saat Verifikasi Akun

`app/Http/Controllers/SuperadminController.php:131–152`

| Baris | Analisis |
|---|---|
| 133 | `User::findOrFail($id)` — tidak pakai route-model-binding (`destroyPengguna` pakai `User $user`). Minor. |
| 136–138 | Update `status = 'approved'` — langsung tanpa cek idempotensi (bisa dipanggil ulang → notifikasi dikirim berkali-kali). |
| 140 | Hanya cek `!empty($user->nomor_telepon)` — `' '` (spasi) lolos, tidak ada validasi format nomor. |
| 141–145 | Pesan konfirmasi verifikasi jelas, informatif. |
| 148 | `SendFonnteNotification::dispatch($user->nomor_telepon, $pesan);` — tidak ada `->afterCommit()`, tidak ada pengecekan apakah status sebelumnya memang `pending` (idempotensi kurang). |
| 151 | Redirect dengan success meski notifikasi gagal (karena job silent-fail). |

---

## 3. KONFIGURASI & ENV

| Lokasi | Key | Nilai | Analisis |
|---|---|---|---|
| `.env:66` | `FONNTE_TOKEN` | `FgYy59735cRG6N95Q42T<spasi>` | **Kritikal (F2).** Ada trailing space (karakter spasi di akhir). Header Authorization menjadi tidak valid → 401. Panjang string terpotong spasi saat dikirim. |
| `.env:38` | `QUEUE_CONNECTION` | `database` | Duplikat dengan `.env:67`. Tidak berpengaruh (Laravel membaca terakhir/overwrite), tapi kurang bersih. |
| `.env:67` | `QUEUE_CONNECTION` | `database` | Duplikat. |
| `.env:5` | `APP_URL` | `http://localhost` | Tidak relevan untuk notifikasi keluar (Fonnte outbound). Bisa bermasalah jika nanti pakai webhook (butuh HTTPS/public URL). |
| `.env.example:66` | `FONNTE_TOKEN` | (kosong) | Kurang dokumentasi (cara dapat token, format). |
| `.env.example:38,67` | `QUEUE_CONNECTION` | duplikat | Bisa dibersihkan. |
| `config/services.php` | — | **Tidak ada entri `fonnte`** | Konsekuensi dari pemakaian `env()` langsung (F1). Sebaiknya pindah ke config agar aman untuk `config:cache`. |
| `bootstrap/cache/config.php` | — | **Ada (26.007 byte)** | Terbukti config ter-cache → `env()` di runtime (setelah bootstrap cache) akan mengembalikan `NULL` untuk variabel yang tidak di-load ulang. Ini menjelaskan mengapa token bisa “hilang” di lingkungan ter-cache. |
| `config/queue.php` | — | Default OK (`database` driver tersedia). Tabel `jobs`, `job_batches`, `failed_jobs` sudah ada (`0001_01_01_000002_create_jobs_table.php`). |

**Kesimpulan Env:** Dua masalah token (NULL saat cache + trailing space). Infrastruktur queue sudah siap.

---

## 4. EVIDENSI LOG & DATABASE

| Sumber | Temuan | Interpretasi |
|---|---|---|
| `storage/logs/laravel.log` | **0 baris** yang mengandung `Fonnte`, `fonnte`, `SendFonnte`, `api.fonnte.com`, `Unauthorized`, `token invalid`, `device disconnected` | Sesuai ekspektasi jika error hanya di-log saat HTTP non-2xx (`baris 31`) tapi response yang terjadi adalah 401/`status:false` dengan HTTP 200? Atau lebih mungkin karena token NULL + response 401 non-2xx → seharusnya ter-log. Bisa jadi job dijalankan saat kondisi berbeda atau log sudah ter-rotate. Namun secara kode: jalur error non-2xx **seharusnya** mencatat `response->body()`. |
| `jobs` (DB) | 0 entri (kosong) | Worker memproses job dan menghapusnya setelah selesai (baik sukses maupun “silent fail”). |
| `failed_jobs` (DB) | 0 entri | **Bukti kuat silent-failure (F3).** Jika ada exception dilempar saat gagal API, job akan masuk `failed_jobs` setelah `$tries` habis. Karena 0 entri → semua job dianggap selesai normal (`DONE`). |

**Kesimpulan:** Tidak ada jejak kegagalan karena kegagalan tidak pernah dilempar sebagai exception.

---

## 5. PEMBAHASAN “RUNNING → DONE tapi tidak terkirim”

Alur yang terjadi saat ini (berdasarkan kode):

1. Registrasi/verifikasi mem-`dispatch` job → masuk tabel `jobs` (status pending)
2. Queue worker menjalankan `SendFonnteNotification::handle()` → status `RUNNING`
3. `FonnteService::sendMessage()` memanggil `env('FONNTE_TOKEN')` → NULL (config cached) → Authorization header invalid
4. Fonnte merespons (kemungkinan) HTTP `401 Unauthorized` dengan body `{"status": false, "reason": "token invalid"}`
5. `$response->successful()` = `false` (HTTP 401 bukan 2xx) → masuk `Log::error('Fonnte Error: ...')` (baris 31) **DAN** `return false` (baris 32)
6. `handle()` menerima return value `false` **tapi tidak dicek** (baris 41 dibuang) → method `handle()` berakhir **tanpa exception**
7. Worker menganggap job **berhasil diselesaikan** → hapus dari `jobs`, tandai `DONE`. **Tidak retry, tidak masuk `failed_jobs`**.

Jadi `RUNNING → DONE` adalah perilaku normal worker untuk job yang selesai tanpa exception — itulah akar masalah silent-failure.

Ditambah trailing space token (F2): bisa membuat response berbeda (401) meski config tidak ter-cache.

---

## 6. REKOMENDASI PERBAIKAN (PRIORITAS)

### P0 – Wajib diperbaiki (memperbaiki kegagalan utama)

| # | Perbaikan | Lokasi | Alasan |
|---|---|---|---|
| 1 | **Pindahkan token ke config**: tambahkan entri `fonnte.token` di `config/services.php`, ubah `FonnteService.php:20` menjadi `config('services.fonnte.token')`. | `config/services.php`, `app/Services/FonnteService.php:20` | Mengatasi F1 (token NULL saat `config:cache`). Praktik Laravel yang benar. |
| 2 | **Trim & validasi token wajib**: `trim((string) config(...))`, jika kosong → `throw RuntimeException('FONNTE_TOKEN kosong. Jalankan config:clear && config:cache')`. | `app/Services/FonnteService.php:19–21` | Mengatasi F2 (trailing space) + fail-fast jika konfigurasi salah. |
| 3 | **Cek flag JSON `status` Fonnte (BUKAN cuma HTTP)**. Setelah dapat response, decode JSON (`$body = $response->json() ?? []`), jika `$response->failed() OR ($body['status'] ?? false) !== true` → **throw RuntimeException** dengan detail `reason/requestid`. | `app/Services/FonnteService.php:22–36` | Mengatasi F4. Ini kunci agar job bisa gagal/retry saat device disconnected/quota habis/token invalid meski HTTP 200. |
| 4 | **Biarkan job me-throw saat gagal**. Ubah return type `bool` → `array` (atau void tapi throw). Saat gagal API, **jangan return `false`**, lempar exception. Dengan ini `$tries=3`, `backoff()`, dan `failed_jobs` akan bekerja kembali. | `app/Services/FonnteService.php`, `app/Jobs/SendFonnteNotification.php:41` | Mengatasi F3 (silent failure). Ini penyebab utama gejala “DONE tapi tidak terkirim”. |

### P1 – Penting untuk observabilitas & stabilitas

| # | Perbaikan | Lokasi | Alasan |
|---|---|---|---|
| 5 | **Tambah logging sukses**: log `Log::info('Fonnte pesan terkirim/queued', ['target'=>..., 'detail'=>..., 'requestid'=>...])` saat berhasil (berdasarkan JSON response). | `app/Services/FonnteService.php:28–30` | Mengatasi F5 (buta total). Bisa diverifikasi lewat `laravel.log`. |
| 6 | **Tambah HTTP timeout & retry**: pakai `->connectTimeout(10)->timeout(20)->retry(3, 1000, fn($e)=>$e instanceof ConnectionException)` + `acceptJson()`. | `app/Services/FonnteService.php:22–26` | Mengatasi F7,F8. Lindungi dari hang network. |
| 7 | **Normalisasi nomor WA** (hapus non-digit, ubah 08→62, handle +62). Validasi sebelum kirim. | `app/Services/FonnteService.php` (method helper) | Mengurangi `target invalid`. Bisa dipakai juga di Register/SuperadminController. |
| 8 | **Tambah `failed()` method di Job** untuk alert/cleanup saat retry habis. | `app/Jobs/SendFonnteNotification.php` | Mengatasi F6. Bisa kirim alert (Slack/Telegram/email) saat notifikasi kritikal gagal total. |
| 9 | **Gunakan `->afterCommit()` saat dispatch** (penting jika ada DB transaction). | `RegisterController.php:107`, `SuperadminController.php:148` | Hindari mengirim notifikasi sebelum data ter-commit. |

### P2 – Peningkatan UX & keamanan

| # | Perbaikan | Lokasi | Alasan |
|---|---|---|---|
| 10 | **Validasi format nomor WA** (regex) di form + controller (bukan cuma `max:14`). | `RegisterController.php:52`, `SuperadminController.php:140` | Cegah `target invalid` sejak input. |
| 11 | **Idempotensi verifikasi akun**: hanya dispatch notifikasi jika `status` sebelumnya `pending` → ubah jadi `update(['status'=>'approved'])` dengan where `status='pending'` atau cek dulu. | `SuperadminController.php:136–138` | Cegah notifikasi berkali-kali jika tombol verifikasi ditekan ulang. |
| 12 | **Hapus duplikat `QUEUE_CONNECTION`** di `.env` & `.env.example`. | `.env:38,67`, `.env.example:38,67` | Kebersihan konfigurasi. |
| 13 | **Tambahkan `connectOnly: false`** (default Fonnte true) agar pesan masuk antrean saat device WhatsApp offline (bukan langsung ditolak). | Payload Fonnte | Banyak kasus “device disconnected” dengan HTTP 200 → butuh flag ini + pengecekan JSON `status`. |

### P3 – Opsional (diagnostik)

| # | Perbaikan | Lokasi | Alasan |
|---|---|---|---|
| 14 | **Bersihkan trailing space token** `.env:66` (hapus spasi akhir), jalankan `php artisan config:clear && php artisan config:cache`. | `.env` | Langkah cepat untuk memperbaiki 401 saat ini. |
| 15 | **Tambahkan test dengan `Http::fake()`** untuk skenario: HTTP 200+status:true, HTTP 200+status:false, HTTP 401, ConnectionException. | `tests/Feature/FonnteNotificationTest.php` (baru) | Mencegah regresi bug silent-failure. |

---

## 7. LANGKAH DIAGNOSTIK CEPAT (untuk verifikasi setelah perbaikan)

Jalankan setelah memperbaiki token + config:

```bash
cd C:\laragon\www\backupwebskripsifix\Skrisilintang

# Bersihkan cache (penting)
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Verifikasi token (pastikan tanpa trailing space, 20 char)
php -r "require 'vendor/autoload.php'; \$app=require 'bootstrap/app.php'; \$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); var_dump(strlen(trim(config('services.fonnte.token') ?? '')));"

# Cek device Fonnte
curl -X GET "https://api.fonnte.com/device" -H "Authorization: $(php -r \"require 'vendor/autoload.php'; \$app=require 'bootstrap/app.php'; \$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo trim(config('services.fonnte.token'));\")"

# Kirim test singkat (form-data, connectOnly false)
curl -X POST "https://api.fonnte.com/send" -H "Authorization: $(php -r \"...\" echo trim(config('services.fonnte.token'));\")" -F "target=082292957469" -F "message=Test SIPANDU $(date +%H:%M:%S)" -F "countryCode=62" -F "connectOnly=false"
```

Response sukses yang diharapkan: `{"status": true, "detail": "success! message in queue", "requestid": ..., "target": ["628..."]}`.

---

## 8. KESIMPULAN

**Penyebab pasti gejala “RUNNING → DONE tapi tidak terkirim”:**

1. **Token NULL (config cache)** + **trailing space** → request invalid (401/ditolak Fonnte)
2. **Service mengembalikan `false` alih-alih melempar exception** → Job `handle()` selesai normal → worker menghapus job sebagai `DONE`, tanpa retry dan tanpa masuk `failed_jobs`

**Rekomendasi terpenting (urutan perbaikan):** **P0 #4 → P0 #3 → P0 #1 → P0 #2**. Artinya: pertama, ubah agar kegagalan **dilempar sebagai exception** (agar retry/failed_jobs bekerja). Kedua, perbaiki validasi JSON `status` Fonnte. Ketiga, pindah `env()` ke `config/services.php`. Keempat, bersihkan trailing space token + clear cache.

Setelah perbaikan P0 dilakukan, job yang gagal API akan benar-benar menjadi `FAILED` (masuk `failed_jobs`) setelah 3 kali retry (sesuai `$tries=3`), dan `laravel.log` akan mencatat detail `reason` + `requestid` dari Fonnte — sehingga bisa dianalisis dengan jelas kenapa notifikasi tidak terkirim.

*Dokumen ini read-only — tidak ada perubahan kode yang dilakukan.*