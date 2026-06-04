<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$loginPage = 'pages/auth/login.php';
$forgotPage = 'pages/auth/forgot_password.php';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = trim($_POST['nama_lengkap']);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, nama_lengkap) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $nama_lengkap]);

        $_SESSION['success'] = "Registrasi berhasil, silakan login.";
        redirect($loginPage);
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
        redirect($loginPage);
    }
}

if (isset($_POST['forgot_password'])) {
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "Email tidak ditemukan dalam sistem.";
        redirect($forgotPage);
    }

    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);
    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expiresAt]);

    require_once __DIR__ . '/../includes/mail_helper.php';

    $resetLink = baseUrl($forgotPage) . '?token=' . $token . '&email=' . urlencode($email);
    $htmlBody = '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: linear-gradient(135deg, #d9534f 0%, #c9302c 100%); padding: 20px; border-radius: 10px 10px 0 0; text-align: center;">
            <h2 style="color: white; margin: 0;">SPK VIKOR BANSOS</h2>
            <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0;">Dinas Sosial Kabupaten Merangin</p>
        </div>
        <div style="padding: 30px; background: #f9f9f9; border-radius: 0 0 10px 10px;">
            <p style="font-size: 16px; color: #333;">Halo, <strong>' . htmlspecialchars($user['nama_lengkap']) . '</strong></p>
            <p style="font-size: 14px; color: #555;">Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah untuk membuat password baru:</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="' . $resetLink . '" style="background: #d9534f; color: white; padding: 12px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">Reset Password</a>
            </div>
            <p style="font-size: 13px; color: #888;">Link ini berlaku selama <strong>1 jam</strong>. Jika Anda tidak meminta reset password, abaikan email ini.</p>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            <p style="font-size: 12px; color: #aaa; text-align: center;">Jika tombol tidak berfungsi, salin link berikut ke browser Anda:<br>
            <a href="' . $resetLink . '" style="word-break: break-all; color: #d9534f;">' . $resetLink . '</a></p>
        </div>
    </div>';

    if (sendEmail($email, $user['nama_lengkap'], 'Reset Password - SPK VIKOR BANSOS', $htmlBody)) {
        $_SESSION['success'] = "Link reset password telah dikirim ke email Anda. Silakan cek inbox (atau folder spam).";
    } else {
        $_SESSION['error'] = "Gagal mengirim email. Silakan coba lagi nanti.";
    }
    redirect($forgotPage);
}

if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok.";
        redirect($forgotPage . '?token=' . urlencode($token) . '&email=' . urlencode($email));
    }

    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND email = ? AND expires_at > NOW()");
    $stmt->execute([$token, $email]);
    $reset = $stmt->fetch();

    if (!$reset) {
        $_SESSION['error'] = "Token tidak valid atau sudah kedaluwarsa. Silakan ajukan reset ulang.";
        redirect($forgotPage);
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE users SET password = ? WHERE email = ?")->execute([$hashedPassword, $email]);
    $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

    $_SESSION['success'] = "Password berhasil diubah. Silakan login dengan password baru Anda.";
    redirect($loginPage);
}

if (isset($_GET['logout'])) {
    session_destroy();
    redirect($loginPage);
}


