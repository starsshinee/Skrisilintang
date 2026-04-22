<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanGedung extends Model
{
    protected $table = 'peminjaman_gedung';
    protected $guarded = [];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengembalian()
    {
        return $this->hasMany(PengembalianBarang::class, 'peminjaman_gedung_id');
    }
}
