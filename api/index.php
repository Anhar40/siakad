<?php

// Paksa folder view ke /tmp (Wajib di Vercel)
putenv('VIEW_COMPILED_PATH=/tmp');
if (!is_dir('/tmp')) {
    mkdir('/tmp', 0755, true);
}

// Pastikan Laravel tidak mencoba menggunakan file untuk maintenance mode
putenv('APP_MAINTENANCE_DRIVER=array');

require __DIR__ . '/../public/index.php';