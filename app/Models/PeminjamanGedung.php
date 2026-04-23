<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanGedung extends Model
{
    protected $table = 'peminjaman_gedung';
    protected $guarded = [
        'user_id',
        'nama_instansi',
        'nama_peminjam',
        'nip',
        'kabupaten_kota',
        'nama_gedung',
        'nama_barang',
        'jenis',
        'surat_path',
        'tanggal_pinjaman',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'total_pembayaran',
        'status',
        'komentar',
        'tanggal_approval',
        'reviewed_by_admin_id',
        'diteruskan_ke_kasubag_date',
        'approved_by_kasubag_id',
        'approved_by_kasubag_date',
    ];

    protected $casts = [
        'tanggal_pinjaman' => 'date',
        'tanggal_selesai' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'total_pembayaran' => 'decimal:2',
        'tanggal_approval' => 'datetime',
        'diteruskan_ke_kasubag_date' => 'datetime',
        'approved_by_kasubag_date' => 'datetime',
    ];

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
