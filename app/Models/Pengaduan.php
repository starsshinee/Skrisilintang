<?php
// app/Models/Pengaduan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'telepon',
        'kategori',
        'deskripsi',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i',
        'updated_at' => 'datetime:d M Y H:i',
    ];

    // Kategori mapping untuk display
    public static function getKategoriLabels()
    {
        return [
            'peminjaman_barang' => 'Peminjaman Barang',
            'pengembalian_barang' => 'Pengembalian Barang',
            'peminjaman_kendaraan' => 'Peminjaman Kendaraan',
            'pengembalian_kendaraan' => 'Pengembalian Kendaraan',
            'peminjaman_gedung' => 'Peminjaman Gedung',
            'pengembalian_gedung' => 'Pengembalian Gedung',
            'persediaan' => 'Persediaan',
            'sistem' => 'Sistem/Aplikasi',
            'layanan' => 'Layanan',
            'lainnya' => 'Lainnya',
        ];
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('telepon', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor untuk kategori label
    public function getKategoriLabelAttribute()
    {
        return self::getKategoriLabels()[$this->kategori] ?? ucwords(str_replace('_', ' ', $this->kategori));
    }

    // Status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'baru' => 'status-baru',
            'diproses' => 'status-diproses',
            'selesai' => 'status-selesai',
            'ditolak' => 'status-ditolak',
            default => 'status-baru'
        };
    }
}