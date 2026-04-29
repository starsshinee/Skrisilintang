<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTetap extends Model
{
    protected $table = 'aset_tetap';
    protected $fillable = [
        'tanggal_input',
        'kode_barang',
        'nup',
        'nama_barang',
        'merek',
        'kategori',
        'tanggal_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'jumlah',

    ];

    protected $casts = [
        'tanggal_input' => 'date',
        'tanggal_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'jumlah' => 'integer'
    ];


    public function transaksiMasuk()
    {
        return $this->hasMany(TransaksiMasukAssetTetap::class, 'aset_tetap_id');
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(TransaksiKeluarAssetTetap::class, 'aset_tetap_id');
    }

    public function peminjamanKendaraan()
    {
        return $this->hasMany(PeminjamanKendaraan::class, 'aset_tetap_id');
    }
}
