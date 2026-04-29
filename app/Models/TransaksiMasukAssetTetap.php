<?php
// app/Models/TransaksiMasukAsetTetap.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TransaksiMasukAssetTetap extends Model
{
    use HasFactory;

    protected $table = 'transaksi_masuk_aset_tetap';
    
    protected $fillable = [
        'aset_tetap_id', 'kode_barang', 'nup',
        'nama_barang', 'merek', 'kategori', 'tanggal_perolehan', 
        'nilai_perolehan', 'kondisi', 'lokasi',  'tanggal_input', 'jumlah'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'jumlah' => 'integer',
        'tanggal_input' => 'date',
    ];

    // ========== RELASI ==========
    public function asetTetap(): BelongsTo
    {
        return $this->belongsTo(AssetTetap::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ========== ACCESSORS ==========
    public function getNilaiFormatAttribute(): string
    {
        return $this->nilai_perolehan 
            ? 'Rp ' . number_format($this->nilai_perolehan, 0, ',', '.') 
            : '-';
    }

    // In your Model
  public function getTanggalInputFormattedAttribute(): string
    {
        return $this->tanggal_input 
            ? Carbon::parse($this->tanggal_input)->format('d/m/Y') 
            : '-';
    }

    public function getKondisiBadgeAttribute(): array
    {
        return match($this->kondisi) {
            'baik' => ['text' => 'Baik', 'color' => 'success', 'icon' => 'fa-check-circle'],
            'rusak_ringan' => ['text' => 'Rusak Ringan', 'color' => 'warning', 'icon' => 'fa-exclamation-triangle'],
            'rusak_berat' => ['text' => 'Rusak Berat', 'color' => 'danger', 'icon' => 'fa-wrench'],
            default => ['text' => 'Unknown', 'color' => 'secondary', 'icon' => 'fa-question']
        };
    }

    // ========== SCOPES ==========
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q
              ->orWhere('kode_barang', 'like', "%{$search}%")
              ->orWhere('nup', 'like', "%{$search}%")
              ->orWhere('nama_barang', 'like', "%{$search}%");
        });
    }

    public function scopeKondisi($query, $kondisi)
    {
        return $query->where('kondisi', $kondisi);
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // HAPUS method transaksiMasuk() yang recursive ❌
    // public function transaksiMasuk() { ... } ❌ DELETE INI
}