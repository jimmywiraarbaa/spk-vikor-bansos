<?php
require_once '../../includes/auth_helper.php';
checkLogin();

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Akses ditolak.";
    header("Location: " . baseUrl('pages/dashboard.php'));
    exit;
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
                            <h4 class="fw-bold mb-0">Tambah User</h4>
                            <p class="text-muted small">Tambahkan akun pengguna baru ke sistem.</p>
                        </div>
                        <a href="index.php" class="btn btn-light btn-sm border px-3 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card border-0 shadow-sm p-4">
                        <form action="../../actions/user_action.php" method="POST" id="formTambahUser">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label small fw-bold text-secondary">USERNAME</label>
                                    <input type="text" name="username" id="username" class="form-control bg-light border-0" placeholder="Masukkan username" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-bold text-secondary">EMAIL</label>
                                    <input type="email" name="email" id="email" class="form-control bg-light border-0" placeholder="Masukkan email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label small fw-bold text-secondary">PASSWORD</label>
                                    <input type="password" name="password" id="password" class="form-control bg-light border-0" placeholder="Masukkan password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label small fw-bold text-secondary">KONFIRMASI PASSWORD</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control bg-light border-0" placeholder="Ulangi password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label small fw-bold text-secondary">ROLE</label>
                                    <select name="role" id="role" class="form-select bg-light border-0" required>
                                        <option value="operator">Operator</option>
                                        <option value="admin">Admin</option>
                                        <option value="kepala_dinsos">Kepala Dinas Sosial</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="tambah" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Simpan User
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

<script>
document.getElementById('formTambahUser').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirm = document.getElementById('confirm_password').value;
    if (password !== confirm) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok.');
    }
});
</script>

<?php include_once '../../templates/footer.php'; ?>
