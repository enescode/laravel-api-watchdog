<?php

namespace Enescode\ApiWatchdog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WatchdogCheckCommand extends Command
{
    protected $signature = 'watchdog:check';
    protected $description = 'Belirlenen API servislerinin durumunu ve hızını kontrol eder.';

    public function handle()
    {
        $endpoints = config('api-watchdog.endpoints', []);
        $maxTime = config('api-watchdog.max_response_time', 2000);
        $notifyEmail = config('api-watchdog.notify_email');

        if (empty($endpoints)) {
            $this->error('İzlenecek API bulunamadı. Lütfen config dosyasını kontrol edin.');
            return;
        }

        foreach ($endpoints as $api) {
            $this->info("Kontrol ediliyor: {$api['name']}...");

            $startTime = microtime(true);
            
            try {
                $method = strtoupper($api['method'] ?? 'GET');
                
                $response = Http::withHeaders($api['headers'] ?? []) // Headerları ekledik
                    ->timeout(10)
                    ->send($method, $api['url'], [
                        'json' => $api['data'] ?? []
                    ]);
                
                $endTime = microtime(true);
                $duration = round(($endTime - $startTime) * 1000); // Milisaniye cinsinden

                $status = $response->status();
                $isSuccessful = ($status === ($api['expect'] ?? 200));
                $isSlow = ($duration > $maxTime);

                // Sonuçları Ekrana Basalım
                $this->line("Durum: $status | Süre: {$duration}ms");

                // Hata veya Yavaşlık Durumu
                if (!$isSuccessful || $isSlow) {
                    $reason = !$isSuccessful ? "Yanlış HTTP Kodu ($status)" : "Yavaş Yanıt ({$duration}ms)";
                    $this->error("🚨 Sorun Tespit Edildi: $reason");

                    $this->sendAlert($api, $status, $duration, $reason, $notifyEmail);
                } else {
                    $this->info("✅ Sorun yok.");
                }

            } catch (\Exception $e) {
                $this->error("🚨 Bağlantı Hatası: " . $e->getMessage());
                $this->sendAlert($api, 'ERR', 0, $e->getMessage(), $notifyEmail);
            }

            $this->newLine();
        }
    }

    protected function sendAlert($api, $status, $duration, $reason, $email)
    {
        $message = "API Watchdog Uyarısı!\n" .
                   "Servis: {$api['name']}\n" .
                   "URL: {$api['url']}\n" .
                   "Hata Nedeni: $reason\n" .
                   "Zaman: " . now()->toDateTimeString();

        // Mail varsa gönder, yoksa logla
        if ($email) {            
            try {
                Mail::raw($message, function ($m) use ($email) {
                    $m->to($email)->subject('🚨 API Watchdog Uyarısı!');
                });
            } catch (\Exception $e) {
                Log::error("Watchdog Mail Gönderilemedi: " . $e->getMessage());
                Log::error($message);
            }
        } else {
            Log::warning($message);
        }
    }
}