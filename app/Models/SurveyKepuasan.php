<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyKepuasan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_kepuasan';

    protected $fillable = [
        'nama',
        'email',
        'kepuasan',
        'aspek_memuaskan',
        'saran',
        'ip_address',
        'user_agent',
        'catatan_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes untuk search dan filter
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('aspek_memuaskan', 'like', "%{$search}%")
              ->orWhere('saran', 'like', "%{$search}%");
        });
    }

    public function scopeKepuasan($query, $kepuasan)
    {
        return $query->where('kepuasan', $kepuasan);
    }

    // Accessors untuk rating stars
    public function getRatingStarsAttribute()
    {
        $ratings = [
            'sangat_puas' => 5,
            'puas' => 4,
            'cukup' => 3,
            'kurang_puas' => 2,
            'tidak_puas' => 1
        ];

        $stars = $ratings[$this->kepuasan] ?? 1;
        return str_repeat('★', $stars);
    }

    // Accessors untuk label kepuasan
    public function getKepuasanLabelAttribute()
    {
        $labels = [
            'sangat_puas' => 'Sangat Puas',
            'puas' => 'Puas',
            'cukup' => 'Cukup Puas',
            'kurang_puas' => 'Kurang Puas',
            'tidak_puas' => 'Tidak Puas'
        ];

        return $labels[$this->kepuasan] ?? 'Tidak Puas';
    }

    
    // ✅ TAMBAH SCOPE FILTER INI
    public function scopeFilter($query, $request)
    {
        return $query->when($request->filled('search'), function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        })->when($request->filled('kepuasan'), function($q) use ($request) {
            $q->where('kepuasan', $request->kepuasan);
        });
    }

}