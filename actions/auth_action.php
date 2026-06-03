<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $nama_lengkap]);
        
        $_SESSION['success'] = "Registrasi berhasil, silakan login.";
        header("Location: ../pages/auth/login.php");
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registrasi gagal: " . $e->getMessage();
        header("Location: ../pages/auth/register.php");
    }
    exit;
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
        
        header("Location: ../pages/dashboard.php");
    } else {
        $_SESSION['error'] = "Username atau password salah.";
        header("Location: ../pages/auth/login.php");
    }
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../pages/auth/login.php");
    exit;
}
