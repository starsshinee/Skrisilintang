<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $table = 'api_keys';

    protected $fillable = [
        'label',
        'key_hash',
        'key_prefix',
        'is_active',
        'scopes',
        'expires_at',
        'last_used_at',
        'last_used_ip',
        'created_by',
    ];

    protected $hidden = [
        'key_hash',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'scopes'     => 'array',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    // ── BOOT: auto-generate hash & prefix saat creating ─────

    protected static function booted(): void
    {
        static::creating(function (ApiKey $model) {
            if (!$model->key_hash && $model->raw_key) {
                $model->key_hash  = hash('sha256', $model->raw_key);
                $model->key_prefix = substr($model->raw_key, 0, 8);
            }
        });
    }

    // Virtual attribute: key mentah (hanya tersedia saat create/rotate)
    public $raw_key;

    // ── STATIC HELPER ──────────────────────────────────────

    /**
     * Generate API key baru dan return [ApiKey instance, raw_key string]
     */
    public static function generate(string $label, array $options = []): array
    {
        $raw = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' .
               strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        $apiKey = new static();
        $apiKey->label     = $label;
        $apiKey->raw_key   = $raw;
        $apiKey->key_hash  = hash('sha256', $raw);
        $apiKey->key_prefix = substr($raw, 0, 8);
        $apiKey->is_active = $options['is_active'] ?? true;
        $apiKey->scopes    = $options['scopes'] ?? ['*'];
        $apiKey->expires_at = $options['expires_at'] ?? now()->addDays(90);
        $apiKey->created_by = $options['created_by'] ?? null;
        $apiKey->save();

        return [$apiKey, $raw];
    }

    // ── QUERY HELPERS ──────────────────────────────────────

    /**
     * Validasi key mentah dari header, return ApiKey model atau null
     */
    public static function resolve(string $rawKey): ?ApiKey
    {
        $hash = hash('sha256', $rawKey);

        $key = static::where('key_hash', $hash)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->first();

        if ($key) {
            $key->update([
                'last_used_at' => now(),
                'last_used_ip' => request()->ip(),
            ]);
        }

        return $key;
    }

    /**
     * Cek apakah key memiliki scope tertentu
     */
    public function allowsScope(string $scope): bool
    {
        if (!$this->scopes) return true;
        return in_array('*', $this->scopes) || in_array($scope, $this->scopes);
    }

    // ── ACCESSORS ──────────────────────────────────────────

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) return 'Nonaktif';
        if ($this->is_expired)  return 'Kedaluwarsa';
        return 'Aktif';
    }

    public function getStatusColorAttribute(): string
    {
        if (!$this->is_active) return 'secondary';
        if ($this->is_expired)  return 'danger';
        return 'success';
    }
}
