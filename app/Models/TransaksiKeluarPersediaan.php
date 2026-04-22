<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKeluarPersediaan extends Model
{
    protected $table = 'transaksi_keluar_persediaan';
    protected $guarded = [];

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }

    public function permintaanPersediaan()
    {
        return $this->belongsTo(PermintaanPersediaan::class, 'permintaan_persediaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
