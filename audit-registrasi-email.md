# AUDIT REGISTRASI PENGGUNA — PENAMBAHAN FIELD EMAIL & STRATEGI VALIDASI

**Proyek:** Sistem Informasi Manajemen BMN (SIPANDU) — BPMP Provinsi Gorontalo
**Tanggal Audit:** 02 Oktober 2026
**Scope:** Alur registrasi & pembuatan akun pengguna, kesiapan kolom `email`, dan rekomendasi validasi email
**Metode:** Read-only audit kode (tidak mengubah file), verifikasi via grep + review migration/controller/view

---

## RINGKASAN EKSEKUTIF

| Aspek | Status Saat Ini |
|---|---|
| Kolom `email` di tabel `users` | ✅ Sudah ada — `VARCHAR(255) NULLABLE UNIQUE` |
| Field email di form registrasi publik | ❌ **Tidak ada** (`auth/registrasi.blade.php`) |
| Email wajib? | ❌ Opsional (rule `nullable`) di semua jalur yang memvalidasi |
| Validasi format | ⚠️ Hanya rule `email` Laravel, tanpa `max`, tanpa normalisasi, tanpa DNS check |
| Verifikasi email | ❌ Tidak ada (`email_verified_at` tidak pernah diisi) |
| Login pakai email? | ❌ Login 100% berbasis `username` |
| Infrastruktur kirim email | ❌ `MAIL_MAILER=log`, tidak ada Mailable/Notification |
| Risiko penyerta di jalur registrasi | 🔴 1 kritis (escalation `role=superadmin`), beberapa bug route/UI |

**Kesimpulan:** Kolom `email` di database sebenarnya **sudah siap**. Yang kurang adalah (1) input email di form, (2) aturan validasi yang konsisten & ketat, (3) keputusan strategi verifikasi, dan (4) pro-tips normalisasi agar `unique` bekerja benar.

---

## 1. KONDISI SAAT INI (TEMUAN AUDIT KODE)

### 1.1 Struktur tabel `users`

`database/migrations/0001_01_01_000000_create_users_table.php`

| Baris | Kolom | Tipe | Catatan |
|---|---|---|---|
| :16 | `username` | VARCHAR(255) UNIQUE NOT NULL | Basis login |
| **:18** | **`email`** | **VARCHAR(255) UNIQUE NULLABLE** | Sudah ada |
| :19 | `email_verified_at` | TIMESTAMP NULL | Ada tapi tidak pernah dipakai |
| :20 | `nomor_telepon` | VARCHAR(255) NULL | Dipakai notifikasi WhatsApp (Fonnte) |
| :21 | `password` | VARCHAR(255) NOT NULL | Cast `hashed` di model |
| :22-31 | `role` | ENUM 8 nilai, default `pegawai` | |
| :32-37 | `nip`, `jabatan`, `unit_kerja_id`, `is_active` | — | `unit_kerja_id` tanpa FK |
| migration 2026_07_27 | `status` | ENUM `pending/approved/rejected`, default **`approved`** | `rejected` tak pernah dipakai |

Semua kolom untuk penambahan email **sudah tersedia di skema** — tidak ada migration baru yang wajib dibuat (hanya perlu membuat `email` *required* jika diinginkan, lihat §3).

### 1.2 Empat jalur pembuatan akun — ketidakkonsistenan validasi email

| # | Jalur | File:Baris | Validasi email saat ini |
|---|---|---|---|
| 1 | Registrasi publik `POST /daftar` | `app/Http/Controllers/RegisterController.php:32-67` | **TIDAK ADA rule email** (email = NULL) |
| 2 | Registrasi oleh Superadmin `POST /register` | `app/Http/Controllers/AuthController.php:225-234` | `nullable\|email\|unique:users,email` — opsional |
| 3 | Manajemen User `POST /superadmin/pengguna` | `app/Http/Controllers/SuperadminController.php:51-75` | `nullable\|email\|unique:users,email` — opsional |
| 4 | Update user `PUT/PATCH` | `SuperadminController.php:77-104` | `nullable\|email\|unique:users,email` + `ignore` diri |
| 5 | Seeder | `database/seeders/UserSeeder.php:26-129` | Semua akun punya email |

