<?php
require_once '../../includes/auth_helper.php';
isGuest();
include '../../templates/header.php';
?>

<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Sisi Kiri: Judul Sistem -->
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5 text-center animate-left" style="background: linear-gradient(135deg, #d9534f 0%, #c9302c 100%) !important;">
            <h1 class="display-4 fw-bold mb-4">SPK VIKOR</h1>
            <h2 class="h4 mb-4 fw-light" style="line-height: 1.6;">
                SISTEM PENDUKUNG KEPUTUSAN PENENTUAN PENERIMA BANTUAN LANGSUNG TUNAI KESEJAHTERAAN 
                MENGGUNAKAN METODE VIKOR <br>
                <span class="small opacity-75">(VlseKriterijumska Optimizacija I Kompromisno Resenje)</span>
            </h2>
            <hr class="w-25 border-white opacity-50 mb-4">
            <img src="<?php echo base_url('public/img/logo-remove-bg.png'); ?>" alt="Logo Instansi" class="mb-4" style="max-height: 120px; width: auto;">
            <h3 class="h5 fw-normal">
                PADA DINAS SOSIAL, PEMBERDAYAAN PEREMPUAN, <br>
                DAN PERLINDUNGAN ANAK KABUPATEN MERANGIN
            </h3>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center bg-light">
            <div class="card border-0 shadow-sm p-4 w-100 animate-right" style="max-width: 450px; border-radius: 15px;">
                <div class="card-body">
                    <div class="d-lg-none text-center mb-4">
                        <h1 class="fw-bold text-primary">SPK VIKOR</h1>
                        <p class="small text-muted">DINAS SOSIAL KABUPATEN MERANGIN</p>
                    </div>

                    <h3 class="fw-bold mb-2">Selamat Datang</h3>
                    <p class="text-muted mb-4">Silakan masuk untuk mengelola data</p>

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

                    <form action="../../actions/auth_action.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">USERNAME</label>
                            <input type="text" name="username" class="form-control form-control-lg bg-light border-0" style="font-size: 0.95rem;" required placeholder="Masukkan username">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">PASSWORD</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0" style="font-size: 0.95rem;" required placeholder="Masukkan password">
                                <button class="btn btn-light border-0 bg-light" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-lg w-100 mb-3 shadow-sm" style="border-radius: 10px;">Login</button>
                    </form>

                    <!-- <div class="text-center">
                        <span class="small text-muted">Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold">Daftar Akun</a></span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>