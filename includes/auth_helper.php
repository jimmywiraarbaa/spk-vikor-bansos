<?php
// includes/auth_helper.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /spk-vikor-bansos/pages/auth/login.php");
        exit;
    }
}

function isGuest() {
    if (isset($_SESSION['user_id'])) {
        header("Location: /spk-vikor-bansos/pages/dashboard.php");
        exit;
    }
}
