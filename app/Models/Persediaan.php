<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $table = 'persediaan';
    protected $guarded = [
        'kode_kategori',
        'kategori',
        'kode_barang',
        'nama_barang',
        'harga',
        'tanggal_masuk',
        'jumlah',
        'stok'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga' => 'decimal:2',
    ];

    public function permintaan()
    {
        return $this->hasMany(PermintaanPersediaan::class, 'persediaan_id');
    }

    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasukPersediaan::class, 'persediaan_id');
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluarPersediaan::class, 'persediaan_id');
    }
}
