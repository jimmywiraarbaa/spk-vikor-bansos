<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $nama_lengkap]);

        $_SESSION['success'] = "Registrasi berhasil, silakan login.";
        redirect('pages/auth/login.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registrasi gagal: " . $e->getMessage();
        redirect('pages/auth/register.php');
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        redirect('pages/dashboard.php');
    } else {
        $_SESSION['error'] = "Username atau password salah.";
        redirect('pages/auth/login.php');
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    redirect('pages/auth/login.php');
}

