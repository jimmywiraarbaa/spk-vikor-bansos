<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
require_once '../../includes/functions.php';
checkLogin();

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Akses ditolak.";
    redirect('pages/dashboard.php');
}

if (!isset($_GET['id'])) {
    redirect('pages/users/index.php');
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "User tidak ditemukan.";
    redirect('pages/users/index.php');
}

include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>
    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi User">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0"><i class="bi bi-list"></i></button>
                <div class="ms-auto d-flex align-items-center"><span class="fw-medium small"><?php echo $_SESSION['username']; ?></span></div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Edit User</h4>
                            <p class="text-muted small">Perbarui informasi akun pengguna.</p>
                        </div>
                        <a href="index.php" class="btn btn-light btn-sm border px-3 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card border-0 shadow-sm p-4">
                        <form action="../../actions/user_action.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label small fw-bold text-secondary">USERNAME</label>
                                    <input type="text" name="username" id="username" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-bold text-secondary">EMAIL</label>
                                    <input type="email" name="email" id="email" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label small fw-bold text-secondary">PASSWORD BARU</label>
                                    <input type="password" name="password" id="password" class="form-control bg-light border-0" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <div class="form-text small">Kosongkan untuk mempertahankan password lama.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label small fw-bold text-secondary">ROLE</label>
                                    <select name="role" id="role" class="form-select bg-light border-0" required>
                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="operator" <?php echo $user['role'] === 'operator' ? 'selected' : ''; ?>>Operator</option>
                                        <option value="kepala_dinsos" <?php echo $user['role'] === 'kepala_dinsos' ? 'selected' : ''; ?>>Kepala Dinas Sosial</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="edit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Perbarui User
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
