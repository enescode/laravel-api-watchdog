# 🚨 Laravel API Watchdog

[English](#english) | [Türkçe](#türkçe)

---

## English

Laravel API Watchdog is a lightweight and powerful package designed to monitor your external API endpoints. It tracks response times, verifies status codes, and alerts you via Email or Logs when an API is down or performing poorly.

### ✨ Features
* 📡 **Multi-Method Support:** Monitor both `GET` and `POST` requests seamlessly.
* ⚡ **Performance Monitoring:** Automatically alerts you if an API response exceeds your threshold (default: 2 seconds).
* 🔐 **Authorization Support:** Easily add custom headers and Bearer tokens for secure APIs.
* 🚨 **Smart Alerting:** Sends instant email notifications. If email is not configured, it intelligently falls back to `laravel.log`.
* 🛠 **Scheduler Ready:** Designed to work perfectly with Laravel's Task Scheduler.

### 🛠 Installation
1. Install the package via composer:
```bash
composer require enescode/laravel-api-watchdog
```

### ✨ Publish the configuration file:
```bash
php artisan vendor:publish --tag="api-watchdog-config"
```
### ⚙️ Configuration
```bash
return [
    'notify_email' => 'admin@example.com',
    'max_response_time' => 2000, // miliseconds
    'endpoints' => [
        [
            'name' => 'Payment Gateway',
            'url' => '[https://api.example.com/v1/status](https://api.example.com/v1/status)',
            'method' => 'POST',
            'headers' => [
                'Authorization' => 'Bearer your-token-here'
            ],
            'data' => ['check' => true],
            'expect' => 200,
        ],
    ],
];
```

### 🚀 Usage
```bash
php artisan watchdog:check 
```
### 📧 Email Configuration 
To receive email alerts, make sure your `.env` file is properly configured with your SMTP settings. 
Additionally, define the recipient email address for the watchdog alerts:


**Laravel 10 add the command to your app/Console/Kernel.php:**
```bash
protected function schedule(Schedule $schedule)
{
    $schedule->command('watchdog:check')->everyFiveMinutes();
}
```
**Laravel 10+ add the command to your routes/console.php:**
```bash
Schedule::command('watchdog:check')->everyFiveMinutes();
```
---

## Türkçe

Laravel API Watchdog, dış API uç noktalarınızı izlemek için tasarlanmış hafif ve güçlü bir pakettir. Yanıt sürelerini izler, durum kodlarını doğrular ve bir API düştüğünde veya zayıf performans gösterdiğinde sizi E-posta veya Günlükler aracılığıyla uyarır.

### ✨ Özellikler
* 📡 **Çok Yöntemli Destek:** Hem `GET` hem de `POST` isteklerini sorunsuz bir şekilde izleyin.
* ⚡ **Performans İzleme:** Bir API yanıtı eşiğinizi aşarsa otomatik olarak sizi uyarır (varsayılan: 2 saniye).
* 🔐 **Yetkilendirme Desteği:** Güvenli API'ler için kolayca özel başlıklar ve Bearer token'ları ekleyin.
* 🚨 **Akıllı Uyarı:** Anında e-posta bildirimleri gönderir. E-posta yapılandırılmadıysa, `laravel.log` dosyasına akıllıca geri döner.
* 🛠 **Zamanlayıcı Hazırlığı:** Laravel'in Görev Zamanlayıcısı ile mükemmel şekilde çalışmak için tasarlanmıştır.

### 🛠 Kurulum
1. Paketi composer aracılığıyla kurun:
```bash
composer require enescode/laravel-api-watchdog
```

### ✨ Yapılandırma dosyasını yayınlayın:
```bash
php artisan vendor:publish --tag="api-watchdog-config"
```

### ⚙️ Yapılandırma
```bash
return [
    'notify_email' => 'admin@example.com',
    'max_response_time' => 2000, // milisaniye
    'endpoints' => [
        [
            'name' => 'Ödeme Geçidi',
            'url' => '[https://api.example.com/v1/status](https://api.example.com/v1/status)',
            'method' => 'POST',
            'headers' => [
                'Authorization' => 'Bearer your-token-here'
            ],
            'data' => ['check' => true],
            'expect' => 200,
        ],
    ],
];
```

### 🚀 Kullanımı
```bash
php artisan watchdog:check 
```

### 📧 E-Posta Ayarlaması
E-posta bildirimlerini alabilmek için `.env` dosyanızda SMTP ayarlarının yapılmış olduğundan emin olun. 
Ayrıca, uyarıların gönderileceği e-posta adresini şu şekilde tanımlayın:


**Laravel 10'da app/Console/Kernel.php dosyanıza ekleyin:**
```bash
protected function schedule(Schedule $schedule)
{
    $schedule->command('watchdog:check')->everyFiveMinutes();
}
```

**Laravel 11 ve 12 de routes/console.php dosyanıza ekleyin:**
```bash
Schedule::command('watchdog:check')->everyFiveMinutes();
```