<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasukPersediaan extends Model
{
    protected $table = 'transaksi_masuk_persediaan';
    protected $guarded = [];

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
