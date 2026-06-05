<?php
require_once '../includes/auth_helper.php';
checkLogin();
include_once '../templates/header.php';
?>

<div id="wrapper">
    <!-- Sidebar -->
    <?php include_once '../templates/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg top-navbar">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>

                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser" data-bs-toggle="dropdown">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </div>
                            <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                            <i class="bi bi-chevron-down user-arrow-icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="dropdownUser">
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-danger" href="<?php echo baseUrl('actions/auth_action.php?logout=1'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Body -->
        <div class="main-content">
            <div class="row mb-4 animate-up">
                <div class="col-12">
                    <h4 class="fw-bold">Dashboard Overview</h4>
                    <p class="text-muted">Selamat datang kembali di panel kendali SPK VIKOR.</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5 animate-up delay-1">
                <div class="col-sm-6 col-md-3">
                    <div class="card p-3 h-100 border-start border-danger border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2 small fw-bold">TOTAL KRITERIA</h6>
                                    <h3 class="fw-bold mb-0">5</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                    <i class="bi bi-list-check text-danger fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card p-3 h-100 border-start border-primary border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2 small fw-bold">ALTERNATIF</h6>
                                    <h3 class="fw-bold mb-0">120</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                    <i class="bi bi-people text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card p-3 h-100 border-start border-success border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2 small fw-bold">PERHITUNGAN</h6>
                                    <h3 class="fw-bold mb-0">8</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card p-3 h-100 border-start border-warning border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2 small fw-bold">USER AKTIF</h6>
                                    <h3 class="fw-bold mb-0">3</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                    <i class="bi bi-person-check text-warning fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card h-100 p-4">
                        <h5 class="fw-bold mb-4">Informasi Sistem</h5>
                        <p>Sistem Pendukung Keputusan Penentuan Penerima Bantuan Langsung Tunai (BLT) dengan Metode VIKOR pada Dinas Sosial Kabupaten Merangin.</p>
                        <div class="alert alert-info border-0 bg-opacity-10">
                            <i class="bi bi-info-circle me-2"></i> Anda dapat mulai dengan mengisi <strong>Data Kriteria</strong> kemudian dilanjutkan dengan <strong>Data Alternatif</strong> untuk melakukan perhitungan.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 p-4 text-center">
                        <img src="<?php echo baseUrl('public/img/logo-remove-bg.png'); ?>" alt="Logo Dinas Sosial Kabupaten Merangin" class="mx-auto mb-3" style="max-height: 100px;">
                        <h6 class="fw-bold">Dinas Sosial</h6>
                        <p class="small text-muted">Kabupaten Merangin, Jambi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>