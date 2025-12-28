<?php

// 1. Matikan cache konfigurasi & rute agar Laravel membaca .env terbaru
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');

// 2. Pastikan folder view bisa ditulis di folder temporary Vercel
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// 3. Buat folder yang diperlukan jika belum ada
$folders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
];
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';