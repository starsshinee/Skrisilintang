<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $table = 'mutasi_barang';
    
    protected $fillable = [
        'nomor_mutasi',
        'aset_tetap_id',
        'user_id',
        'kode_barang',
        'nama_barang',
        'lokasi_awal',
        'lokasi_akhir',
        'tanggal_mutasi',
        'alasan_mutasi',
        'penerima',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
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
    public function scopeByLokasi($query, $lokasiAwal, $lokasiAkhir)
    {
        return $query->where('lokasi_awal', $lokasiAwal)
                     ->where('lokasi_akhir', $lokasiAkhir);
    }

    // Accessors
    public function getLokasiPerubahanAttribute(): string
    {
        return "{$this->lokasi_awal} → {$this->lokasi_akhir}";
    }
}