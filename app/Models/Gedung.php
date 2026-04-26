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
        'fasilitas'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tarif_sewa' => 'integer',
        'kapasitas' => 'integer',
    ];

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
}