> ⚠️ **Kesimpulan:** tidak ada satu pun jalur yang mewajibkan email. Tidak ada `max:255`, tidak ada normalisasi (lowercase/trim), tidak ada `email:rfc,dns`. `unique` di MySQL (collation case-insensitive) berarti `Budi@X.com` dan `budi@x.com` dianggap sama.

### 1.3 Form registrasi publik — field saat ini

`resources/views/auth/registrasi.blade.php` (309 baris)

| Field | Baris | Wajib (server) | `required` di HTML |
|---|---|---|---|
| `name` | :136 | ya | ❌ |
| `nip` | :147 | ya (`RegisterController:34`) | ❌ |
| `username` | :158 | ya | ❌ |
| `password` | :169 | ya (min 6) | ❌ |
| `password_confirmation` | :190 | ya | ❌ |
| `nomor_telepon` | :206 | ya | ✅ |
| `unit_kerja_id` | :218 | opsional | ❌ |
| `role` | :235 | ya (7 opsi, tanpa `superadmin`) | ❌ |
| **`email`** | **—** | **—** | **TIDAK ADA FIELD** |

### 1.4 Kondisi akun terkait email

- **Email read-only di semua halaman profil** — user tidak bisa mengubah email sendiri (`auth/profile.blade.php:423-424` + 7 view `pengaturan_akun`; `AuthController@updateProfile:144-155` tidak menyimpan email).
- **Tidak ada infrastruktur mail** — `app/Mail` & `app/Notifications` tidak ada, `MAIL_MAILER=log`, nol pemanggilan `Mail::`/`Notification::`. Notifikasi saat ini melalui **WhatsApp (Fonnte)** + queue database.
- **Login username-only** — `AuthController.php:71` `User::where('username', ...)`; input email tidak ada di `login.blade.php`.

### 1.5 Temuan risiko penyerta di jalur registrasi (konteks audit)

| ID | Severity | Temuan | Lokasi |
|---|---|---|---|
| R-1 | 🔴 Kritis | Registrasi publik menerima `role=superadmin` dan langsung `approved` → escalation privilege | `RegisterController.php:45-49,70-73` |
| R-2 | 🔴 Tinggi | Nama route `register` duplikat (`GET /daftar` & `POST /register`) → tombol "Daftar" di UI mengarah salah | `routes/web.php:116,148` |
| R-3 | 🟠 Menengah | `GET /register` merujuk `auth.register` yang tidak ada file-nya | `routes/web.php:145` |
| R-4 | 🟠 Menengah | Edit user dari UI mustahil (route `.../edit` tidak ada; `openEditModal` dead code) | `manajemen_user.blade.php:235,405` |
| R-5 | 🟠 Menengah | Tombol toggle status tidak match route (`POST .../toggle` vs `PATCH .../toggle-status`) | `manajemen_user.blade.php:242` |
| R-6 | 🟡 Rendah | Password min tidak konsisten: registrasi publik & tamu user `min:6`, lainnya `min:8` | `RegisterController:42`, `SuperadminController:57` |

---

## 2. FIELD APA SAJA YANG DIBUTUHKAN

### 2.1 Di database — mayoritas sudah ada

| Kolom | Status | Aksi yang dibutuhkan |
|---|---|---|
| `users.email` VARCHAR(255) UNIQUE | ✅ Ada | Jika ingin **wajib**: migration `->change()` → `nullable(false)` (perbarui dulu data lama yang NULL) |
| `users.email_verified_at` | ✅ Ada | Diisi hanya jika memakai alur verifikasi email (lihat §4) |
| `users.nomor_telepon` | ✅ Ada | Tetap diperlukan (WA notifikasi) — email bersifat *pelengkap* notifikasi |
| `password_reset_tokens.email` | ✅ Ada | Siap untuk fitur lupa-password berbasis email |

### 2.2 Di form registrasi publik (`auth/registrasi.blade.php`)

Field yang **ditambahkan/diubah**:

