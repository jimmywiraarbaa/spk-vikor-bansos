<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['tambah'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        redirect('pages/users/tambah.php');
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
        redirect('pages/users/tambah.php');
    }

    if (!in_array($role, ['admin', 'operator'])) {
        $_SESSION['error'] = "Role tidak valid.";
        redirect('pages/users/tambah.php');
    }

    try {
        $check = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);
        if ($check->fetch()) {
            $_SESSION['error'] = "Username atau email sudah digunakan.";
            redirect('pages/users/tambah.php');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashed, $role]);

        $_SESSION['success'] = "User berhasil ditambahkan.";
        redirect('pages/users/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menambah user: " . $e->getMessage();
        redirect('pages/users/tambah.php');
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($email)) {
        $_SESSION['error'] = "Username dan email wajib diisi.";
        redirect('pages/users/edit.php?id=' . $id);
    }

    if (!in_array($role, ['admin', 'operator'])) {
        $_SESSION['error'] = "Role tidak valid.";
        redirect('pages/users/edit.php?id=' . $id);
    }

    try {
        $check = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $check->execute([$username, $email, $id]);
        if ($check->fetch()) {
            $_SESSION['error'] = "Username atau email sudah digunakan oleh user lain.";
            redirect('pages/users/edit.php?id=' . $id);
        }

        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $email, $hashed, $role, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $email, $role, $id]);
        }

        $_SESSION['success'] = "User berhasil diperbarui.";
        redirect('pages/users/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui user: " . $e->getMessage();
        redirect('pages/users/edit.php?id=' . $id);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $selfId = $_SESSION['user_id'] ?? null;

    if ($id == $selfId) {
        $_SESSION['error'] = "Tidak dapat menghapus akun sendiri.";
        redirect('pages/users/index.php');
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "User berhasil dihapus.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus user: " . $e->getMessage();
    }
    redirect('pages/users/index.php');
}
