# Dokumentasi Models Sistem Manajemen Aset dan Persediaan

## 📋 Daftar Models dan Tabel Database

### 1. **AssetTetap** (aset_tetap)
**Deskripsi**: Menyimpan data aset tetap yang dimiliki organisasi
**Relasi**:
- `hasMany(TransaksiMasukAssetTetap)` - Transaksi masuk aset
- `hasMany(TransaksiKeluarAssetTetap)` - Transaksi keluar aset
- `hasMany(PeminjamanKendaraan)` - Peminjaman kendaraan

**Kolom Utama**:
- kode_aset (unique)
- nama_aset
- kategori
- jumlah
- nilai_awal / nilai_sekarang
- lokasi
- status (aktif, nonaktif, rusak)

---

### 2. **Persediaan** (persediaan)
**Deskripsi**: Menyimpan data barang persediaan yang tersedia
**Relasi**:
- `hasMany(PermintaanPersediaan)` - Permintaan barang
- `hasMany(TransaksiMasukPersediaan)` - Transaksi masuk
- `hasMany(TransaksiKeluarPersediaan)` - Transaksi keluar

**Kolom Utama**:
- kode_persediaan (unique)
- nama_barang
- kategori
- satuan
- jumlah_stok
- jumlah_minimum
- harga_satuan
- status

---

### 3. **Gedung** (gedung)
**Deskripsi**: Menyimpan data ruang/gedung yang dapat dipinjam
**Relasi**:
- `hasMany(PeminjamanGedung)` - Peminjaman gedung

**Kolom Utama**:
- kode_gedung (unique)
- nama_gedung
- lokasi
- luas_bangunan
- tipe_ruang
- kapasitas
- fasilitas
- status

---

### 4. **PeminjamanGedung** (peminjaman_gedung)
**Deskripsi**: Mencatat peminjaman gedung/ruang
**Relasi**:
- `belongsTo(Gedung)` - Gedung yang dipinjam
- `belongsTo(User)` - Peminjam
- `hasMany(PengembalianBarang)` - Pengembalian barang

**Kolom Utama**:
- nomor_peminjaman (unique)
- gedung_id
- user_id
- tanggal_mulai / tanggal_selesai
- keperluan
- status (pending, approved, rejected, selesai)

---

### 5. **PeminjamanKendaraan** (peminjaman_kendaraan)
**Deskripsi**: Mencatat peminjaman kendaraan (aset tetap yang berupa kendaraan)
**Relasi**:
- `belongsTo(AssetTetap)` - Kendaraan yang dipinjam
- `belongsTo(User)` - Peminjam
- `hasMany(PengembalianKendaraan)` - Pengembalian kendaraan

**Kolom Utama**:
- nomor_peminjaman (unique)
- aset_tetap_id
- user_id
- tanggal_mulai / tanggal_selesai_direncanakan
- tujuan
- sopir
- jumlah_bahan_bakar
- status (pending, approved, digunakan, dikembalikan)

---

### 6. **PermintaanPersediaan** (permintaan_persediaan)
**Deskripsi**: Mencatat permintaan/pengajuan barang persediaan
**Relasi**:
- `belongsTo(Persediaan)` - Barang yang diminta
- `belongsTo(User)` - Peminta
- `hasMany(TransaksiKeluarPersediaan)` - Pengeluaran barang

**Kolom Utama**:
- nomor_permintaan (unique)
- persediaan_id
- user_id
- jumlah_diminta
- tanggal_permintaan / tanggal_dibutuhkan
- keperluan
- status (pending, approved, rejected, selesai)

---

### 7. **PengembalianBarang** (pengembalian_barang)
**Deskripsi**: Mencatat pengembalian barang dari peminjaman gedung
**Relasi**:
- `belongsTo(PeminjamanGedung)` - Peminjaman terkait
- `belongsTo(User)` - Yang mengembalikan

**Kolom Utama**:
- nomor_pengembalian (unique)
- peminjaman_gedung_id
- user_id
- tanggal_pengembalian
- kondisi (baik, rusak, hilang)
- keterangan_kondisi
- biaya_kerusakan
- catatan

---

### 8. **PengembalianKendaraan** (pengembalian_kendaraan)
**Deskripsi**: Mencatat pengembalian kendaraan dari peminjaman
**Relasi**:
- `belongsTo(PeminjamanKendaraan)` - Peminjaman terkait
- `belongsTo(AssetTetap)` - Kendaraan
- `belongsTo(User)` - Yang mengembalikan

**Kolom Utama**:
- nomor_pengembalian (unique)
- peminjaman_kendaraan_id
- aset_tetap_id
- user_id
- tanggal_pengembalian
- km_awal / km_akhir
- kondisi (baik, rusak, hilang)
- keterangan_kondisi
- biaya_perbaikan
- catatan

---

### 9. **TransaksiMasukAssetTetap** (transaksi_masuk_aset_tetap)
**Deskripsi**: Mencatat transaksi masuk/penerimaan aset tetap
**Relasi**:
- `belongsTo(AssetTetap)` - Aset yang masuk
- `belongsTo(User)` - User pencatat

