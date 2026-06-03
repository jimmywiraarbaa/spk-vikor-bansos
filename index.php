<?php
// index.php
require_once 'includes/functions.php';
session_start();

if (isset($_SESSION['user_id'])) {
    redirect('pages/dashboard.php');
} else {
    redirect('pages/auth/login.php');
}
exit;
