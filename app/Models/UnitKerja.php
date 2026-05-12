<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitKerja extends Model
{
    // Hanya nama_unit dan lokasi yang bisa diisi
    protected $fillable = ['nama_unit', 'lokasi'];

    // Relasi ke User (Satu unit kerja memiliki banyak pegawai)
    public function User(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke Asset Tetap (Satu unit kerja memiliki banyak aset)
    public function AssetTetap(): HasMany
    {
        return $this->hasMany(AssetTetap::class);
    }
}
