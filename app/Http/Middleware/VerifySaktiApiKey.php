<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySaktiApiKey
{
    public function handle(Request $request, Closure $next)
    {
        // Mengekstrak API Key dari header request
        $apiKey = $request->header('X-API-KEY');
        $envKey = env('API_SECRET_KEY');

        return response()->json([
            'kunci_dari_thunder_client' => $apiKey,
            'kunci_dari_file_env' => $envKey
        ]);
        
        // Memvalidasi token dengan yang ada di environment
        if ($apiKey !== $envKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. API Key Sakti tidak valid atau tidak ditemukan.'
            ], 401);
        }

        // Lolos validasi, teruskan request
        return $next($request);
    }
}