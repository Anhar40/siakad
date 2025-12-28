<?php

// Paksa folder view ke /tmp (Wajib di Vercel)
putenv('VIEW_COMPILED_PATH=/tmp/views');
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Pastikan Laravel tidak mencoba menggunakan file untuk maintenance mode
putenv('APP_MAINTENANCE_DRIVER=array');

require __DIR__ . '/../public/index.php';