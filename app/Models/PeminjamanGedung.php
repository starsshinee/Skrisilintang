<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanGedung extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_gedung';
    
    protected $fillable = [
        'user_id', 'nama_lengkap', 'nip_nik', 'instansi_lembaga', 'kabupaten_kota',
        'fasilitas', 'nama_fasilitas', 'tarif_per_hari',
        'tanggal_pinjam', 'tanggal_kembali', 'jam_mulai', 'jam_selesai', 'total_pembayaran',
        'tujuan_penggunaan', 'nomor_kontak', 'surat_path',
        'lama_peminjaman_hari', 'status', 'komentar','created_at',
        'updated_at', 'reviewed_by_admin_id', 'tanggal_approval',
        'approved_by_kasubag_id', 'approved_by_kasubag_date', 'diteruskan_ke_kasubag_date'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'tarif_per_hari' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
        'tanggal_approval' => 'datetime',
        'lama_peminjaman_hari' => 'integer',
        'approved_by_kasubag_date' => 'datetime',
        'diteruskan_ke_kasubag_date' => 'datetime',
    ];

    // **AUTO CALCULATION ACCESSOR**
    public function getTotalPembayaranAttribute()
    {
        return $this->tarif_per_hari * $this->lama_peminjaman_hari;
    }

    // **AUTO CALCULATE LAMA PEMINJAMAN**
    public function calculateDurasi()
    {
        $start = \Carbon\Carbon::parse($this->tanggal_pinjam);
        $end = \Carbon\Carbon::parse($this->tanggal_kembali);
        $this->lama_peminjaman_hari = $start->diffInDays($end) + 1; // +1 untuk include hari pertama
        return $this;
    }

    // Mutator untuk auto calculate saat save
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($peminjaman) {
            $peminjaman->calculateDurasi();
            // Total pembayaran otomatis dihitung di accessor
        });
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badgeClass = match($this->status) {
            'di setujui' => 'approved',
            'pending' => 'pending',
            'rejected' => 'rejected',
            default => 'pending'
        };

        return '<span class="status-badge ' . $badgeClass . '"><i class="fas fa-circle"></i> ' . ucfirst($this->status) . '</span>';
    }

    // Relationships (sama seperti sebelumnya)
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by_admin_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by_kasubag_id'); }

    // Scopes (sama seperti sebelumnya)
    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->whereIn('status', ['disetujui_kasubag', 'disetujui']); }
}