<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Bildirim Gönderilecek E-posta
    |--------------------------------------------------------------------------
    */
    'notify_email' => env('API_WATCHDOG_EMAIL', null),

    /*
    |--------------------------------------------------------------------------
    | Zaman Aşımı Sınırı (Milisaniye)
    |--------------------------------------------------------------------------
    | Yanıt süresi bu değerden (örn: 2000ms = 2sn) büyükse uyarı tetiklenir.
    */
    'max_response_time' => 2000,

    /*
    |--------------------------------------------------------------------------
    | İzlenecek API Listesi
    |--------------------------------------------------------------------------
    */
   'endpoints' => [
        // [
        //     'name'    => 'Haber Servisi (GET)',
        //     'url'     => 'https://api.example.com/v1/news',
        //     'method'  => 'GET',
        //     'headers' => [],
        //     'expect'  => 200,
        // ],

        // [
        //     'name'    => 'Stok Güncelleme (POST)',
        //     'url'     => 'https://api.example.com/v1/inventory',
        //     'method'  => 'POST',
        //     'headers' => [
        //         'Authorization' => 'Bearer YOUR_TOKEN_HERE',
        //         'X-Api-Key'     => 'YOUR_KEY_HERE',
        //         'Accept'        => 'application/json',
        //     ],
        //     'data'    => [
        //         'product_id' => 101,
        //         'stock'      => 50,
        //     ],
        //     'expect'  => 201, // Genelde oluşturma başarılı kodu
        // ],
    ],
];