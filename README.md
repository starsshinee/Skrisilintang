# Sistem Informasi Pendataan dan Monitoring BMN

Sistem Informasi Pendataan dan Monitoring BMN (Barang Milik Negara) adalah aplikasi berbasis web yang dirancang untuk mengelola siklus hidup aset dan barang inventaris instansi secara komprehensif. Aplikasi ini memfasilitasi proses pendataan, peminjaman, pengembalian, mutasi, pelaporan kerusakan, serta dilengkapi notifikasi WhatsApp otomatis dan layanan **REST API Provider** untuk penarikan data oleh pihak ketiga.

Aplikasi ini dibangun menggunakan *framework* **Laravel (PHP)** dengan pendekatan *Full-Stack* (Blade Templates) yang dipercepat menggunakan **Vite**.

## 🚀 Fitur Utama Aplikasi

* **Manajemen BMN Terpadu**: Pengelolaan Aset Tetap, Persediaan, dan Sarpras (Gedung & Kendaraan).
* **Alur Peminjaman & Pengembalian**: Sistem *approval* (persetujuan) berjenjang untuk peminjaman barang, kendaraan, dan gedung.
* **Mutasi & Kerusakan**: Pelaporan kerusakan sarpras dan pengajuan mutasi barang BMN secara sistematis.
* **Laporan & Ekspor**: Cetak laporan transaksi masuk/keluar, peminjaman, dan mutasi dalam format PDF dan Excel.
* **Notifikasi Otomatis (WhatsApp)**: Integrasi dengan **Fonnte API** untuk mengirimkan notifikasi *real-time* kepada pengguna terkait status pengajuan.
* **API Provider Data**: Aplikasi menyediakan layanan endpoint API agar sistem atau aplikasi eksternal dapat melakukan penarikan data BMN dari website ini secara aman (menggunakan sistem API Key).
* **Survei Kepuasan & Buku Tamu**: Modul khusus untuk tamu dan penilaian layanan instansi.

## 👥 Hak Akses Pengguna (*Roles*)

Aplikasi ini mendukung skema multi-pengguna dengan hak akses (*roles*) yang spesifik:

1. **Superadmin**: Mengelola data master, *user*, unit kerja, dan *API Keys*.
2. **Kepala BPMP**: Melihat ringkasan data (*dashboard*) dan laporan lengkap.
3. **Kasubag**: Memberikan persetujuan (*approval*) untuk pengajuan peminjaman dan permintaan persediaan.
4. **Admin Aset Tetap**: Mengelola data aset tetap, transaksi masuk/keluar, peminjaman, dan mutasi.
5. **Admin Persediaan**: Mengelola stok persediaan dan melayani permintaan barang.
6. **Admin Sarpras**: Mengelola data gedung, kendaraan, dan pelaporan kerusakan.
7. **Pegawai**: Mengajukan peminjaman barang/kendaraan, permintaan persediaan, dan mutasi BMN.
8. **Tamu**: Mengakses buku tamu, melihat fasilitas, dan mengisi survei layanan.

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel (PHP)
* **Frontend**: Laravel Blade, Tailwind CSS / Bootstrap, Vite, JavaScript
* **Database**: MySQL
* **Ekspor Dokumen**: DomPDF (PDF), Laravel Excel / PhpSpreadsheet (Excel)
* **Integrasi & API**: Fonnte (WhatsApp Gateway), REST API Provider (Key-based Authentication)

## 💻 Cara Instalasi & Persiapan Lokal (*Development*)

### 1. Prasyarat Sistem

Pastikan sistem operasi Anda sudah terpasang perangkat lunak berikut:

* **PHP** (Minimal versi 8.1 / 8.2)
* **Composer** (Package manager untuk PHP)
* **Node.js** & **npm** (Untuk mengkompilasi aset frontend)
* **MySQL** (XAMPP / Laragon / MySQL Server)
* **Git** (Opsional, jika melakukan *clone* repositori)

### 2. Langkah-langkah Instalasi

**Langkah 1: Kloning Repositori (atau Ekstrak File)**
Buka terminal dan arahkan ke direktori server lokal Anda (misal `htdocs` atau `www`), lalu jalankan:
```bash
git clone <url-repositori-anda>
cd <nama-folder-aplikasi>
```

**Langkah 2: Install Dependensi PHP (Backend)**
Install semua paket Laravel yang dibutuhkan menggunakan Composer:
```bash
composer install
```

