<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTetap extends Model
{
    protected $table = 'aset_tetap';
    protected $guarded = [
        'tanggal input',
        'kode_barang',
        'nup',
        'nama_barang',
        'merek',
        'tanggal_peroleh',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'jumlah',
        'kondisi',
    ];

    protected $casts = [
        'tanggal_peroleh' => 'date',
        'nilai_perolehan' => 'decimal:2',
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
