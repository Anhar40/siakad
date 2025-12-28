<?php

// 1. Tampilkan error agar kita bisa debug jika masih gagal

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Paksa Laravel menggunakan folder /tmp untuk cache views
// Karena folder storage asli di Vercel bersifat Read-Only
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// 3. Buat folder tmp jika belum ada (opsional tapi disarankan)
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

require __DIR__ . '/../public/index.php';