<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendFonnteNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $target;
    public string $message;

    /**
     * Jumlah maksimal percobaan retry
     */
    public int $tries = 3;

    /**
     * Batas waktu timeout (detik) untuk eksekusi job
     */
    public int $timeout = 30;

    public function __construct(string $target, string $message)
    {
        $this->target = $target;
        $this->message = $message;
    }

    public function handle(): void
    {
        try {
            FonnteService::sendMessage($this->target, $this->message);

            Log::debug('Job SendFonnteNotification selesai', [
                'target'  => $this->target,
                'message' => mb_substr($this->message, 0, 150),
            ]);
        } catch (Throwable $e) {
            Log::error('Gagal mengirim notifikasi WhatsApp via Queue', [
                'target' => $this->target,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);

            // Paksa job gagal agar worker melakukan retry
            throw $e;
        }
    }

    /**
     * Jeda waktu sebelum retry (detik)
     */
    public function backoff(): int
    {
        return 10;
    }

    /**
     * Handle job ketika gagal total setelah semua retry
     */
    public function failed(Throwable $e): void
    {
        Log::critical('Notifikasi WhatsApp gagal total setelah semua retry', [
            'target' => $this->target,
            'error'  => $e->getMessage(),
        ]);
    }
}
