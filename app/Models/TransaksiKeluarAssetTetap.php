<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiKeluarAsetTetap extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keluar_aset_tetap';
    
    protected $fillable = [
        'nomor_transaksi',
        'aset_tetap_id',
        'user_id',
        'kode_barang',
        'nup',
        'nama_barang',
        'merek',
        'tanggal_perolehan',
        'nilai_perolehan',
        'lokasi',
        'nomor_sk',
        'tanggal_sk',
        'keterangan',
        'penerima',
        'alasan_keluar'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'tanggal_sk' => 'date',
        'nilai_perolehan' => 'decimal:2',
    ];

    // Relasi
    public function asetTetap(): BelongsTo
    {
        return $this->belongsTo(AssetTetap::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeBySK($query, $nomor)
    {
        return $query->where('nomor_sk', 'like', "%{$nomor}%");
    }

    // Accessors
    public function getNilaiFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->nilai_perolehan ?? 0, 0, ',', '.');
    }

    public function getTanggalSKFormatAttribute(): string
    {
        return $this->tanggal_sk ? $this->tanggal_sk->format('d/m/Y') : '-';
    }
}