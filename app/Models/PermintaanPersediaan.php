<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanPersediaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan_persediaan';
    
    protected $fillable = [
        'nama_lengkap',
        'nama_barang',
        'persediaan_id',
        'user_id',
        'jumlah_diminta',
        'tanggal_permintaan',
        'tanggal_dibutuhkan',
        'tujuan_penggunaan',
        // Workflow
        'reviewed_by_adminpersediaan_id',
        'approved_by_kasubag_id',
        'status'
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_dibutuhkan' => 'date',
        'jumlah_diminta' => 'integer',
    ];

    // Relasi
    public function persediaan(): BelongsTo
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_adminpersediaan_id');
    }

    public function approvedByKasubag(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_kasubag_id');
    }

    // Scopes Workflow
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDalamReview($query)
    {
        return $query->where('status', 'dalam_review');
    }

    public function scopeDisetujuiKasubag($query)
    {
        return $query->where('status', 'disetujui_kasubag');
    }

    // Status badge helper
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => ['text' => 'Pending', 'color' => 'warning', 'icon' => 'fa-clock'],
            'dalam_review' => ['text' => 'Dalam Review', 'color' => 'info', 'icon' => 'fa-eye'],
            'disetujui_kasubag' => ['text' => 'Disetujui Kasubag', 'color' => 'success', 'icon' => 'fa-check-circle'],
            'disetujui' => ['text' => 'Disetujui', 'color' => 'success', 'icon' => 'fa-thumbs-up'],
            'ditolak' => ['text' => 'Ditolak', 'color' => 'danger', 'icon' => 'fa-times-circle'],
            default => ['text' => 'Unknown', 'color' => 'secondary']
        };
    }

    // Check apakah sudah final
    public function getIsFinalAttribute(): bool
    {
        return in_array($this->status, ['disetujui', 'ditolak']);
    }
}