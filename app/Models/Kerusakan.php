<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakan';

    protected $fillable = [
        'tanggal_input', 'nama_barang', 'kode_barang', 
        'nup', 'kondisi', 'foto', 'lokasi', 'deskripsi'
    ];

    protected $casts = ['tanggal_input' => 'date'];

    public function scopeFilterKondisi($query, $kondisi)
    {
        return $kondisi ? $query->where('kondisi', $kondisi) : $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama_barang', 'like', "%{$search}%")
              ->orWhere('kode_barang', 'like', "%{$search}%")
              ->orWhere('nup', 'like', "%{$search}%")
              ->orWhere('lokasi', 'like', "%{$search}%");
        });
    }
}