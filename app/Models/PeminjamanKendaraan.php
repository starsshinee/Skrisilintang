<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;




class PeminjamanKendaraan extends Model
{
    protected $table = 'peminjaman_kendaraan';
    
    // ✅ HANYA lindungi field sensitif
    protected $guarded = [
        'id',
        'user_id',
        'aset_tetap_id',
        'reviewed_by_adminasettetap_id',
        'approved_by_adminasettetap_id',
        'approved_by_kasubag_id',
        'status'
    ];
    
    // ✅ Field yang boleh diisi
    protected $fillable = [
        'user_id',
        'aset_tetap_id',
        'nama_kendaraan',
        'kategori',
        'merek',
        'jumlah',
        'tujuan_peminjaman',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'komentar'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_peminjaman' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
        'diteruskan_ke_kasubag_date' => 'datetime',
        'approved_by_kasubag_date' => 'datetime',
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Kendaraan dari master aset tetap
    public function assetTetap(): BelongsTo
    {
        return $this->belongsTo(AssetTetap::class, 'aset_tetap_id');
    }

    // Admin Aset Tetap yang mereview
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_adminasettetap_id');
    }

    // Admin Aset Tetap yang approve
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_adminasettetap_id');
    }

    // Kasubag yang approve
    public function approvedByKasubag(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_kasubag_id');
    }

    //Pengembalian kendaraan
    // public function pengembalian(): HasMany
    // {
    //     return $this->hasMany(PengembalianKendaraan::class, 'peminjaman_kendaraan_id');
    // }

    // ✅ SCOPE Workflow
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDalamReview($query)
    {
        return $query->where('status', 'dalam_review');
    }

    public function scopeDisetujuiAdmin($query)
    {
        return $query->where('status', 'disetujui_admin');
    }
}
