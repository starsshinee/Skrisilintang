<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianKendaraan extends Model
{
    protected $table = 'pengembalian_kendaraan';
    protected $guarded = [];

    public function peminjamanKendaraan()
    {
        return $this->belongsTo(PeminjamanKendaraan::class, 'peminjaman_kendaraan_id');
    }

    public function assetTetap()
    {
        return $this->belongsTo(AssetTetap::class, 'aset_tetap_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
