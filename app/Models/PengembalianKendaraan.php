<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PengembalianKendaraan extends Model
{
    protected $fillable = [
        'peminjaman_kendaraan_id',
        'tanggal_pengembalian_aktual',
        'kilometer_awal',
        'kilometer_akhir',
        'kondisi_kendaraan',
        'catatan',
        'foto_sebelum',
        'foto_sesudah',
        'status_pengembalian',
        'biaya_denda'
    ];

    protected $casts = [
        'tanggal_pengembalian_aktual' => 'datetime',
        'kilometer_awal' => 'integer',
        'kilometer_akhir' => 'integer',
        'biaya_denda' => 'decimal:2',
        'status_pengembalian' => 'string'
    ];

    // Relasi
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanKendaraan::class, 'peminjaman_kendaraan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope
    public function scopeLengkap($query)
    {
        return $query->where('status_pengembalian', 'lengkap');
    }

    public function scopeTelat($query)
    {
        return $query->where('status_pengembalian', 'telat');
    }
}

    // public function peminjamanKendaraan()
    // {
    //     return $this->belongsTo(PeminjamanKendaraan::class, 'peminjaman_kendaraan_id');
    // }

    // public function assetTetap()
    // {
    //     return $this->belongsTo(AssetTetap::class, 'aset_tetap_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
// }
