<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengembalianBarang extends Model
{
    protected $fillable = [
        'peminjaman_barang_id',
        'user_id',
        'tanggal_pengembalian_aktual',
        'jumlah_dikembalikan',
        'kondisi_barang',
        'catatan',
        'foto_sebelum',
        'foto_sesudah',
        'status_pengembalian',
        // Workflow Admin
        'verified_by_admin_id',
        'verified_at',
        'komentar_admin',
        'status_verifikasi'
    ];

    protected $casts = [
        'tanggal_pengembalian_aktual' => 'datetime',
        'verified_at' => 'datetime',
        'jumlah_dikembalikan' => 'integer',
    ];

    // Relasi
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanBarang::class, 'peminjaman_barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ✅ ADMIN YANG VERIFIKASI
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by_admin_id');
    }

    // Scopes
    public function scopePendingVerifikasi($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status_verifikasi', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', 'ditolak');
    }

    // Status badge
    public function getStatusVerifikasiBadgeAttribute(): array
    {
        return match($this->status_verifikasi) {
            'diterima' => ['text' => 'Diterima', 'color' => 'success', 'icon' => 'fa-check-circle'],
            'ditolak' => ['text' => 'Ditolak', 'color' => 'danger', 'icon' => 'fa-times-circle'],
            default => ['text' => 'Pending', 'color' => 'warning', 'icon' => 'fa-clock']
        };
    }
}