**Kolom Utama**:
- nomor_transaksi (unique)
- aset_tetap_id
- user_id
- tanggal_masuk
- supplier
- nomor_referensi (PO, Faktur, dll)
- jumlah_masuk
- nilai_perolehan
- keterangan

---

### 10. **TransaksiMasukPersediaan** (transaksi_masuk_persediaan)
**Deskripsi**: Mencatat transaksi masuk/penerimaan persediaan
**Relasi**:
- `belongsTo(Persediaan)` - Persediaan yang masuk
- `belongsTo(User)` - User pencatat

**Kolom Utama**:
- nomor_transaksi (unique)
- persediaan_id
- user_id
- tanggal_masuk
- supplier
- nomor_referensi
- jumlah_masuk
- harga_satuan
- keterangan

---

### 11. **TransaksiKeluarPersediaan** (transaksi_keluar_persediaan)
**Deskripsi**: Mencatat transaksi keluar/pengeluaran persediaan
**Relasi**:
- `belongsTo(Persediaan)` - Persediaan yang keluar
- `belongsTo(PermintaanPersediaan)` - Permintaan terkait (opsional)
- `belongsTo(User)` - User pencatat

**Kolom Utama**:
- nomor_transaksi (unique)
- persediaan_id
- permintaan_persediaan_id (nullable)
- user_id
- tanggal_keluar
- jumlah_keluar
- penerima
- tujuan
- keterangan

---

### 12. **TransaksiKeluarAssetTetap** (transaksi_keluar_aset_tetap)
**Deskripsi**: Mencatat transaksi keluar/pengeluaran aset tetap
**Relasi**:
- `belongsTo(AssetTetap)` - Aset yang keluar
- `belongsTo(User)` - User pencatat

**Kolom Utama**:
- nomor_transaksi (unique)
- aset_tetap_id
- user_id
- tanggal_keluar
- jumlah_keluar
- alasan_keluar (dijual, dihapuskan, dipindahkan, rusak)
- penerima
- keterangan

---

## 🔄 Alur Proses Utama Sistem

### **Alur Manajemen Aset Tetap**
1. Aset masuk melalui **TransaksiMasukAssetTetap**
2. Aset dapat dipinjam melalui **PeminjamanKendaraan** (khusus kendaraan)
3. Pengembalian dicatat di **PengembalianKendaraan**
4. Aset keluar melalui **TransaksiKeluarAssetTetap**

### **Alur Manajemen Persediaan**
1. Persediaan masuk melalui **TransaksiMasukPersediaan**
2. User membuat **PermintaanPersediaan**
3. Persediaan dikeluarkan melalui **TransaksiKeluarPersediaan** (terhubung dengan permintaan)
4. Stok persediaan berkurang setiap ada pengeluaran

### **Alur Peminjaman Gedung**
1. User membuat **PeminjamanGedung** (status: pending)
2. Admin approve/reject permintaan
3. Barang/perlengkapan gedung dikembalikan melalui **PengembalianBarang**
4. Kondisi barang dicatat (baik/rusak/hilang)

### **Alur Peminjaman Kendaraan**
1. User membuat **PeminjamanKendaraan** (status: pending)
2. Admin approve/reject permintaan
3. Kendaraan digunakan oleh peminjam
4. Kendaraan dikembalikan melalui **PengembalianKendaraan**
5. Kondisi kendaraan (km, rusak) dicatat

---

## 🗄️ Catatan Teknis

### Constraints Penting:
- Foreign key `constrained('tabel')->onDelete('cascade')`: Jika parent dihapus, child otomatis terhapus
- Foreign key `nullable()->constrained('tabel')->onDelete('set null')`: Jika parent dihapus, child ForeignKey diset NULL
- Kolom `nomor_*` menggunakan UNIQUE untuk memastikan uniqueness nomor transaksi

### Timestamps:
Semua tabel memiliki `created_at` dan `updated_at` otomatis dari Laravel

### Status Values:
- **AssetTetap**: aktif, nonaktif, rusak
- **Persediaan**: aktif, nonaktif
- **PeminjamanGedung**: pending, approved, rejected, selesai
- **PeminjamanKendaraan**: pending, approved, digunakan, dikembalikan
- **PermintaanPersediaan**: pending, approved, rejected, selesai
- **Pengembalian**: baik, rusak, hilang
- **Alasan Keluar Aset**: dijual, dihapuskan, dipindahkan, rusak

---

## 📝 Cara Menggunakan Models

```php
// Import Model
use App\Models\AssetTetap;

// Create
$asset = AssetTetap::create([
    'kode_aset' => 'AT001',
    'nama_aset' => 'Laptop Dell',
    'kategori' => 'Elektronik',
    'jumlah' => 1,
]);

// Read
$assets = AssetTetap::all();
$asset = AssetTetap::find(1);

// Update
$asset->update(['status' => 'nonaktif']);

// Delete
$asset->delete();

// Relasi
$transaksiMasuk = $asset->transaksiMasuk()->get();
```

---

## 🚀 Langkah Selanjutnya (Jika Diperlukan)

1. Buat **Controllers** untuk setiap model
2. Buat **Resources** untuk API response
3. Buat **Requests** untuk validation
4. Buat **Routes** di `routes/web.php` atau `routes/api.php`
5. Buat **Views** untuk UI
6. Jalankan migrations: `php artisan migrate`