**Langkah 3: Install Dependensi JavaScript (Frontend)**
Install *package* NPM dan kompilasi aset (CSS/JS) menggunakan Vite:
```bash
npm install
npm run build
```
*(Catatan: Gunakan `npm run dev` jika Anda sedang mengembangkan/mengedit tampilan).*

**Langkah 4: Konfigurasi Environment**
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` di teks editor Anda dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

**Langkah 5: Generate Application Key**
Hasilkan kunci unik untuk aplikasi Laravel Anda:
```bash
php artisan key:generate
```

**Langkah 6: Migrasi Database dan Seeding**
Jalankan perintah berikut untuk membuat struktur tabel di database MySQL Anda beserta data awal (*dummy/default*):
```bash
php artisan migrate --seed
```

**Langkah 7: Tautkan Storage (*Storage Link*)**
Agar file yang diunggah (dokumen, foto profil, dll) dapat diakses publik:
```bash
php artisan storage:link
```

### 3. Menjalankan Aplikasi

Jalankan server *development* Laravel:
```bash
php artisan serve
```
Aplikasi kini dapat diakses melalui browser pada alamat: 
👉 **http://localhost:8000**

## ⚙️ Konfigurasi Layanan Eksternal & API

### 📱 1. Konfigurasi Notifikasi WhatsApp (Fonnte)

Aplikasi ini menggunakan layanan **Fonnte** untuk mengirimkan notifikasi via WhatsApp. Proses ini menggunakan **Laravel Queue/Jobs** di latar belakang.

**A. Dapatkan Token Fonnte**
- Login ke dashboard [Fonnte](https://fonnte.com/).
- Hubungkan perangkat (scan QR Code) di menu **Device**.
- Salin **Token** dari menu **API**.

**B. Atur Variabel di `.env`**
Tambahkan token tersebut di file `.env` Anda:
```env
FONNTE_TOKEN=masukkan_token_fonnte_anda_di_sini
```

**C. Menjalankan Queue Worker (Wajib)**
Agar notifikasi dapat terkirim, Anda **wajib** menjalankan *queue worker* Laravel. Biarkan terminal ini menyala di latar belakang:
```bash
php artisan queue:work
```
*(Catatan: Di server production/hosting, gunakan **Supervisor** agar worker berjalan secara otomatis dan permanen).*

### 🌐 2. Penggunaan API Provider (Penarikan Data)

Aplikasi ini bertindak sebagai **API Provider** yang mengizinkan sistem/aplikasi eksternal untuk menarik atau mensinkronisasi data BMN dari aplikasi ini. Akses ini diamankan menggunakan validasi API Key.

**Cara Membuat dan Menggunakan API Key:**
1. Login ke aplikasi sebagai **Superadmin**.
2. Masuk ke menu pengelolaan **API Keys**.
3. Klik tombol untuk **Generate API Key** baru untuk pihak ketiga (misalnya untuk sistem terpusat atau aplikasi instansi lainnya).
4. Berikan *API Key* yang dihasilkan kepada pihak pengembang/sistem yang akan menarik data.
5. Pihak ketiga tersebut **wajib** menyertakan API Key ini di dalam Header HTTP Request mereka (misalnya pada header `x-api-key` atau `Authorization`, sesuai implementasi di route middleware API aplikasi ini) setiap kali melakukan *request* penarikan data ke endpoint yang tersedia.

## 🔐 Akun Default (Testing)

Setelah menjalankan perintah `--seed`, Anda dapat masuk menggunakan kredensial standar. (Sesuaikan dengan data dari `UserSeeder.php` atau `DatabaseSeeder.php`).

*Contoh Format Akun (Harap periksa file seeder untuk data pasti):*
- **Superadmin** | Email/NIP: `superadmin@app.com` | Password: `password`
- **Pegawai** | Email/NIP: `pegawai@app.com` | Password: `password`

## 🔧 Panduan *Troubleshooting*

- **Error 500 / Tanggal/Waktu tidak sesuai**: Pastikan pengaturan `APP_TIMEZONE` di `.env` sudah disetel ke zona waktu yang benar (misal: `Asia/Jakarta` atau `Asia/Makassar`).
- **Aset (CSS/JS) tidak memuat**: Pastikan Anda sudah menjalankan `npm run build`.
- **Gagal mengirim WhatsApp (Notifikasi tidak masuk)**:
  1. Pastikan Anda sudah menjalankan `php artisan queue:work`.
  2. Cek log error di `storage/logs/laravel.log`.
  3. Pastikan perangkat WhatsApp di *dashboard* Fonnte dalam keadaan *Connected* (terhubung).

  Nama: Lintang Cahyani Putri
  Nim: 531422005
  