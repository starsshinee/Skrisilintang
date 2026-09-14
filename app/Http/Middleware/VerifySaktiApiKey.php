<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifySaktiApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        $validKey = config('services.sakti_api_key');

        if (!$apiKey || !$validKey || !hash_equals($validKey, $apiKey)) {
            Log::warning('SAKTI API Authentication Failed', [
                'ip'       => $request->ip(),
                'endpoint' => $request->path(),
                'time'     => now()->toIso8601String(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. API Key Sakti tidak valid atau tidak ditemukan di Headers.'
            ], 401);
        }

        return $next($request);
    }
}
