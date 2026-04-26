<?php
// app/Models/UserProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'instansi',
        'nip',
        'email',
        'no_hp',
        'alamat_instansi',
        'avatar',
        'signature',
        'signature_mime',
        'signature_size',
        'profile_completeness',
    ];

    protected $casts = [
        'profile_completeness' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompleteness(): int
    {
        $fields = ['nama_lengkap', 'instansi', 'nip', 'email', 'no_hp', 'alamat_instansi', 'signature'];
        $filled = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        $completeness = ($filled / count($fields)) * 100;
        $this->update(['profile_completeness' => (int) $completeness]);
        return (int) $completeness;
    }
}