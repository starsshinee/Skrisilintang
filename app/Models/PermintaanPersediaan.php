<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanPersediaan extends Model
{
    protected $table = 'permintaan_persediaan';
    protected $guarded = [];

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluarPersediaan::class, 'permintaan_persediaan_id');
    }
}
