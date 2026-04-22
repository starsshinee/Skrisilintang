<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanKendaraan extends Model
{
    protected $table = 'peminjaman_kendaraan';
    protected $guarded = [];

    public function assetTetap()
    {
        return $this->belongsTo(AssetTetap::class, 'aset_tetap_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengembalian()
    {
        return $this->hasMany(PengembalianKendaraan::class, 'peminjaman_kendaraan_id');
    }
}
