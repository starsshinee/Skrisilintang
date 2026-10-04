<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class SendFonnteNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $target;
    public string $message;

    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(string $target, string $message)
    {
        $this->target  = $target;
        $this->message = $message;
    }

    public function handle(): void
    {
        $msgPreview = mb_substr($this->message, 0, 120);
        $console    = app()->runningInConsole() ? new ConsoleOutput() : null;

        Log::debug('Job SendFonnteNotification mulai diproses', [
            'target'  => $this->target,
            'preview' => $msgPreview,
        ]);

        if ($console) {
            $console->writeln('<info>[QUEUE-FONNTE]</info> ▶ Memproses kirim ke <comment>' . $this->target . '</comment>: ' . $msgPreview);
        }

        try {
            FonnteService::sendMessage($this->target, $this->message);

            Log::debug('Job SendFonnteNotification selesai', [
                'target'  => $this->target,
                'message' => mb_substr($this->message, 0, 150),
            ]);

            if ($console) {
                $console->writeln('<info>[QUEUE-FONNTE]</info> ✓ Selesai diproses untuk <comment>' . $this->target . '</comment>');
            }
        } catch (Throwable $e) {
            Log::error('Gagal mengirim notifikasi WhatsApp via Queue', [
                'target' => $this->target,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);

            if ($console) {
                $console->writeln('<error>[QUEUE-FONNTE] ✗ Gagal proses untuk ' . $this->target . ': ' . $e->getMessage() . '</error>');
            }

            throw $e;
        }
    }

    public function backoff(): int
    {
        return 10;
    }

    public function failed(Throwable $e): void
    {
        $console = app()->runningInConsole() ? new ConsoleOutput() : null;

        Log::critical('Notifikasi WhatsApp gagal total setelah semua retry', [
            'target' => $this->target,
            'error'  => $e->getMessage(),
        ]);

        if ($console) {
            $console->writeln('<error>[QUEUE-FONNTE] ✗ GAGAL TOTAL (retry habis) untuk ' . $this->target . ': ' . $e->getMessage() . '</error>');
        }
    }
}