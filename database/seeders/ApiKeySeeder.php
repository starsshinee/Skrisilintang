<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiKeySeeder extends Seeder
{
    public function run(): void
    {
        if (ApiKey::exists()) {
            $this->command->info('api_keys sudah memiliki data — seeder dilewati.');
            return;
        }

        // Ambil dari .env (backward compatibility), fallback dummy
        $envKey = config('services.sipandu_api_key')
            ?: 'LINTAN-STATIC-PLACEHOLDER-KEY-0000';

        DB::table('api_keys')->insert([
            'label'        => 'SAKTI (legacy .env key)',
            'key_hash'     => hash('sha256', $envKey),
            'key_prefix'   => substr($envKey, 0, 8),
            'scopes'       => json_encode(['*']),
            'is_active'    => true,
            'expires_at'   => now()->addDays(90),
            'created_by'   => null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $this->command->info('Default API Key berhasil di-seed dari config services.sipandu_api_key.');
    }
}