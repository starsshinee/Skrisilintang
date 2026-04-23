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
        'persediaan_id',
        'user_id',
        'kode_kategori',
        'kategori',
        'kode_barang',
        'nama_barang',
        'jumlah_keluar',
        'harga',  // Sesuai tabel "Harga"
        'total',
        'tanggal_keluar',
        'penerima',
        'tujuan',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
        'jumlah_keluar' => 'integer',
    ];

    // Relasi
    public function persediaan(): BelongsTo
    {
        return $this->belongsTo(Persediaan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Mutator: Auto hitung total
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = $value;
        $this->attributes['total'] = $value * $this->jumlah_keluar;
    }

    // Accessors
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga ?? 0, 0, ',', '.');
    }

    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }
}