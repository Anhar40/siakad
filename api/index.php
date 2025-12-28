<?php

// 1. Definisikan path
$basePath = __DIR__ . '/..';

// 2. Setup folder temporary untuk Laravel (Wajib di Vercel)
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/bootstrap/cache',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 3. Konfigurasi Runtime
// Kita gunakan 'file' tapi arahkan ke /tmp yang writable
putenv("APP_CONFIG_CACHE={$storagePath}/bootstrap/cache/config.php");
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
putenv("CACHE_STORE=file"); 
putenv("CACHE_DIRECTORY={$storagePath}/framework/cache");
putenv("SESSION_DRIVER=cookie");
putenv("LOG_CHANNEL=stderr");
putenv("APP_DEBUG=true");

// 4. Jalankan aplikasi
require $basePath . '/public/index.php';