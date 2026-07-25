<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $passwordLama = $_POST['password_lama'];
    $passwordBaru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $userId]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Username atau email sudah digunakan.";
        } elseif (!empty($passwordBaru)) {
            if (!password_verify($passwordLama, $user['password'])) {
                $_SESSION['error'] = "Password lama tidak sesuai.";
            } elseif ($passwordBaru !== $konfirmasi) {
                $_SESSION['error'] = "Konfirmasi password tidak cocok.";
            } elseif (strlen($passwordBaru) < 6) {
                $_SESSION['error'] = "Password baru minimal 6 karakter.";
            } else {
                $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $email, $hash, $userId]);
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Profil berhasil diperbarui.";
            }
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $userId]);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Profil berhasil diperbarui.";
        }
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui profil: " . $e->getMessage();
    }
    header("Location: index.php");
    exit;
}

include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Profil">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Profil Saya</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm p-4 mb-4">
                        <div class="text-center mb-4">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                            </div>
                            <h5 class="fw-bold mb-0"><?php echo $user['username']; ?></h5>
                            <span class="badge <?php echo $user['role'] === 'admin' ? 'bg-danger' : ($user['role'] === 'kepala_dinsos' ? 'bg-success' : 'bg-primary'); ?> rounded-pill px-3 py-1 mt-1">
                                <?php echo $user['role'] === 'kepala_dinsos' ? 'Kepala Dinas Sosial' : ucfirst($user['role']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-pencil me-2 text-danger"></i>Edit Profil</h6>
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label small fw-bold text-secondary">USERNAME</label>
                                    <input type="text" name="username" id="username" class="form-control bg-light border-0" value="<?php echo $user['username']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-bold text-secondary">EMAIL</label>
                                    <input type="email" name="email" id="email" class="form-control bg-light border-0" value="<?php echo $user['email']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <hr class="my-2">
                                    <small class="text-muted">Kosongkan password jika tidak ingin mengubah</small>
                                </div>
                                <div class="col-md-12">
                                    <label for="password_lama" class="form-label small fw-bold text-secondary">PASSWORD LAMA</label>
                                    <input type="password" name="password_lama" id="password_lama" class="form-control bg-light border-0">
                                </div>
                                <div class="col-md-6">
                                    <label for="password_baru" class="form-label small fw-bold text-secondary">PASSWORD BARU</label>
                                    <input type="password" name="password_baru" id="password_baru" class="form-control bg-light border-0" minlength="6">
                                </div>
                                <div class="col-md-6">
                                    <label for="konfirmasi_password" class="form-label small fw-bold text-secondary">KONFIRMASI PASSWORD</label>
                                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control bg-light border-0" minlength="6">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>
