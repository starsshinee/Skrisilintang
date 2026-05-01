<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Persediaan extends Model
{
    use HasFactory;

    protected $table = 'persediaan';
    
    protected $fillable = [
        'kode_kategori',
        'kategori',
        'kode_barang',
        'nama_barang',
        'tanggal_masuk',
        'harga_satuan',
        'harga_total',
        'jumlah'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga_satuan' => 'decimal:2',
        'harga_total' => 'decimal:2',
        'jumlah' => 'integer',
    ];

    // Accessor untuk format harga satuan
    // Accessor untuk format harga satuan
    protected function hargaSatuan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'Rp ' . number_format($value, 2, ',', '.'),
        );
    }

    // Accessor untuk format harga total 
    protected function hargaTotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'Rp ' . number_format($value, 2, ',', '.'),
        );
    }

    // Auto calculate harga_total using RAW database values
    public function getHargaTotalAttribute($value)
    {
        $rawHargaSatuan = $this->getRawOriginal('harga_satuan');
        $rawJumlah = $this->getRawOriginal('jumlah');
        
        $total = $rawHargaSatuan * $rawJumlah;
        
        return 'Rp ' . number_format($total, 2, ',', '.');
    }

    // Scope untuk filter kategori
    public function scopeKategori($query, $kodeKategori)
    {
        return $query->where('kode_kategori', $kodeKategori);
    }
}