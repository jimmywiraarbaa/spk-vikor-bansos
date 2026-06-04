<?php
require_once '../../includes/auth_helper.php';
isGuest();
include_once '../../templates/header.php';
?>

<div class="container">
    <div class="card auth-card p-4 animate-up">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold">Registrasi</h3>
            <p class="text-muted text-center mb-4">Buat akun baru SPK VIKOR</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="../../actions/auth_action.php" method="POST">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label text-secondary small fw-bold">NAMA LENGKAP</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="Nama lengkap">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label text-secondary small fw-bold">USERNAME</label>
                    <input type="text" name="username" id="username" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="Pilih username">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary small fw-bold">EMAIL</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="contoh@email.com">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label text-secondary small fw-bold">PASSWORD</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0" style="font-size: 0.9rem;" required placeholder="Minimal 6 karakter">
                        <button class="btn btn-light border-0 bg-light" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary w-100 mb-3">Daftar Akun</button>
            </form>
            
            <div class="text-center">
                <span class="small text-muted">Sudah punya akun? <a href="login.php" class="text-decoration-none fw-bold">Login</a></span>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>
