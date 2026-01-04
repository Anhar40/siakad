<?php

// 1. Path utama
$basePath = __DIR__ . '/..';

// 2. Siapkan folder temporer (Wajib untuk Vercel)
$storagePath = '/tmp/storage';
foreach ([
    '/framework/views',
    '/framework/cache/data', // Tambahkan subfolder data
    '/framework/sessions',
    '/bootstrap/cache'
] as $path) {
    if (!is_dir($storagePath . $path)) {
        mkdir($storagePath . $path, 0755, true);
    }
}

// 3. Override Konfigurasi agar tidak crash
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
putenv("SESSION_DRIVER=cookie"); // Paling aman untuk Vercel
putenv("CACHE_STORE=array");      // Gunakan 'file', bukan 'array'
putenv("CACHE_DIRECTORY={$storagePath}/framework/cache/data");
putenv("APP_CONFIG_CACHE={$storagePath}/bootstrap/cache/config.php");
putenv("APP_DEBUG=false");        // Biarkan true dulu untuk pantau error berikutnya

// 4. Jalankan aplikasi
require $basePath . '/public/index.php';
