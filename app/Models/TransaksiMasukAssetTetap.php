<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiMasukAsetTetap extends Model
{
    use HasFactory;

    protected $table = 'transaksi_masuk_aset_tetap';
    
    protected $fillable = [
        'nomor_transaksi',
        'aset_tetap_id',
        'user_id',
        'kode_barang',
        'nup',
        'nama_barang',
        'merek',
        'kategori',
        'tanggal_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'jumlah',
        'supplier',
        'nomor_referensi',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'jumlah' => 'integer',
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
    public function scopeBaik($query)
    {
        return $query->where('kondisi', 'baik');
    }

    public function scopeRusak($query)
    {
        return $query->whereIn('kondisi', ['rusak_ringan', 'rusak_berat']);
    }

    public function scopeByTanggal($query, $start, $end)
    {
        return $query->whereBetween('tanggal_perolehan', [$start, $end]);
    }

    // Accessors
    public function getNilaiFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->nilai_perolehan ?? 0, 0, ',', '.');
    }

    public function getKondisiBadgeAttribute(): array
    {
        return match($this->kondisi) {
            'baik' => ['text' => 'Baik', 'color' => 'success', 'icon' => 'fa-check-circle'],
            'rusak_ringan' => ['text' => 'Rusak Ringan', 'color' => 'warning', 'icon' => 'fa-exclamation-triangle'],
            'rusak_berat' => ['text' => 'Rusak Berat', 'color' => 'danger', 'icon' => 'fa-wrench'],
            'tidak_layak_operasi' => ['text' => 'Tidak Layak', 'color' => 'dark', 'icon' => 'fa-ban'],
            default => ['text' => 'Unknown', 'color' => 'secondary']
        };
    }
}