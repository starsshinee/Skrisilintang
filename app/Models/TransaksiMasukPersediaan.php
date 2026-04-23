<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiMasukPersediaan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_masuk_persediaan';
    
    protected $fillable = [
        'nomor_transaksi',
        'persediaan_id',
        'user_id',
        'kode_kategori',
        'kategori',
        'kode_barang',
        'nama_barang',
        'jumlah_masuk',
        'harga_satuan',
        'total',
        'tanggal_masuk',
        'supplier',
        'nomor_referensi',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2',
        'jumlah_masuk' => 'integer',
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
    public function setHargaSatuanAttribute($value)
    {
        $this->attributes['harga_satuan'] = $value;
        $this->attributes['total'] = $value * $this->jumlah_masuk;
    }

    // Accessors
    public function getHargaSatuanFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_satuan ?? 0, 0, ',', '.');
    }

    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }
}