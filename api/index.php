<?php

// 1. Definisikan path
$basePath = __DIR__ . '/..';

// 2. Paksa konfigurasi agar tidak mencari file fisik
putenv("APP_DEBUG=true");
putenv("APP_ENV=production");
putenv("VIEW_COMPILED_PATH=/tmp/views");
putenv("SESSION_DRIVER=cookie");
putenv("LOG_CHANNEL=stderr");
putenv("APP_CONFIG_CACHE=/tmp/config.php");

// 3. Buat folder view jika belum ada
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// 4. Load aplikasi
require $basePath . '/public/index.php';