| # | Field | Atribut yang dibutuhkan |
|---|---|---|
| 1 | `email` | `type="email"`, **`required`**, `maxlength="255"`, `placeholder="nama@contoh.go.id"`, `autocomplete="email"`, posisi setelah `username` |
| 2 | `email_confirmation` *(opsional)* | `type="email"`, `required`, untuk form konfirmasi email dua kali |
| 3 | `username` | tambahkan `required` (server sudah wajib) |
| 4 | `nip` | tambahkan `required` (server sudah wajib) |
| 5 | `password` | samakan hint "Minimal 8 karakter" dengan server (putuskan `min:6` atau `min:8`) |
| 6 | `unit_kerja_id` | putuskan wajib/tidak (label `*` saat ini, server `nullable`) |

### 2.3 Di form manajemen user (`superadmin/manajemen_user.blade.php`)

| # | Field | Aksi |
|---|---|---|
| 1 | `email` (baris :312) | tambah `required`, `maxlength="255"`, `pattern` opsional |
| 2 | Tombol Edit & `openEditModal()` | perbaiki route baru `GET /superadmin/pengguna/{id}/edit` agar email bisa diedit |
| 3 | Tabel | tampilkan kolom email |

### 2.4 Di validasi server (4 tempat)

| # | File | Rule yang dibutuhkan |
|---|---|---|
| 1 | `RegisterController.php:32` | `['required','email','max:255', 'unique:users,email']` |
| 2 | `AuthController.php:228` | ubah `nullable` → `required` |
| 3 | `SuperadminController.php:56` | ubah `nullable` → `required` |
| 4 | `SuperadminController.php:82` | ubah `nullable` → `required` + `Rule::unique('users','email')->ignore($user->id)` |

---

## 3. CARA VALIDASI EMAIL YANG DIREKOMENDASIKAN

### 3.1 Aturan validasi akhir (server-side, konsisten di semua jalur)

```php
'email' => [
    'required',
    'email',                          // format dasar (RFC 5321 via egulias)
    'max:255',                        // wajib disesuaikan dengan kolom DB
    Rule::unique('users', 'email'),   // unik; lakukan ignore($user->id) saat update
],
```

**Opsional diperketat (nilai tambah):**
```php
'email' => ['email:rfc,dns'],        // cek DNS MX domain — hati-hati: lambat di produksi
```

### 3.2 Normalisasi sebelum disimpan (WAJIB, agar `unique` benar)

Tambahkan mutator di `app/Models/User.php`:

```php
protected function email(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtolower(trim($value)),
    );
}
```

Alasan:
- Mencegah duplikasi `Budi@X.com` vs `budi@x.com` (collation MySQL case-insensitive menyamarkan tapi tidak membersihkan).
- Mencegah spasi tersembunyi dari form (`" user@x.com "`).
- Konsisten dengan pola yang sudah dipakai rate-limit login (`Str::lower`, `AuthController.php:62`).

### 3.3 Client-side (HTML5) — lapisan pertama

```html
<input type="email" name="email" required maxlength="255"
       placeholder="nama@contoh.go.id" autocomplete="email"
       pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">
```

> `type="email"` + `required` sudah menempel validasi format browser. `pattern` opsional untuk memaksa domain instansi/format tertentu. **Ingat:** client-side hanya UX — keamanan tetap di server.

### 3.4 Keputusan strategi verifikasi email

Karena infrastruktur mail saat ini **belum ada** (`MAIL_MAILER=log`, tanpa Mailable), pilih salah satu:

| Opsi | Deskripsi | Cocok untuk | Biaya |
|---|---|---|---|
| **A. Tanpa verifikasi** (paling sederhana) | Isi `email` saat registrasi; akun dikunci alur `status=pending` seperti sekarang (superadmin approve via WhatsApp). `email_verified_at` dibiarkan NULL | Alur saat ini — verifikasi peran sudah lewat `status=pending` | Paling kecil |
| **B. Verifikasi saat pendaftaran** | Kirim link verifikasi ke email; `mustBeVerified` → blokir login sampai `email_verified_at` terisi | Perlu pengiriman email — harus tambah Mailable + SMTP/API mail | Tinggi |
| **C. Verifikasi ganda `status` + email** | `pending` sampai superadmin approve **dan** user klik link verifikasi | Kebutuhan keamanan tertinggi | Tinggi |

