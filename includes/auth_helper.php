<?php
// includes/auth_helper.php
require_once __DIR__ . '/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id']) && strpos($_SERVER['SCRIPT_NAME'], 'login.php') === false) {
        redirect('pages/auth/login.php');
    }
}

function isGuest() {
    if (isset($_SESSION['user_id']) && strpos($_SERVER['SCRIPT_NAME'], 'dashboard.php') === false) {
        redirect('pages/dashboard.php');
    }
}
