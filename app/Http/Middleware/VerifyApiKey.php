<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        // Mengambil API Key dari Header request
        $apiKey = $request->header('X-API-KEY');

        // Mencocokkan dengan secret key yang ada di .env
        if ($apiKey !== env('API_SECRET_KEY')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. API Key tidak valid atau tidak ditemukan.'
            ], 401);
        }

        // Jika valid, lanjutkan request ke Controller
        return $next($request);
    }
}