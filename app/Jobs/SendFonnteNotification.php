<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class SendFonnteNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $target;
    public $message;

    /**
     * 🔥 1. JUMALAH MAKSIMAL PERCOBAAN (RETRY)
     * Jika gagal/timeout, Job ini akan dicoba ulang maksimal 3 kali.
     */
    public $tries = 3;

    /**
     * 🔥 2. BATAS WAKTU TIMEOUT (DALAM DETIK)
     * Jika dalam 30 detik Fonnte tidak merespons, anggap timeout dan matikan job untuk di-retry.
     */
    public $timeout = 30;

    public function __construct($target, $message)
    {
        $this->target = $target;
        $this->message = $message;
    }

    public function handle(): void
    {
        try {
            FonnteService::sendMessage($this->target, $this->message);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim via Queue: ' . $e->getMessage());

            // 🔥 Paksa job ini gagal agar sistem tahu harus melakukan RETRY berikutnya
            throw $e;
        }
    }

    /**
     * 🔥 3. JEDA WAKTU SEBELUM RETRY (DALAM DETIK)
     * Berapa lama dia bakalan retry? Di bawah ini diatur jeda 10 detik sebelum mencoba lagi.
     */
    public function backoff(): int
    {
        return 10; // Jeda 10 detik untuk retry berikutnya (memberi waktu server Fonnte sehat dulu)
    }
}
