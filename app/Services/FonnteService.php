<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FonnteService
{
    /**
     * Mengirim pesan WhatsApp via Fonnte API
     *
     * @param string $target Nomor HP tujuan (contoh: 08123456789 / 628123456789)
     * @param string $message Isi pesan
     * @return array<string, mixed>
     *
     * @throws \RuntimeException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public static function sendMessage(string $target, string $message): array
    {
        $token = trim((string) config('services.fonnte.token'));

        if ($token === '') {
            throw new RuntimeException('FONNTE_TOKEN kosong. Jalankan php artisan config:clear && php artisan config:cache');
        }

        $normalizedTarget = static::normalizeTarget($target);

        try {
            $response = Http::asForm()
                ->withToken($token)
                ->acceptJson()
                ->connectTimeout(10)
                ->timeout(20)
                ->retry(3, 1000, fn ($e) => $e instanceof ConnectionException)
                ->post((string) config('services.fonnte.send_url', 'https://api.fonnte.com/send'), [
                    'target'      => $normalizedTarget,
                    'message'     => mb_substr($message, 0, 60000),
                    'countryCode' => '62',
                    'connectOnly' => false,
                ]);

            $body = $response->json() ?? [];

            // Cek flag JSON status Fonnte, bukan cuma HTTP code
            if ($response->failed() || ($body['status'] ?? false) !== true) {
                $reason = $body['reason'] ?? $body['detail'] ?? $response->body();
                $requestId = $body['requestid'] ?? null;

                Log::error('Fonnte gagal mengirim pesan WhatsApp', [
                    'target'     => $normalizedTarget,
                    'http_status' => $response->status(),
                    'reason'     => $reason,
                    'requestid'  => $requestId,
                ]);

                throw new RuntimeException('Fonnte menolak pengiriman: ' . ($reason ?: (string) $response->status()));
            }

            Log::info('Fonnte pesan berhasil dikirim/diantrekan', [
                'target'    => $body['target'] ?? [$normalizedTarget],
                'detail'    => $body['detail'] ?? null,
                'requestid' => $body['requestid'] ?? null,
                'process'   => $body['process'] ?? null,
                'message'   => mb_substr($message, 0, 200), // Log ringkas pesan untuk console/debug
            ]);

            return $body;
        } catch (ConnectionException $e) {
            Log::error('Koneksi Fonnte gagal', [
                'target' => $normalizedTarget,
                'error'  => $e->getMessage(),
            ]);

            throw $e;
        } catch (\Throwable $e) {
            Log::error('Exception saat mengirim pesan Fonnte', [
                'target' => $normalizedTarget,
                'error'  => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Normalisasi nomor HP ke format internasional 62XXXXXXXXXXX
     */
    protected static function normalizeTarget(string $raw): string
    {
        $normalized = preg_replace('/\D+/', '', $raw);

        if ($normalized === null || $normalized === '') {
            throw new RuntimeException('Nomor WhatsApp tidak valid: ' . $raw);
        }

        if (str_starts_with($normalized, '62')) {
            return $normalized;
        }

        if (str_starts_with($normalized, '0')) {
            return '62' . substr($normalized, 1);
        }

        if (str_starts_with($normalized, '8')) {
            return '62' . $normalized;
        }

        throw new RuntimeException('Format nomor WhatsApp tidak dikenali: ' . $raw);
    }
}
