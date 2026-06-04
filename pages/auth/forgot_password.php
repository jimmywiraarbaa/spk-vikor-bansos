<?php
require_once '../../includes/auth_helper.php';
isGuest();
include_once '../../templates/header.php';

$step = 'email';
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if ($token && $email) {
    require_once '../../includes/db.php';
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND email = ? AND expires_at > NOW()");
    $stmt->execute([$token, $email]);
    $reset = $stmt->fetch();

    if ($reset) {
        $step = 'reset';
    } else {
        $_SESSION['error'] = "Link reset password tidak valid atau sudah kedaluwarsa. Silakan coba lagi.";
    }
}
?>

<div class="container-fluid vh-100">
    <div class="row h-100">
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5 text-center animate-left"
            style="background: linear-gradient(135deg, #d9534f 0%, #c9302c 100%) !important;">
            <h1 class="display-4 fw-bold mb-4">SPK VIKOR</h1>
            <h2 class="h4 mb-4 fw-light" style="line-height: 1.6;">
                SISTEM PENDUKUNG KEPUTUSAN PENENTUAN PENERIMA BANTUAN LANGSUNG TUNAI KESEJAHTERAAN
                MENGGUNAKAN METODE VIKOR <br>
                <span class="small opacity-75">(VlseKriterijumska Optimizacija I Kompromisno Resenje)</span>
            </h2>
            <hr class="w-25 border-white opacity-50 mb-4">
            <img src="<?php echo baseUrl('public/img/logo-remove-bg.png'); ?>" alt="Logo Instansi" class="mb-4"
                style="max-height: 120px; width: auto;">
            <h3 class="h5 fw-normal">
                PADA DINAS SOSIAL, PEMBERDAYAAN PEREMPUAN, <br>
                DAN PERLINDUNGAN ANAK KABUPATEN MERANGIN
            </h3>
        </div>

        <div class="col-lg-5 d-flex align-items-center justify-content-center bg-light">
            <div class="card border-0 shadow-sm p-4 w-100 animate-right" style="max-width: 450px; border-radius: 15px;">
                <div class="card-body">
                    <div class="d-lg-none text-center mb-4">
                        <h1 class="fw-bold text-primary">SPK VIKOR</h1>
                        <p class="small text-muted">DINAS SOSIAL KABUPATEN MERANGIN</p>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success'];
                            unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($step === 'email'): ?>
                        <h3 class="fw-bold mb-2">Lupa Password</h3>
                        <p class="text-muted mb-4">Masukkan email yang terdaftar. Kami akan mengirimkan link untuk mereset password Anda.</p>

                        <form action="../../actions/auth_action.php" method="POST" id="forgotForm">
                            <input type="hidden" name="forgot_password" value="1">
                            <div class="mb-3">
                                <label for="email" class="form-label text-secondary small fw-bold">EMAIL</label>
                                <input type="email" name="email" id="email"
                                    class="form-control form-control-lg bg-light border-0"
                                    style="font-size: 0.95rem;" required placeholder="Masukkan email terdaftar">
                            </div>
                            <button type="submit"
                                class="btn btn-primary btn-lg w-100 mb-3 shadow-sm" style="border-radius: 10px;">
                                <span class="spinner-border spinner-border-sm d-none" id="forgotSpinner" aria-hidden="true"></span>
                                <span id="forgotText">Kirim Link Reset</span>
                            </button>
                        </form>

                    <?php elseif ($step === 'reset'): ?>
                        <h3 class="fw-bold mb-2">Reset Password</h3>
                        <p class="text-muted mb-4">Buat password baru untuk akun <strong><?php echo htmlspecialchars($email); ?></strong></p>

                        <form action="../../actions/auth_action.php" method="POST" id="resetForm">
                            <input type="hidden" name="reset_password" value="1">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                            <div class="mb-3">
                                <label for="new_password" class="form-label text-secondary small fw-bold">PASSWORD BARU</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control form-control-lg bg-light border-0"
                                    style="font-size: 0.95rem;" required placeholder="Minimal 6 karakter" minlength="6">
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label text-secondary small fw-bold">KONFIRMASI PASSWORD</label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control form-control-lg bg-light border-0"
                                    style="font-size: 0.95rem;" required placeholder="Ulangi password baru" minlength="6">
                            </div>
                            <button type="submit"
                                class="btn btn-primary btn-lg w-100 mb-3 shadow-sm" style="border-radius: 10px;">
                                <span class="spinner-border spinner-border-sm d-none" id="resetSpinner" aria-hidden="true"></span>
                                <span id="resetText">Simpan Password Baru</span>
                            </button>
                        </form>
                    <?php endif; ?>

                    <div class="text-center">
                        <span class="small text-muted">
                            <a href="login.php" class="text-decoration-none fw-bold">Kembali ke Login</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>
