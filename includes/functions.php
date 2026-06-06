<?php
// includes/functions.php

/**
 * Mendapatkan base URL secara dinamis
 */
function baseUrl($path = '') {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];

    $markers = ['/pages/', '/actions/', '/includes/'];
    $base_dir = $script;
    foreach ($markers as $marker) {
        $pos = strpos($script, $marker);
        if ($pos !== false) {
            $base_dir = substr($script, 0, $pos);
            break;
        }
    }

    if ($base_dir === $script) {
        $base_dir = dirname($script);
    }

    $base_dir = rtrim($base_dir, '/');
    return $protocol . "://" . $host . $base_dir . '/' . ltrim($path, '/');
}

/**
 * Redirect ke halaman tertentu menggunakan baseUrl
 */
function redirect($path) {
    header("Location: " . baseUrl($path));
    exit;
}
