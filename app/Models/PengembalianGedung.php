<?php
// app/Models/PengembalianGedung.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianGedung extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_gedung';
    
    protected $fillable = [
        'peminjaman_gedung_id',
        'tanggal_pengembalian',
        'jam_pengembalian',
        'kondisi_gedung',
        'catatan_pengembalian',
        'foto_kondisi',
        'status_verifikasi',
        'denda_akhir',
        'catatan_verifikasi'
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
        'foto_kondisi' => 'array',
        'denda_akhir' => 'decimal:2',
    ];

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanGedung::class, 'peminjaman_gedung_id');
    }

    // Scope untuk menunggu verifikasi
    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status_verifikasi', 'menunggu');
    }

    // Kondisi display
    public function getKondisiDisplayAttribute()
    {
        $kondisi = [
            'baik' => 'Baik - Tidak ada kerusakan',
            'ringan' => 'Ringan - Perlu perawatan kecil',
            'rusak' => 'Rusak - Ada kerusakan signifikan'
        ];

        return $kondisi[$this->kondisi_gedung] ?? 'Tidak diketahui';
    }

    // Status verifikasi badge
    public function getStatusVerifikasiBadgeAttribute()
    {
        $status = [
            'menunggu' => ['label' => 'Menunggu Verifikasi', 'class' => 'warning'],
            'disetujui' => ['label' => 'Disetujui', 'class' => 'success'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'danger']
        ];

        return $status[$this->status_verifikasi] ?? ['label' => 'Unknown', 'class' => 'secondary'];
    }
}