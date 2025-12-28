<?php

// 1. Definisikan base path
$basePath = __DIR__ . '/..';

// 2. Paksa folder storage dan cache ke /tmp (folder yang bisa ditulis di Vercel)
$storagePath = '/tmp/storage';
if (!is_dir($storagePath . '/framework/views')) {
    mkdir($storagePath . '/framework/views', 0755, true);
}
if (!is_dir($storagePath . '/bootstrap/cache')) {
    mkdir($storagePath . '/bootstrap/cache', 0755, true);
}

// 3. Set Environment Variables secara runtime agar Laravel tidak tersesat
putenv("APP_CONFIG_CACHE={$storagePath}/bootstrap/cache/config.php");
putenv("APP_ROUTES_CACHE={$storagePath}/bootstrap/cache/routes.php");
putenv("APP_SERVICES_CACHE={$storagePath}/bootstrap/cache/services.php");
putenv("APP_PACKAGES_CACHE={$storagePath}/bootstrap/cache/packages.php");
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
putenv("CACHE_DRIVER=array"); // Hindari error penulisan file cache
putenv("SESSION_DRIVER=cookie"); // Hindari error penulisan file session

// 4. Jalankan aplikasi melalui public/index.php
require $basePath . '/public/index.php';