<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasukAssetTetap extends Model
{
    protected $table = 'transaksi_masuk_aset_tetap';
    protected $guarded = [];

    public function assetTetap()
    {
        return $this->belongsTo(AssetTetap::class, 'aset_tetap_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
