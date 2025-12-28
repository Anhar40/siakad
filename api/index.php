<?php

// 1. Path utama
$basePath = __DIR__ . '/..';

// 3. Override Konfigurasi agar tidak crash

putenv("APP_ENV=production");
putenv("APP_DEBUG=true");
putenv("APP_URL=https://yourproductionurl.com");
putenv("APP_KEY=base64:m2d7rGQ9BtpqNmCDJDp01KElX2oUIPJLlPfC1KNTDoo=");
putenv("CACHE_DRIVER=array");
putenv("LOG_CHANNEL=stderr");
putenv("APP_MAINTENANCE_DRIVER=file");
putenv("LOG_DEPRECATIONS_CHANNEL=null");
putenv("LOG_STACK=single");
putenv("LOG_LEVEL=debug");
putenv("SESSION_DRIVER=database");
putenv("SESSION_LIFETIME=120");
putenv("SESSION_ENCRYPT=false");
putenv("SESSION_PATH=/");
putenv("SESSION_DOMAIN=null");
putenv("BROADCAST_CONNECTION=log");
putenv("FILESYSTEM_DISK=production");
putenv("QUEUE_CONNECTION=database");
putenv("CACHE_STORE=database");


// 4. Jalankan aplikasi
require $basePath . '/public/index.php';