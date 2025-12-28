<?php

// Paksa Laravel menggunakan folder /tmp untuk cache views karena storage asli Read-Only
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Buat folder tmp secara otomatis
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

require __DIR__ . '/../public/index.php';