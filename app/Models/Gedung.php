<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gedung extends Model
{
    protected $table = 'gedung';
    
    // HANYA lindungi field yang TIDAK boleh di-mass assignment
    protected $guarded = [
        'id',
        'user_id', 
        'reviewed_by_adminsarpras_id',
        'approved_by_kasubag_id',
        'status',
        'created_at',
        'updated_at'
    ];
    
    protected $fillable = [
        'nama_gedung',
        'foto_gedung', 
        'deskripsi',
        'lokasi',
        'luas_bangunan',
        'kapasitas',
        'fasilitas',
        'tarif_sewa',
        'ketersediaan'
    ];

    protected $casts = [
        'tarif_sewa' => 'decimal:2',
        'luas_bangunan' => 'decimal:2',
        'kapasitas' => 'integer',
        'ketersediaan' => 'string',
    ];

    // Relasi dengan User yang membuat request gedung
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Admin Sarpras yang mereview
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_adminsarpras_id');
    }

    // Relasi dengan Kasubag yang menyetujui
    public function approvedByKasubag(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_kasubag_id');
    }

    // Relasi dengan Peminjaman Gedung (aktifkan jika diperlukan)
    public function peminjaman(): HasMany
    {
        return $this->hasMany(PeminjamanGedung::class, 'gedung_id');
    }

    // Scope untuk status workflow
    public function scopeDalamReview($query)
    {
        return $query->where('status', 'dalam_review');
    }

    public function scopeDisetujuiKasubag($query)
    {
        return $query->where('status', 'disetujui_kasubag');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}