**Rekomendasi:** Mulai dengan **Opsi A** untuk konsistensi dengan alur `status=pending` yang sudah ada, dan **siapkan Opsi B** (buat `SendEmailVerificationNotification` Mailable) saat kebutuhan pengiriman email resmi muncul.

### 3.5 Checklist implementasi (langkah-langkah)

```text
[1] Migration: 
    - (opsional) email menjadi required:
      DB::table('users')->whereNull('email')->update(['email' => ...])  // backfill dulu
      Schema::table('users', fn($t) => $t->string('email')->nullable(false)->change());
[2] Model User:
    - tambah mutator lowercase+trim untuk email
[3] Validasi server (4 jalur):
    - RegisterController : required|email|max:255|unique
    - AuthController     : required|email|max:255|unique
    - SuperadminController store & update : required|email|max:255|unique(+ignore)
[4] View registrasi publik: tambah field email (+ required, maxlength, autocomplete)
[5] View manajemen user : tambah required pada field email, tampilkan kolom email di tabel,
    perbaiki tombol Edit (route GET /superadmin/pengguna/{id}/edit)
[6] Login (opsional): dukung login via email — ubah pencarian menjadi
    User::where('username', $in)->orWhere('email', $in)
[7] Uji: 
    - daftar dengan email valid → tersimpan lowercase
    - email duplikat (kapital berbeda) → ditolak
    - email invalid → ditolak
    - email >255 → ditolak
```

### 3.6 Hal yang HARUS DIPERBAIKI bersamaan (dari §1.5)

> Audit menemukan **escalation privilege pada registrasi publik** (R-1). Saat menambahkan field email, wajib sekaligus di-hardening:
> 1. Hapus `superadmin` dari `Rule::in` di `RegisterController.php:45-49`.
> 2. Paksa `role` publik menjadi salah satu dari 7 role non-superadmin (seperti opsi select form).
> 3. Perbaiki tabrakan nama route `register` (R-2) agar tombol "Daftar" benar-benar membuka `registrasi.blade.php`.

---

## 4. RENCANA KERJA (URUTAN PRIORITAS)

| Prioritas | Aksi | Impact | Effort |
|---:|---|---|---|
| P0 | Fix escalation privilege role=superadmin (R-1) | 🛑 Keamanan | Rendah |
| P0 | Tambah field email + validasi `required` di seluruh 4 jalur | Fitur utama | Rendah |
| P1 | Normalisasi email (lowercase/trim) di model | Data quality | Rendah |
| P1 | Perbaiki route edit user & tampilkan email di tabel | Usability | Sedang |
| P2 | Dukung login via email (opsional) | UX | Rendah |
| P2 | Verifikasi email (Opsi B) + infrastruktur mail | Pengiriman email | Tinggi |
| P3 | `email:rfc,dns` + rekap konsistensi password min | Hardening | Rendah |

---

## 5. JAWABAN SINGKAT ATAS PERTANYAAN UTAMA

**Q1: Field apa saja yang dibutuhkan untuk penambahan email?**
Detail:
- **Database:** cukup kolom `email` (sudah ada, jadikan `required` via migration + backfill). Kolom `email_verified_at` tersedia bila memakai verifikasi.
- **Form publik:** tambah 1 input `email` (wajib, `maxlength=255`).
- **Validasi server:** dipasang konsisten di 4 jalur (publik, register superadmin, tambah user, update user).
- **Model:** mutator normalize (lowercase + trim).

**Q2: Bagaimana validasi email sebaiknya dilakukan?**
Detail:
1. `required|email|max:255|unique:users,email` di semua jalur server.
2. Normalisasi `strtolower(trim(...))` sebelum simpan via mutator model.
3. Lapisan HTML5 (`type=email required maxlength`) sebagai UX, bukan keamanan.
4. Karena belum ada infrastruktur mail: mulai dengan **tanpa verifikasi** (kontrol via `status=pending`), siapkan Mailable bila dibutuhkan.
5. `email:rfc,dns` opsional untuk produksi — catatan performa.

---

*Dokumen audit ini bersifat read-only — tidak ada file aplikasi yang diubah selama proses audit.*