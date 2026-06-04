<?php
// includes/functions.php

/**
 * Mendapatkan base URL secara dinamis
 */
function baseUrl($path = '') {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    
    // Mendapatkan base directory secara dinamis
    $current_script = $_SERVER['SCRIPT_NAME'];
    $current_dir = dirname($current_script);
    
    // Jika kita berada di subfolder (misal /pages/auth/), kita naik ke atas
    // Kita cari posisi 'pages' atau 'actions' atau 'includes' dalam path
    $base_dir = $current_dir;
    $search_folders = ['/pages/auth', '/pages/users', '/pages', '/actions', '/includes'];
    
    foreach ($search_folders as $folder) {
        if (strpos($base_dir, $folder) !== false) {
            $base_dir = str_replace($folder, '', $base_dir);
            break;
        }
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
