<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiKeluarPersediaan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keluar_persediaan';
    
    protected $fillable = [
        'nomor_transaksi',
        'tanggal_input',     // ✅ Sesuai "Tanggal Input"
        'kota_kategori',     // ✅ Sesuai "Kota Kategori"
        'kategori',          // ✅ Sesuai "Kategori"
        'kode_barang',       // ✅ Sesuai "Kode Barang"
        'nama_barang',       // ✅ Sesuai "Nama Barang"
        'jumlah_keluar',     // ✅ Sesuai "Jumlah Keluar"
        'harga',             // ✅ Sesuai "Harga"
        'total',             // ✅ Sesuai "Total"
        'user_id',
    ];

    protected $casts = [
        'tanggal_input' => 'date',
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
        'jumlah_keluar' => 'integer',
    ];

    // Relasi User (opsional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ✅ MUTATOR: Auto hitung TOTAL = Harga × Jumlah Keluar
    public function setHargaAttribute($value): void
    {
        $this->attributes['harga'] = $value;
        $this->attributes['total'] = $value * ($this->attributes['jumlah_keluar'] ?? 0);
    }

    public function setJumlahKeluarAttribute($value): void
    {
        $this->attributes['jumlah_keluar'] = $value;
        if ($this->attributes['harga']) {
            $this->attributes['total'] = $this->attributes['harga'] * $value;
        }
    }

    // ✅ ACCESSOR: Format Rupiah untuk tampilan tabel
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga ?? 0, 0, ',', '.');
    }

    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }

    public function getNoAttribute(): string
    {
        return $this->getKey();
    }

    // ✅ SCOPE untuk filter tabel
    public function scopeFilterTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal_input', $tanggal);
    }

    public function scopeFilterKotaKategori($query, $kotaKategori)
    {
        return $query->where('kota_kategori', 'like', "%{$kotaKategori}%");
    }

    public function scopeFilterKategori($query, $kategori)
    {
        return $query->where('kategori', 'like', "%{$kategori}%");
    }
}