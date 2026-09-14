<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ApiKey;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->query('X-API-KEY')) {
            Log::warning('API Key dikirim via Query Parameter', [
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'API Key harus dikirim melalui Header HTTP (X-API-KEY), bukan Query Parameter.'
            ], 400);
        }

        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return $this->deny($request, 'Header X-API-KEY tidak ditemukan.');
        }

        // ── 1. Cek di database ──────────────────────────────
        $dbKey = ApiKey::resolve($apiKey);

        if ($dbKey) {
            // Cek scope jika ada batasan
            $scope = $this->extractScope($request);
            if (!$dbKey->allowsScope($scope)) {
                return $this->deny($request, 'API Key tidak memiliki akses ke endpoint ini.');
            }

            Log::info('API Auth OK (DB)', [
                'label'    => $dbKey->label,
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);

            return $next($request);
        }

        // ── 2. Fallback ke .env (backward compatibility) ────
        $envKey = config('services.sipandu_api_key');

        if ($envKey && hash_equals($envKey, $apiKey)) {
            Log::info('API Auth OK (ENV)', [
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);

            return $next($request);
        }

        // ── 3. Ditolak ──────────────────────────────────────
        return $this->deny($request, 'API Key tidak valid atau tidak ditemukan.');
    }

    private function deny(Request $request, string $message)
    {
        Log::warning('API Auth Failed', [
            'ip'       => $request->ip(),
            'endpoint' => $request->path(),
            'time'     => now()->toIso8601String(),
        ]);

        return response()->json([
            'status'  => 'error',
            'message' => 'Unauthorized. ' . $message,
        ], 401);
    }

    private function extractScope(Request $request): string
    {
        $segments = $request->segments();
        // skip prefix "api"
        $first = $segments[0] === 'api' ? ($segments[1] ?? null) : $segments[0];
        return $first ?? 'general';
    }
}
