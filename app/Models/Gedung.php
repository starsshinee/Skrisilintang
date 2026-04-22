<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';
    protected $guarded = [];

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanGedung::class, 'gedung_id');
    }
}
