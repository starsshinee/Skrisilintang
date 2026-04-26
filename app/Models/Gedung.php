<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedung';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_gedung',
        'foto_url',
        'lokasi',
        'luas_bangunan',
        'tarif_sewa',
        'kapasitas',
        'ketersediaan',
        'fasilitas',
        'kategori'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tarif_sewa' => 'integer',
        'kapasitas' => 'integer',
    ];

    // Helper untuk dropdown options
    public static function kategoriOptions()
    {
        return [
            'ruang_sidang' => 'Ruang Sidang',
            'mess' => 'Mess',
            'asrama' => 'Asrama',
            'ruang_makan' => 'Ruang Makan',
            'aula' => 'Aula',
            'ruang_kelas' => 'Ruang Kelas',
        ];
    }
    public static function ketersediaanOptions()
    {
        return [
            'Tersedia' => 'Tersedia',
            'Sedang Dipakai' => 'Sedang Dipakai',
            'Renovasi' => 'Renovasi',
            'Perlu Perbaikan' => 'Perlu Perbaikan',
        ];
    }

    /**
     * ✅ ICON MAPPING untuk setiap kategori
     */
    public function getIconAttribute()
    {
        return match($this->kategori) {
            'ruang_sidang' => 'door-open',
            'mess' => 'bed',
            'asrama' => 'home',
            'ruang_makan' => 'utensils',
            'aula' => 'university',
            'ruang_kelas' => 'chalkboard-teacher',
            default => 'building'
        };
    }

    /**
     * ✅ Status class untuk fasilitas view
     */
    public function getStatusClassAttribute()
    {
        return match($this->ketersediaan) {
            'Tersedia' => 'available',
            default => 'booked'
        };
    }


    public function getTarifSewaFormatAttribute()
    {
        return 'Rp ' . number_format($this->tarif_sewa, 0, ',', '.');
    }

    public function getKetersediaanBadgeAttribute()
    {
        $badgeClass = match($this->ketersediaan) {
            'Tersedia' => 'badge bg-success',
            'Sedang Dipakai' => 'badge bg-warning',
            'Renovasi' => 'badge bg-danger',
            'Perlu Perbaikan' => 'badge bg-secondary',
            default => 'badge bg-dark'
        };

        return '<span class="' . $badgeClass . '">' . $this->ketersediaan . '</span>';
    }

    // Scoped queries
    public function scopeTersedia($query)
    {
        return $query->where('ketersediaan', 'Tersedia');
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}