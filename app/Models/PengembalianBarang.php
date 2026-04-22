<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianBarang extends Model
{
    protected $table = 'pengembalian_barang';
    protected $guarded = [];

    public function peminjamanBarang()
    {
        return $this->belongsTo(PeminjamanBarang::class, 'peminjaman_barang_id');
    }

    public function assetTetap()
    {
        return $this->belongsTo(AssetTetap::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
