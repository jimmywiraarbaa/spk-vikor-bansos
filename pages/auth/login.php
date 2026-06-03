<?php
require_once '../../includes/auth_helper.php';
isGuest();
include '../../templates/header.php';
?>

<div class="container">
    <div class="card auth-card p-4">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold">Login</h3>
            <p class="text-muted text-center mb-4">Masuk ke Sistem SPK VIKOR</p>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="../../actions/auth_action.php" method="POST">
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">USERNAME</label>
                    <input type="text" name="username" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="Masukkan username">
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">PASSWORD</label>
                    <input type="password" name="password" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="Masukkan password">
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 mb-3">Login Sekarang</button>
            </form>
            
            <div class="text-center">
                <span class="small text-muted">Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold">Daftar</a></span>
            </div>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>
